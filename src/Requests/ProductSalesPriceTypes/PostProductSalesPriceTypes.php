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
 * Creates a Product Sales Price Type
 *
 * POST /product_sales_price_types
 */
class PostProductSalesPriceTypes extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        private readonly array $payload = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/product_sales_price_types';
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
