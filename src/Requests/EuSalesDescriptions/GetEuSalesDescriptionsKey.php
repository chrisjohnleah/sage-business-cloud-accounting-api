<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\EuSalesDescriptions;

use ChrisJohnLeah\SageAccounting\Data\EuSalesDescription;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Returns a EU Sales Description
 *
 * GET /eu_sales_descriptions/{key}
 */
class GetEuSalesDescriptionsKey extends Request
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
        return str_replace('{key}', rawurlencode($this->key), '/eu_sales_descriptions/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }

    public function createDtoFromResponse(Response $response): ?EuSalesDescription
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return EuSalesDescription::fromArray($data);
    }
}
