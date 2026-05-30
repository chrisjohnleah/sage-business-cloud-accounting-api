<?php

declare(strict_types=1);

/**
 * Spec-driven SDK generator.
 *
 * Reads the Sage Business Cloud Accounting OpenAPI spec and generates a typed
 * DTO for every schema and a Saloon request for every operation, in the
 * project's house style. Hand-crafted infrastructure (SageConnector, Sage,
 * SageRequest, SagePaginator, Reference, Paginated, MapsAttributes, the token
 * layer) is NOT touched.
 *
 * Run:  php tools/generate.php
 */
$root = dirname(__DIR__);
$spec = json_decode((string) file_get_contents($root.'/resources/openapi/sage-accounting-3.1.0.json'), true);

$schemas = $spec['components']['schemas'] ?? [];
$paths = $spec['paths'] ?? [];

const NS = 'ChrisJohnLeah\\SageAccounting';

/** Schemas represented by hand-written infra (skip generating a DTO). */
$skipSchemas = ['Base' => 'Reference', 'Reference' => 'Reference', 'Paginated' => 'Paginated'];

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

$camel = static function (string $key): string {
    $key = ltrim($key, '$');
    $parts = preg_split('/[_\s\-]+/', $key) ?: [$key];
    $studly = implode('', array_map('ucfirst', $parts));

    return lcfirst($studly);
};

$studly = static function (string $key): string {
    $key = ltrim($key, '$');
    $parts = preg_split('/[_\s\-]+/', $key) ?: [$key];

    return implode('', array_map('ucfirst', $parts));
};

$refToClass = static function (string $ref) use ($skipSchemas): string {
    $name = (string) substr($ref, (int) strrpos($ref, '/') + 1);

    return $skipSchemas[$name] ?? $name;
};

/**
 * Resolve a property schema to [phpType, defaultValue, mappingExpr, docType, needsDateImport].
 */
$mapProp = static function (array $prop, string $jsonKey) use ($refToClass): array {
    $q = var_export($jsonKey, true);

    if (isset($prop['$ref'])) {
        $cls = $refToClass($prop['$ref']);

        return ["?{$cls}", 'null', "{$cls}::fromNullable(self::nested(\$data, {$q}))", null, false];
    }

    $type = $prop['type'] ?? null;
    $format = $prop['format'] ?? null;

    if ($type === 'string' && in_array($format, ['date', 'date-time'], true)) {
        return ['?DateTimeImmutable', 'null', "self::dateTime(\$data, {$q})", null, true];
    }

    if ($type === 'string') {
        return ['?string', 'null', "self::string(\$data, {$q})", null, false];
    }

    if ($type === 'integer') {
        return ['?int', 'null', "self::integer(\$data, {$q})", null, false];
    }

    if ($type === 'number') {
        return ['?float', 'null', "self::float(\$data, {$q})", null, false];
    }

    if ($type === 'boolean') {
        return ['?bool', 'null', "self::boolean(\$data, {$q})", null, false];
    }

    if ($type === 'array') {
        $items = $prop['items'] ?? [];

        if (isset($items['$ref'])) {
            $cls = $refToClass($items['$ref']);
            $expr = "array_map(static fn (array \$item): {$cls} => {$cls}::fromArray(\$item), self::nestedList(\$data, {$q}))";

            return ['array', '[]', $expr, "list<{$cls}>", false];
        }

        return ['array', '[]', "self::rawList(\$data, {$q})", 'list<mixed>', false];
    }

    if ($type === 'object') {
        return ['?array', 'null', "self::nested(\$data, {$q})", 'array<string, mixed>|null', false];
    }

    return ['mixed', 'null', "self::raw(\$data, {$q})", null, false];
};

// ---------------------------------------------------------------------------
// Generate DTOs
// ---------------------------------------------------------------------------

$dataDir = $root.'/src/Data';
$dtoCount = 0;

foreach ($schemas as $name => $schema) {
    if (isset($skipSchemas[$name])) {
        continue;
    }
    if (! preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $name)) {
        fwrite(STDERR, "skip non-class schema: {$name}\n");

        continue;
    }

    $properties = $schema['properties'] ?? [];
    $ctorLines = [];
    $mapLines = [];
    $paramDocs = [];
    $needsDate = false;
    $seen = [];

    foreach ($properties as $jsonKey => $prop) {
        if (! is_array($prop)) {
            continue;
        }
        $php = $camel((string) $jsonKey);
        if ($php === '' || isset($seen[$php])) {
            continue;
        }
        $seen[$php] = true;

        [$type, $default, $expr, $docType, $date] = $mapProp($prop, (string) $jsonKey);
        $needsDate = $needsDate || $date;

        $ctorLines[] = "        public {$type} \${$php} = {$default},";
        $mapLines[] = "            {$php}: {$expr},";
        if ($docType !== null) {
            $paramDocs[] = "     * @param  {$docType}  \${$php}";
        }
    }

    $imports = ['use '.NS.'\\Data\\Concerns\\MapsAttributes;'];
    if ($needsDate) {
        $imports[] = 'use DateTimeImmutable;';
    }
    sort($imports);

    $ctorDoc = '';
    if ($paramDocs !== []) {
        $ctorDoc = "    /**\n".implode("\n", $paramDocs)."\n     */\n";
    }
    $ctorBody = $ctorLines === [] ? '' : "\n".implode("\n", $ctorLines)."\n    ";
    $mapBody = $mapLines === [] ? '' : "\n".implode("\n", $mapLines)."\n        ";

    $code = "<?php\n\ndeclare(strict_types=1);\n\nnamespace ".NS."\\Data;\n\n"
        .implode("\n", $imports)."\n\n"
        ."final readonly class {$name}\n{\n"
        ."    use MapsAttributes;\n\n"
        .$ctorDoc
        ."    public function __construct({$ctorBody}) {}\n\n"
        ."    /**\n     * @param  array<string, mixed>  \$data\n     */\n"
        ."    public static function fromArray(array \$data): self\n    {\n"
        ."        return new self({$mapBody});\n    }\n\n"
        ."    /**\n     * @param  array<string, mixed>|null  \$data\n     */\n"
        ."    public static function fromNullable(?array \$data): ?self\n    {\n"
        ."        return \$data === null ? null : self::fromArray(\$data);\n    }\n}\n";

    file_put_contents("{$dataDir}/{$name}.php", $code);
    $dtoCount++;
}

// ---------------------------------------------------------------------------
// Generate Requests (grouped by first path segment)
// ---------------------------------------------------------------------------

$reqDir = $root.'/src/Requests';
// Clean previously hand-written flat requests (replaced by generated ones).
foreach (glob("{$reqDir}/*.php") ?: [] as $f) {
    unlink($f);
}

$resolveResponseDto = static function (array $op) use ($refToClass): ?string {
    foreach (['200', '201', '202'] as $code) {
        $schema = $op['responses'][$code]['content']['application/json']['schema'] ?? null;
        if (is_array($schema) && isset($schema['$ref'])) {
            return $refToClass($schema['$ref']);
        }
    }

    return null;
};

$reqCount = 0;
$manifest = [];

foreach ($paths as $path => $item) {
    if (! is_array($item)) {
        continue;
    }
    $segments = array_values(array_filter(explode('/', (string) $path)));
    $group = $studly($segments[0] ?? 'general');
    $pathParams = [];
    preg_match_all('/\{([^}]+)\}/', (string) $path, $m);
    foreach ($m[1] as $p) {
        $pathParams[] = $p;
    }

    foreach ($item as $method => $op) {
        $method = strtolower((string) $method);
        if (! in_array($method, ['get', 'post', 'put', 'delete'], true) || ! is_array($op)) {
            continue;
        }

        $opId = isset($op['operationId']) && is_string($op['operationId']) ? $op['operationId'] : null;
        $class = $opId !== null
            ? $studly($opId)
            : $studly($method).implode('', array_map($studly, array_map(static fn ($s) => trim($s, '{}'), $segments)));
        $class = preg_replace('/[^A-Za-z0-9_]/', '', $class) ?: 'UnknownRequest';

        $isCollectionGet = $method === 'get' && $pathParams === [];
        $dto = $resolveResponseDto($op);

        // Build endpoint expression with path-param substitution.
        $endpointExpr = var_export((string) $path, true);
        foreach ($pathParams as $p) {
            $prop = $camel($p);
            $endpointExpr = "str_replace('{".$p."}', rawurlencode(\$this->{$prop}), {$endpointExpr})";
        }

        $imports = ['use Saloon\\Enums\\Method;', 'use Saloon\\Http\\Response;'];
        $ctorParams = [];
        foreach ($pathParams as $p) {
            $ctorParams[] = "private readonly string \${$camel($p)}";
        }

        $methodConst = strtoupper($method);
        $body = '';
        $extends = 'Request';
        $implements = '';
        $traits = '';
        $extra = '';
        $dtoMethod = '';

        if ($isCollectionGet) {
            // Paginatable list endpoint.
            $imports[] = 'use '.NS.'\\Data\\Paginated;';
            $imports[] = 'use '.NS.'\\Http\\SageRequest;';
            $extends = 'SageRequest';
            $ctorParams[] = 'private readonly array $filters = []';
            $extra = "\n    /**\n     * @return array<string, mixed>\n     */\n    protected function defaultQuery(): array\n    {\n        return array_filter(\$this->filters, static fn (mixed \$v): bool => \$v !== null);\n    }\n";
            $dtoMethod = "\n    public function createDtoFromResponse(Response \$response): Paginated\n    {\n        \$data = \$response->json();\n\n        /** @var array<string, mixed> \$payload */\n        \$payload = is_array(\$data) ? \$data : [];\n\n        return Paginated::fromArray(\$payload);\n    }\n";
            $endpointMethod = "    protected function endpoint(): string\n    {\n        return {$endpointExpr};\n    }\n";
            $methodProp = '';
        } else {
            $imports[] = 'use Saloon\\Http\\Request;';
            $methodProp = "    protected Method \$method = Method::{$methodConst};\n\n";
            if (in_array($method, ['post', 'put'], true)) {
                $imports[] = 'use Saloon\\Contracts\\Body\\HasBody;';
                $imports[] = 'use Saloon\\Traits\\Body\\HasJsonBody;';
                $implements = ' implements HasBody';
                $traits = "    use HasJsonBody;\n\n";
                $ctorParams[] = '/** @var array<string, mixed> */ private readonly array $payload = []';
                $extra = "\n    /**\n     * @return array<string, mixed>\n     */\n    protected function defaultBody(): array\n    {\n        return \$this->payload;\n    }\n";
            } elseif ($method === 'get') {
                $ctorParams[] = 'private readonly array $filters = []';
                $extra = "\n    /**\n     * @return array<string, mixed>\n     */\n    protected function defaultQuery(): array\n    {\n        return array_filter(\$this->filters, static fn (mixed \$v): bool => \$v !== null);\n    }\n";
            }
            if ($dto !== null && in_array($method, ['get', 'post', 'put'], true)) {
                $imports[] = 'use '.NS.'\\Data\\'.$dto.';';
                $dtoMethod = "\n    public function createDtoFromResponse(Response \$response): ?{$dto}\n    {\n        \$data = \$response->json();\n\n        if (! is_array(\$data)) {\n            return null;\n        }\n\n        /** @var array<string, mixed> \$data */\n        return {$dto}::fromArray(\$data);\n    }\n";
            }
            $endpointMethod = "    public function resolveEndpoint(): string\n    {\n        return {$endpointExpr};\n    }\n";
        }

        $imports = array_values(array_unique($imports));
        sort($imports);

        // Clean the inline payload marker, then document every array param.
        $ctorParams = array_map(static function (string $cp): string {
            return str_replace('/** @var array<string, mixed> */ ', '', $cp);
        }, $ctorParams);
        $docs = [];
        foreach ($ctorParams as $cp) {
            if (str_contains($cp, '$filters')) {
                $docs[] = '     * @param  array<string, mixed>  $filters';
            }
            if (str_contains($cp, '$payload')) {
                $docs[] = '     * @param  array<string, mixed>  $payload';
            }
        }
        $ctorDoc = $docs === [] ? '' : "    /**\n".implode("\n", $docs)."\n     */\n";

        $ctor = $ctorParams === []
            ? "    public function __construct() {}\n"
            : "{$ctorDoc}    public function __construct(\n        ".implode(",\n        ", $ctorParams).",\n    ) {}\n";

        $desc = isset($op['summary']) && is_string($op['summary']) ? $op['summary'] : strtoupper($method).' '.$path;
        $desc = str_replace(["\n", "\r"], ' ', $desc);

        $code = "<?php\n\ndeclare(strict_types=1);\n\nnamespace ".NS."\\Requests\\{$group};\n\n"
            .implode("\n", $imports)."\n\n"
            ."/**\n * {$desc}\n *\n * {$methodConst} {$path}\n */\n"
            ."class {$class} extends {$extends}{$implements}\n{\n"
            .$traits
            .$methodProp
            .$ctor
            .($extends === 'SageRequest' ? "\n{$endpointMethod}" : "\n{$endpointMethod}")
            .$extra
            .$dtoMethod
            ."}\n";

        $dir = "{$reqDir}/{$group}";
        if (! is_dir($dir)) {
            mkdir($dir, 0o755, true);
        }
        file_put_contents("{$dir}/{$class}.php", $code);
        $reqCount++;
        $manifest[$group][] = $class;
    }
}

file_put_contents($root.'/resources/openapi/generated-manifest.json', json_encode([
    'dtos' => $dtoCount,
    'requests' => $reqCount,
    'groups' => array_map('count', $manifest),
], JSON_PRETTY_PRINT));

echo "Generated {$dtoCount} DTOs and {$reqCount} requests across ".count($manifest)." resource groups.\n";
