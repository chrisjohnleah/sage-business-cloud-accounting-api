<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class putProductSalesPriceTypes
{
    use MapsAttributes;

    /**
     * @param  array<string, mixed>|null  $productSalesPriceType
     */
    public function __construct(
        public ?array $productSalesPriceType = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            productSalesPriceType: self::nested($data, 'product_sales_price_type'),
        );
    }

    /**
     * @param  array<string, mixed>|null  $data
     */
    public static function fromNullable(?array $data): ?self
    {
        return $data === null ? null : self::fromArray($data);
    }
}
