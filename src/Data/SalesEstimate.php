<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class SalesEstimate
{
    use MapsAttributes;

    /**
     * @param  list<Link>  $links
     * @param  list<TaxBreakdown>  $shippingTaxBreakdown
     * @param  list<TaxBreakdown>  $baseCurrencyShippingTaxBreakdown
     * @param  list<SalesQuoteLineItem>  $estimateLines
     * @param  list<ArtefactTaxAnalysis>  $taxAnalysis
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public array $links = [],
        public ?bool $editable = null,
        public ?bool $vatReverseCharge = null,
        public ?string $taxCalculationMethod = null,
        public ?bool $destinationConsignment = null,
        public ?bool $destinationVatRatesInUse = null,
        public ?Contact $contact = null,
        public ?string $estimateNumberPrefix = null,
        public ?string $estimateNumber = null,
        public ?string $contactName = null,
        public ?string $contactReference = null,
        public ?DateTimeImmutable $date = null,
        public ?DateTimeImmutable $expiryDate = null,
        public ?string $reference = null,
        public ?string $mainAddressFreeForm = null,
        public ?SalesArtefactAddress $mainAddress = null,
        public ?string $deliveryAddressFreeForm = null,
        public ?SalesArtefactAddress $deliveryAddress = null,
        public ?string $notes = null,
        public ?string $termsAndConditions = null,
        public ?float $shippingNetAmount = null,
        public ?Reference $shippingTaxRate = null,
        public ?float $shippingTaxAmount = null,
        public array $shippingTaxBreakdown = [],
        public ?float $shippingTotalAmount = null,
        public ?float $netAmount = null,
        public ?float $taxAmount = null,
        public ?float $totalAmount = null,
        public ?Reference $currency = null,
        public ?float $exchangeRate = null,
        public ?float $inverseExchangeRate = null,
        public ?float $baseCurrencyShippingNetAmount = null,
        public ?float $baseCurrencyShippingTaxAmount = null,
        public array $baseCurrencyShippingTaxBreakdown = [],
        public ?float $baseCurrencyShippingTotalAmount = null,
        public ?float $totalQuantity = null,
        public ?float $totalDiscountAmount = null,
        public ?float $baseCurrencyTotalDiscountAmount = null,
        public ?float $baseCurrencyNetAmount = null,
        public ?float $baseCurrencyTaxAmount = null,
        public ?float $baseCurrencyTotalAmount = null,
        public ?float $paymentsAllocationsTotalAmount = null,
        public ?float $paymentsAllocationsTotalDiscount = null,
        public ?float $totalPaid = null,
        public ?QuoteStatus $status = null,
        public ?bool $sent = null,
        public ?bool $sentByEmail = null,
        public array $estimateLines = [],
        public array $taxAnalysis = [],
        public ?ArtefactDetailedTaxAnalysis $detailedTaxAnalysis = null,
        public ?Reference $taxAddressRegion = null,
        public ?float $withholdingTaxRate = null,
        public ?float $withholdingTaxAmount = null,
        public ?float $baseCurrencyWithholdingTaxAmount = null,
        public ?ProfitAnalysis $profitAnalysis = null,
        public ?bool $taxReconciled = null,
        public ?Generic $invoice = null,
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
            path: self::string($data, '$path'),
            createdAt: self::dateTime($data, 'created_at'),
            updatedAt: self::dateTime($data, 'updated_at'),
            links: array_map(static fn (array $item): Link => Link::fromArray($item), self::nestedList($data, 'links')),
            editable: self::boolean($data, 'editable'),
            vatReverseCharge: self::boolean($data, 'vat_reverse_charge'),
            taxCalculationMethod: self::string($data, 'tax_calculation_method'),
            destinationConsignment: self::boolean($data, 'destination_consignment'),
            destinationVatRatesInUse: self::boolean($data, 'destination_vat_rates_in_use'),
            contact: Contact::fromNullable(self::nested($data, 'contact')),
            estimateNumberPrefix: self::string($data, 'estimate_number_prefix'),
            estimateNumber: self::string($data, 'estimate_number'),
            contactName: self::string($data, 'contact_name'),
            contactReference: self::string($data, 'contact_reference'),
            date: self::dateTime($data, 'date'),
            expiryDate: self::dateTime($data, 'expiry_date'),
            reference: self::string($data, 'reference'),
            mainAddressFreeForm: self::string($data, 'main_address_free_form'),
            mainAddress: SalesArtefactAddress::fromNullable(self::nested($data, 'main_address')),
            deliveryAddressFreeForm: self::string($data, 'delivery_address_free_form'),
            deliveryAddress: SalesArtefactAddress::fromNullable(self::nested($data, 'delivery_address')),
            notes: self::string($data, 'notes'),
            termsAndConditions: self::string($data, 'terms_and_conditions'),
            shippingNetAmount: self::float($data, 'shipping_net_amount'),
            shippingTaxRate: Reference::fromNullable(self::nested($data, 'shipping_tax_rate')),
            shippingTaxAmount: self::float($data, 'shipping_tax_amount'),
            shippingTaxBreakdown: array_map(static fn (array $item): TaxBreakdown => TaxBreakdown::fromArray($item), self::nestedList($data, 'shipping_tax_breakdown')),
            shippingTotalAmount: self::float($data, 'shipping_total_amount'),
            netAmount: self::float($data, 'net_amount'),
            taxAmount: self::float($data, 'tax_amount'),
            totalAmount: self::float($data, 'total_amount'),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
            exchangeRate: self::float($data, 'exchange_rate'),
            inverseExchangeRate: self::float($data, 'inverse_exchange_rate'),
            baseCurrencyShippingNetAmount: self::float($data, 'base_currency_shipping_net_amount'),
            baseCurrencyShippingTaxAmount: self::float($data, 'base_currency_shipping_tax_amount'),
            baseCurrencyShippingTaxBreakdown: array_map(static fn (array $item): TaxBreakdown => TaxBreakdown::fromArray($item), self::nestedList($data, 'base_currency_shipping_tax_breakdown')),
            baseCurrencyShippingTotalAmount: self::float($data, 'base_currency_shipping_total_amount'),
            totalQuantity: self::float($data, 'total_quantity'),
            totalDiscountAmount: self::float($data, 'total_discount_amount'),
            baseCurrencyTotalDiscountAmount: self::float($data, 'base_currency_total_discount_amount'),
            baseCurrencyNetAmount: self::float($data, 'base_currency_net_amount'),
            baseCurrencyTaxAmount: self::float($data, 'base_currency_tax_amount'),
            baseCurrencyTotalAmount: self::float($data, 'base_currency_total_amount'),
            paymentsAllocationsTotalAmount: self::float($data, 'payments_allocations_total_amount'),
            paymentsAllocationsTotalDiscount: self::float($data, 'payments_allocations_total_discount'),
            totalPaid: self::float($data, 'total_paid'),
            status: QuoteStatus::fromNullable(self::nested($data, 'status')),
            sent: self::boolean($data, 'sent'),
            sentByEmail: self::boolean($data, 'sent_by_email'),
            estimateLines: array_map(static fn (array $item): SalesQuoteLineItem => SalesQuoteLineItem::fromArray($item), self::nestedList($data, 'estimate_lines')),
            taxAnalysis: array_map(static fn (array $item): ArtefactTaxAnalysis => ArtefactTaxAnalysis::fromArray($item), self::nestedList($data, 'tax_analysis')),
            detailedTaxAnalysis: ArtefactDetailedTaxAnalysis::fromNullable(self::nested($data, 'detailed_tax_analysis')),
            taxAddressRegion: Reference::fromNullable(self::nested($data, 'tax_address_region')),
            withholdingTaxRate: self::float($data, 'withholding_tax_rate'),
            withholdingTaxAmount: self::float($data, 'withholding_tax_amount'),
            baseCurrencyWithholdingTaxAmount: self::float($data, 'base_currency_withholding_tax_amount'),
            profitAnalysis: ProfitAnalysis::fromNullable(self::nested($data, 'profit_analysis')),
            taxReconciled: self::boolean($data, 'tax_reconciled'),
            invoice: Generic::fromNullable(self::nested($data, 'invoice')),
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
