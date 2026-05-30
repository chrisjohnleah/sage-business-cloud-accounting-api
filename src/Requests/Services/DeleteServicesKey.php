<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\Services;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Service
 *
 * DELETE /services/{key}
 */
class DeleteServicesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/services/{key}');
    }
}
