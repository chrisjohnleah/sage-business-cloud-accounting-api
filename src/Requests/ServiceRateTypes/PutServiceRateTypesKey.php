<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\ServiceRateTypes;

use ChrisJohnLeah\SageAccounting\Data\ServiceRateType;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Updates a Service Rate Type
 *
 * PUT /service_rate_types/{key}
 */
class PutServiceRateTypesKey extends Request implements HasBody
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
        return str_replace('{key}', rawurlencode($this->key), '/service_rate_types/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?ServiceRateType
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return ServiceRateType::fromArray($data);
    }
}
