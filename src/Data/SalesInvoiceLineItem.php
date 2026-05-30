<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class SalesInvoiceLineItem
{
    use MapsAttributes;

    /**
     * @param  list<AnalysisTypeLineItem>  $analysisTypeCategories
     * @param  list<TaxBreakdown>  $taxBreakdown
     * @param  list<TaxBreakdown>  $baseCurrencyTaxBreakdown
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public array $analysisTypeCategories = [],
        public ?string $description = null,
        public ?Product $product = null,
        public ?Service $service = null,
        public ?Reference $ledgerAccount = null,
        public ?bool $tradeOfAsset = null,
        public ?float $quantity = null,
        public ?float $unitPrice = null,
        public ?float $netAmount = null,
        public ?Reference $taxRate = null,
        public ?float $taxAmount = null,
        public array $taxBreakdown = [],
        public ?float $totalAmount = null,
        public ?float $baseCurrencyUnitPrice = null,
        public ?bool $unitPriceIncludesTax = null,
        public ?float $baseCurrencyNetAmount = null,
        public ?float $baseCurrencyTaxAmount = null,
        public array $baseCurrencyTaxBreakdown = [],
        public ?float $baseCurrencyTotalAmount = null,
        public ?Reference $euGoodsServicesType = null,
        public ?float $discountAmount = null,
        public ?float $baseCurrencyDiscountAmount = null,
        public ?float $discountPercentage = null,
        public ?EuSalesDescription $euSalesDescription = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: self::string($data, 'id'),
            displayedAs: self::string($data, 'displayed_as'),
            analysisTypeCategories: array_map(static fn (array $item): AnalysisTypeLineItem => AnalysisTypeLineItem::fromArray($item), self::nestedList($data, 'analysis_type_categories')),
            description: self::string($data, 'description'),
            product: Product::fromNullable(self::nested($data, 'product')),
            service: Service::fromNullable(self::nested($data, 'service')),
            ledgerAccount: Reference::fromNullable(self::nested($data, 'ledger_account')),
            tradeOfAsset: self::boolean($data, 'trade_of_asset'),
            quantity: self::float($data, 'quantity'),
            unitPrice: self::float($data, 'unit_price'),
            netAmount: self::float($data, 'net_amount'),
            taxRate: Reference::fromNullable(self::nested($data, 'tax_rate')),
            taxAmount: self::float($data, 'tax_amount'),
            taxBreakdown: array_map(static fn (array $item): TaxBreakdown => TaxBreakdown::fromArray($item), self::nestedList($data, 'tax_breakdown')),
            totalAmount: self::float($data, 'total_amount'),
            baseCurrencyUnitPrice: self::float($data, 'base_currency_unit_price'),
            unitPriceIncludesTax: self::boolean($data, 'unit_price_includes_tax'),
            baseCurrencyNetAmount: self::float($data, 'base_currency_net_amount'),
            baseCurrencyTaxAmount: self::float($data, 'base_currency_tax_amount'),
            baseCurrencyTaxBreakdown: array_map(static fn (array $item): TaxBreakdown => TaxBreakdown::fromArray($item), self::nestedList($data, 'base_currency_tax_breakdown')),
            baseCurrencyTotalAmount: self::float($data, 'base_currency_total_amount'),
            euGoodsServicesType: Reference::fromNullable(self::nested($data, 'eu_goods_services_type')),
            discountAmount: self::float($data, 'discount_amount'),
            baseCurrencyDiscountAmount: self::float($data, 'base_currency_discount_amount'),
            discountPercentage: self::float($data, 'discount_percentage'),
            euSalesDescription: EuSalesDescription::fromNullable(self::nested($data, 'eu_sales_description')),
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
