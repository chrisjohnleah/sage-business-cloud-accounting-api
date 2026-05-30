<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class ArtefactDetailedTaxAnalysis
{
    use MapsAttributes;

    public function __construct(
        public ?ArtefactDetailedTaxAnalysisBreakdown $taxRatesBreakdown = null,
        public ?float $totalNet = null,
        public ?float $totalTax = null,
        public ?float $total = null,
        public ?float $totalGoodsAmount = null,
        public ?float $totalServicesAmount = null,
        public ?float $baseCurrencyTotalNet = null,
        public ?float $baseCurrencyTotalTax = null,
        public ?float $baseCurrencyTotal = null,
        public ?float $baseCurrencyTotalGoodsAmount = null,
        public ?float $baseCurrencyTotalServicesAmount = null,
        public ?float $totalRetailerTax = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            taxRatesBreakdown: ArtefactDetailedTaxAnalysisBreakdown::fromNullable(self::nested($data, 'tax_rates_breakdown')),
            totalNet: self::float($data, 'total_net'),
            totalTax: self::float($data, 'total_tax'),
            total: self::float($data, 'total'),
            totalGoodsAmount: self::float($data, 'total_goods_amount'),
            totalServicesAmount: self::float($data, 'total_services_amount'),
            baseCurrencyTotalNet: self::float($data, 'base_currency_total_net'),
            baseCurrencyTotalTax: self::float($data, 'base_currency_total_tax'),
            baseCurrencyTotal: self::float($data, 'base_currency_total'),
            baseCurrencyTotalGoodsAmount: self::float($data, 'base_currency_total_goods_amount'),
            baseCurrencyTotalServicesAmount: self::float($data, 'base_currency_total_services_amount'),
            totalRetailerTax: self::float($data, 'total_retailer_tax'),
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
