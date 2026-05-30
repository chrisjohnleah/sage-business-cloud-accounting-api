<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\LedgerAccountOpeningBalances;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Ledger Account Opening Balance
 *
 * DELETE /ledger_account_opening_balances/{key}
 */
class DeleteLedgerAccountOpeningBalancesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/ledger_account_opening_balances/{key}');
    }
}
