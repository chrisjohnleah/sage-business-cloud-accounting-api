<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\Journals;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Journal
 *
 * DELETE /journals/{key}
 */
class DeleteJournalsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/journals/{key}');
    }
}
