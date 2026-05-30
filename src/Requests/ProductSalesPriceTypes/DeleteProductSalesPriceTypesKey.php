<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\ProductSalesPriceTypes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Product Sales Price Type
 *
 * DELETE /product_sales_price_types/{key}
 */
class DeleteProductSalesPriceTypesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/product_sales_price_types/{key}');
    }
}
