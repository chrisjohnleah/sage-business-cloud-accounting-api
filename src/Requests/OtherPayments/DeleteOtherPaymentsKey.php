<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\OtherPayments;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Other Payment
 *
 * DELETE /other_payments/{key}
 */
class DeleteOtherPaymentsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/other_payments/{key}');
    }
}
