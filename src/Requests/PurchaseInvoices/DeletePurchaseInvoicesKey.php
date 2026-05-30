<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\PurchaseInvoices;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Purchase Invoice
 *
 * DELETE /purchase_invoices/{key}
 */
class DeletePurchaseInvoicesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/purchase_invoices/{key}');
    }
}
