<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\ProductSalesPriceTypes;

use ChrisJohnLeah\SageAccounting\Data\ProductSalesPriceType;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Updates a Product Sales Price Type
 *
 * PUT /product_sales_price_types/{key}
 */
class PutProductSalesPriceTypesKey extends Request implements HasBody
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
        return str_replace('{key}', rawurlencode($this->key), '/product_sales_price_types/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?ProductSalesPriceType
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return ProductSalesPriceType::fromArray($data);
    }
}
