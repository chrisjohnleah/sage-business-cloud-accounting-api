<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\SalesEstimates;

use ChrisJohnLeah\SageAccounting\Data\SalesEstimate;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Returns a Sales Estimate
 *
 * GET /sales_estimates/{key}
 */
class GetSalesEstimatesKey extends Request
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
        return str_replace('{key}', rawurlencode($this->key), '/sales_estimates/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }

    public function createDtoFromResponse(Response $response): ?SalesEstimate
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return SalesEstimate::fromArray($data);
    }
}
