<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

/**
 * A single line on a purchase invoice — the goods/services bought, with their
 * net, tax and gross amounts in both the document and the base currency.
 */
final readonly class PurchaseInvoiceLineItem
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $description = null,
        public ?float $quantity = null,
        public ?float $unitPrice = null,
        public ?float $netAmount = null,
        public ?float $taxAmount = null,
        public ?float $totalAmount = null,
        public ?float $baseCurrencyUnitPrice = null,
        public ?float $baseCurrencyNetAmount = null,
        public ?float $baseCurrencyTaxAmount = null,
        public ?float $baseCurrencyTotalAmount = null,
        public ?bool $unitPriceIncludesTax = null,
        public ?bool $isPurchaseForResale = null,
        public ?bool $tradeOfAsset = null,
        public ?bool $taxRecoverable = null,
        public ?float $gstAmount = null,
        public ?float $pstAmount = null,
        public ?Reference $ledgerAccount = null,
        public ?Reference $taxRate = null,
        public ?Reference $euGoodsServicesType = null,
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
            description: self::string($data, 'description'),
            quantity: self::float($data, 'quantity'),
            unitPrice: self::float($data, 'unit_price'),
            netAmount: self::float($data, 'net_amount'),
            taxAmount: self::float($data, 'tax_amount'),
            totalAmount: self::float($data, 'total_amount'),
            baseCurrencyUnitPrice: self::float($data, 'base_currency_unit_price'),
            baseCurrencyNetAmount: self::float($data, 'base_currency_net_amount'),
            baseCurrencyTaxAmount: self::float($data, 'base_currency_tax_amount'),
            baseCurrencyTotalAmount: self::float($data, 'base_currency_total_amount'),
            unitPriceIncludesTax: self::boolean($data, 'unit_price_includes_tax'),
            isPurchaseForResale: self::boolean($data, 'is_purchase_for_resale'),
            tradeOfAsset: self::boolean($data, 'trade_of_asset'),
            taxRecoverable: self::boolean($data, 'tax_recoverable'),
            gstAmount: self::float($data, 'gst_amount'),
            pstAmount: self::float($data, 'pst_amount'),
            ledgerAccount: Reference::fromNullable(self::nested($data, 'ledger_account')),
            taxRate: Reference::fromNullable(self::nested($data, 'tax_rate')),
            euGoodsServicesType: Reference::fromNullable(self::nested($data, 'eu_goods_services_type')),
            // v0.1: not yet typed — analysis_type_categories
            // v0.1: not yet typed — product
            // v0.1: not yet typed — service
            // v0.1: not yet typed — tax_breakdown
            // v0.1: not yet typed — base_currency_tax_breakdown
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
