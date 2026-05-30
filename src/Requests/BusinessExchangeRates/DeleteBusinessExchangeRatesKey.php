<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\BusinessExchangeRates;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Business Exchange Rate
 *
 * DELETE /business_exchange_rates/{key}
 */
class DeleteBusinessExchangeRatesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/business_exchange_rates/{key}');
    }
}
