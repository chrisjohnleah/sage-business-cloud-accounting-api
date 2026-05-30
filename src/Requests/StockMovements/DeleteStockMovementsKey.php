<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\StockMovements;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Stock Movement
 *
 * DELETE /stock_movements/{key}
 */
class DeleteStockMovementsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/stock_movements/{key}');
    }
}
