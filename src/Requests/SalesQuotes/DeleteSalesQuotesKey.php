<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\SalesQuotes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Sales Quote
 *
 * DELETE /sales_quotes/{key}
 */
class DeleteSalesQuotesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/sales_quotes/{key}');
    }
}
