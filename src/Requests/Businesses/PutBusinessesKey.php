<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\Businesses;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Updates a Business
 *
 * PUT /businesses/{key}
 */
class PutBusinessesKey extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        private readonly string $key,
        private readonly array $payload = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/businesses/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }
}
