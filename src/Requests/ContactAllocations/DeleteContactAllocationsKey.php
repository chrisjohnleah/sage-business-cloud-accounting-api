<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\ContactAllocations;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Contact Allocation
 *
 * DELETE /contact_allocations/{key}
 */
class DeleteContactAllocationsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/contact_allocations/{key}');
    }
}
