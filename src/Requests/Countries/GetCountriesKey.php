<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\Countries;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Returns a Country
 *
 * GET /countries/{key}
 */
class GetCountriesKey extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $filters
     */
    public function __construct(
        private readonly string $key,
        private readonly array $filters = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/countries/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }
}
