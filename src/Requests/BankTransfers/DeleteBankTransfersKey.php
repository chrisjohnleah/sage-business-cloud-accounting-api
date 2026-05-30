<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\BankTransfers;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Bank Transfer
 *
 * DELETE /bank_transfers/{key}
 */
class DeleteBankTransfersKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/bank_transfers/{key}');
    }
}
