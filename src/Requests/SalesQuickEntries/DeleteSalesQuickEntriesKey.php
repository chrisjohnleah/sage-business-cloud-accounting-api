<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\SalesQuickEntries;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Sales Quick Entry
 *
 * DELETE /sales_quick_entries/{key}
 */
class DeleteSalesQuickEntriesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/sales_quick_entries/{key}');
    }
}
