<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\DraftTaxReturns;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Draft Tax Return
 *
 * DELETE /draft_tax_returns/{key}
 */
class DeleteDraftTaxReturnsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/draft_tax_returns/{key}');
    }
}
