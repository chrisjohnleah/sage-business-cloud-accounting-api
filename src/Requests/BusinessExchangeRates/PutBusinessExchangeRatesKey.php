<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\BusinessExchangeRates;

use ChrisJohnLeah\SageAccounting\Data\BusinessExchangeRate;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Updates a Business Exchange Rate
 *
 * PUT /business_exchange_rates/{key}
 */
class PutBusinessExchangeRatesKey extends Request implements HasBody
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
        return str_replace('{key}', rawurlencode($this->key), '/business_exchange_rates/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?BusinessExchangeRate
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return BusinessExchangeRate::fromArray($data);
    }
}
