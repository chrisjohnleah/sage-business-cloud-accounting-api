<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\BankAccounts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Bank Account
 *
 * DELETE /bank_accounts/{key}
 */
class DeleteBankAccountsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/bank_accounts/{key}');
    }
}
