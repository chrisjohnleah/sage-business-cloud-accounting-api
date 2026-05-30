<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\ContactPayments;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Contact Payment
 *
 * DELETE /contact_payments/{key}
 */
class DeleteContactPaymentsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/contact_payments/{key}');
    }
}
