<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class ArtefactDetailedTaxAnalysisBreakdown
{
    use MapsAttributes;

    public function __construct(
        public ?TaxRate $taxRate = null,
        public ?string $name = null,
        public ?float $percentage = null,
        public ?float $netAmount = null,
        public ?float $taxAmount = null,
        public ?float $retailTaxAmount = null,
        public ?float $totalAmount = null,
        public ?float $goodsAmount = null,
        public ?float $servicesAmount = null,
        public ?float $baseCurrencyNetAmount = null,
        public ?float $baseCurrencyTaxAmount = null,
        public ?float $baseCurrencyTotalAmount = null,
        public ?float $baseCurrencyGoodsAmount = null,
        public ?float $baseCurrencyServicesAmount = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            taxRate: TaxRate::fromNullable(self::nested($data, 'tax_rate')),
            name: self::string($data, 'name'),
            percentage: self::float($data, 'percentage'),
            netAmount: self::float($data, 'net_amount'),
            taxAmount: self::float($data, 'tax_amount'),
            retailTaxAmount: self::float($data, 'retail_tax_amount'),
            totalAmount: self::float($data, 'total_amount'),
            goodsAmount: self::float($data, 'goods_amount'),
            servicesAmount: self::float($data, 'services_amount'),
            baseCurrencyNetAmount: self::float($data, 'base_currency_net_amount'),
            baseCurrencyTaxAmount: self::float($data, 'base_currency_tax_amount'),
            baseCurrencyTotalAmount: self::float($data, 'base_currency_total_amount'),
            baseCurrencyGoodsAmount: self::float($data, 'base_currency_goods_amount'),
            baseCurrencyServicesAmount: self::float($data, 'base_currency_services_amount'),
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
