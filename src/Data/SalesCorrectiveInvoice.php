<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class SalesCorrectiveInvoice
{
    use MapsAttributes;

    /**
     * @param  list<Link>  $links
     * @param  list<TaxBreakdown>  $shippingTaxBreakdown
     * @param  list<TaxBreakdown>  $baseCurrencyShippingTaxBreakdown
     * @param  list<SalesInvoiceLineItem>  $invoiceLines
     * @param  list<ArtefactTaxAnalysis>  $taxAnalysis
     * @param  list<PaymentAllocation>  $paymentsAllocations
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
        public ?Transaction $transaction = null,
        public ?Reference $transactionType = null,
        public ?Contact $contact = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?string $invoiceNumberPrefix = null,
        public ?string $invoiceNumber = null,
        public ?string $contactName = null,
        public ?string $contactReference = null,
        public ?DateTimeImmutable $date = null,
        public ?DateTimeImmutable $dueDate = null,
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
        public ?float $totalQuantity = null,
        public ?float $netAmount = null,
        public ?float $taxAmount = null,
        public ?float $totalAmount = null,
        public ?float $paymentsAllocationsTotalAmount = null,
        public ?float $paymentsAllocationsTotalDiscount = null,
        public ?float $totalPaid = null,
        public ?float $outstandingAmount = null,
        public ?Reference $currency = null,
        public ?float $exchangeRate = null,
        public ?float $inverseExchangeRate = null,
        public ?float $baseCurrencyShippingNetAmount = null,
        public ?float $baseCurrencyShippingTaxAmount = null,
        public array $baseCurrencyShippingTaxBreakdown = [],
        public ?float $baseCurrencyShippingTotalAmount = null,
        public ?float $totalDiscountAmount = null,
        public ?float $baseCurrencyTotalDiscountAmount = null,
        public ?float $baseCurrencyNetAmount = null,
        public ?float $baseCurrencyTaxAmount = null,
        public ?float $baseCurrencyTotalAmount = null,
        public ?float $baseCurrencyOutstandingAmount = null,
        public ?Reference $status = null,
        public ?bool $sent = null,
        public ?bool $sentByEmail = null,
        public ?string $voidReason = null,
        public array $invoiceLines = [],
        public array $taxAnalysis = [],
        public ?ArtefactDetailedTaxAnalysis $detailedTaxAnalysis = null,
        public array $paymentsAllocations = [],
        public ?DateTimeImmutable $lastPaid = null,
        public ?float $withholdingTaxRate = null,
        public ?float $withholdingTaxAmount = null,
        public ?float $baseCurrencyWithholdingTaxAmount = null,
        public ?Reference $correctiveReasonCode = null,
        public ?Generic $originalInvoice = null,
        public ?string $originalInvoiceNumber = null,
        public ?string $originalInvoiceDate = null,
        public ?string $details = null,
        public ?bool $taxReconciled = null,
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
            transaction: Transaction::fromNullable(self::nested($data, 'transaction')),
            transactionType: Reference::fromNullable(self::nested($data, 'transaction_type')),
            contact: Contact::fromNullable(self::nested($data, 'contact')),
            deletedAt: self::dateTime($data, 'deleted_at'),
            invoiceNumberPrefix: self::string($data, 'invoice_number_prefix'),
            invoiceNumber: self::string($data, 'invoice_number'),
            contactName: self::string($data, 'contact_name'),
            contactReference: self::string($data, 'contact_reference'),
            date: self::dateTime($data, 'date'),
            dueDate: self::dateTime($data, 'due_date'),
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
            totalQuantity: self::float($data, 'total_quantity'),
            netAmount: self::float($data, 'net_amount'),
            taxAmount: self::float($data, 'tax_amount'),
            totalAmount: self::float($data, 'total_amount'),
            paymentsAllocationsTotalAmount: self::float($data, 'payments_allocations_total_amount'),
            paymentsAllocationsTotalDiscount: self::float($data, 'payments_allocations_total_discount'),
            totalPaid: self::float($data, 'total_paid'),
            outstandingAmount: self::float($data, 'outstanding_amount'),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
            exchangeRate: self::float($data, 'exchange_rate'),
            inverseExchangeRate: self::float($data, 'inverse_exchange_rate'),
            baseCurrencyShippingNetAmount: self::float($data, 'base_currency_shipping_net_amount'),
            baseCurrencyShippingTaxAmount: self::float($data, 'base_currency_shipping_tax_amount'),
            baseCurrencyShippingTaxBreakdown: array_map(static fn (array $item): TaxBreakdown => TaxBreakdown::fromArray($item), self::nestedList($data, 'base_currency_shipping_tax_breakdown')),
            baseCurrencyShippingTotalAmount: self::float($data, 'base_currency_shipping_total_amount'),
            totalDiscountAmount: self::float($data, 'total_discount_amount'),
            baseCurrencyTotalDiscountAmount: self::float($data, 'base_currency_total_discount_amount'),
            baseCurrencyNetAmount: self::float($data, 'base_currency_net_amount'),
            baseCurrencyTaxAmount: self::float($data, 'base_currency_tax_amount'),
            baseCurrencyTotalAmount: self::float($data, 'base_currency_total_amount'),
            baseCurrencyOutstandingAmount: self::float($data, 'base_currency_outstanding_amount'),
            status: Reference::fromNullable(self::nested($data, 'status')),
            sent: self::boolean($data, 'sent'),
            sentByEmail: self::boolean($data, 'sent_by_email'),
            voidReason: self::string($data, 'void_reason'),
            invoiceLines: array_map(static fn (array $item): SalesInvoiceLineItem => SalesInvoiceLineItem::fromArray($item), self::nestedList($data, 'invoice_lines')),
            taxAnalysis: array_map(static fn (array $item): ArtefactTaxAnalysis => ArtefactTaxAnalysis::fromArray($item), self::nestedList($data, 'tax_analysis')),
            detailedTaxAnalysis: ArtefactDetailedTaxAnalysis::fromNullable(self::nested($data, 'detailed_tax_analysis')),
            paymentsAllocations: array_map(static fn (array $item): PaymentAllocation => PaymentAllocation::fromArray($item), self::nestedList($data, 'payments_allocations')),
            lastPaid: self::dateTime($data, 'last_paid'),
            withholdingTaxRate: self::float($data, 'withholding_tax_rate'),
            withholdingTaxAmount: self::float($data, 'withholding_tax_amount'),
            baseCurrencyWithholdingTaxAmount: self::float($data, 'base_currency_withholding_tax_amount'),
            correctiveReasonCode: Reference::fromNullable(self::nested($data, 'corrective_reason_code')),
            originalInvoice: Generic::fromNullable(self::nested($data, 'original_invoice')),
            originalInvoiceNumber: self::string($data, 'original_invoice_number'),
            originalInvoiceDate: self::string($data, 'original_invoice_date'),
            details: self::string($data, 'details'),
            taxReconciled: self::boolean($data, 'tax_reconciled'),
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
