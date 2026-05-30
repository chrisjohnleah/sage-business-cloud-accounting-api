<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\BusinessActivityTypes;

use ChrisJohnLeah\SageAccounting\Data\BusinessActivityType;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Returns a Business Activity Type
 *
 * GET /business_activity_types/{key}
 */
class GetBusinessActivityTypesKey extends Request
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
        return str_replace('{key}', rawurlencode($this->key), '/business_activity_types/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }

    public function createDtoFromResponse(Response $response): ?BusinessActivityType
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return BusinessActivityType::fromArray($data);
    }
}
