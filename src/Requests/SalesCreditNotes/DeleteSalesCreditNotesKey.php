<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\SalesCreditNotes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Voids a Sales Credit Note
 *
 * DELETE /sales_credit_notes/{key}
 */
class DeleteSalesCreditNotesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/sales_credit_notes/{key}');
    }
}
