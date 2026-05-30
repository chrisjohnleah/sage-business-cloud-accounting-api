<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\StockMovements;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Returns a Stock Movement
 *
 * GET /stock_movements/{key}
 */
class GetStockMovementsKey extends Request
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
        return str_replace('{key}', rawurlencode($this->key), '/stock_movements/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }
}
