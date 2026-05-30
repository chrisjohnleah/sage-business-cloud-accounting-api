<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\PurchaseCreditNotes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Purchase Credit Note
 *
 * DELETE /purchase_credit_notes/{key}
 */
class DeletePurchaseCreditNotesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/purchase_credit_notes/{key}');
    }
}
