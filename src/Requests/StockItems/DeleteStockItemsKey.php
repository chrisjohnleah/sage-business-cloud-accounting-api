<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\StockItems;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Stock Item
 *
 * DELETE /stock_items/{key}
 */
class DeleteStockItemsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/stock_items/{key}');
    }
}
