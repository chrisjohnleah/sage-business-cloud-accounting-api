<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\ServiceRateTypes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Service Rate Type
 *
 * DELETE /service_rate_types/{key}
 */
class DeleteServiceRateTypesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/service_rate_types/{key}');
    }
}
