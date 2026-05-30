<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\SalesInvoices;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Voids a Sales Invoice
 *
 * DELETE /sales_invoices/{key}
 */
class DeleteSalesInvoicesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/sales_invoices/{key}');
    }
}
