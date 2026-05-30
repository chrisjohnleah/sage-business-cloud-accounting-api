<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\BusinessTypes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Returns a Business Type
 *
 * GET /business_types/{key}
 */
class GetBusinessTypesKey extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $filters
     */
    public function __construct(
        private readonly string $key,
        private readonly array $filters = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/business_types/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }
}
