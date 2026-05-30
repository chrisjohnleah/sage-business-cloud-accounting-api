<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\TaxRates;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Tax Rate (US only)
 *
 * DELETE /tax_rates/{key}
 */
class DeleteTaxRatesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/tax_rates/{key}');
    }
}
