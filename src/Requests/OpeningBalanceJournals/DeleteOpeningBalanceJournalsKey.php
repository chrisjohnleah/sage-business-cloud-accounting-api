<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\OpeningBalanceJournals;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Opening Balance Journal
 *
 * DELETE /opening_balance_journals/{key}
 */
class DeleteOpeningBalanceJournalsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/opening_balance_journals/{key}');
    }
}
