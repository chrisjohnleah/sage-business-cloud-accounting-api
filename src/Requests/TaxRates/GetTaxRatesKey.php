<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\TaxRates;

use ChrisJohnLeah\SageAccounting\Data\TaxRate;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Returns a Tax Rate
 *
 * GET /tax_rates/{key}
 */
class GetTaxRatesKey extends Request
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
        return str_replace('{key}', rawurlencode($this->key), '/tax_rates/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }

    public function createDtoFromResponse(Response $response): ?TaxRate
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return TaxRate::fromArray($data);
    }
}
