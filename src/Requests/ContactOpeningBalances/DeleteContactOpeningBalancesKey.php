<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\ContactOpeningBalances;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Contact Opening Balance
 *
 * DELETE /contact_opening_balances/{key}
 */
class DeleteContactOpeningBalancesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/contact_opening_balances/{key}');
    }
}
