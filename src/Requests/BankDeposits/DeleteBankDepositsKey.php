<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\BankDeposits;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Bank Deposit
 *
 * DELETE /bank_deposits/{key}
 */
class DeleteBankDepositsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/bank_deposits/{key}');
    }
}
