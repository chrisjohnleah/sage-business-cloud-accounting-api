<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\Products;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Product
 *
 * DELETE /products/{key}
 */
class DeleteProductsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/products/{key}');
    }
}
