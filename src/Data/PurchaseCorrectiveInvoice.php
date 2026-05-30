<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class PurchaseCorrectiveInvoice
{
    use MapsAttributes;

    /**
     * @param  list<Link>  $links
     * @param  list<PurchaseInvoiceLineItem>  $invoiceLines
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
        public ?Transaction $transaction = null,
        public ?Reference $transactionType = null,
        public ?Contact $contact = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?string $contactName = null,
        public ?string $contactReference = null,
        public ?DateTimeImmutable $date = null,
        public ?DateTimeImmutable $dueDate = null,
        public ?string $reference = null,
        public ?string $vendorReference = null,
        public ?string $notes = null,
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
        public ?string $inverseExchangeRate = null,
        public ?float $baseCurrencyNetAmount = null,
        public ?float $baseCurrencyTaxAmount = null,
        public ?float $baseCurrencyTotalAmount = null,
        public ?float $baseCurrencyOutstandingAmount = null,
        public ?Reference $status = null,
        public ?string $voidReason = null,
        public array $invoiceLines = [],
        public array $taxAnalysis = [],
        public ?ArtefactDetailedTaxAnalysis $detailedTaxAnalysis = null,
        public array $paymentsAllocations = [],
        public ?DateTimeImmutable $lastPaid = null,
        public ?float $withholdingTaxRate = null,
        public ?float $withholdingTaxAmount = null,
        public ?float $baseCurrencyWithholdingTaxAmount = null,
        public ?Generic $originalInvoice = null,
        public ?string $originalInvoiceNumber = null,
        public ?string $originalInvoiceDate = null,
        public ?bool $taxReconciled = null,
        public ?bool $import = null,
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
            transaction: Transaction::fromNullable(self::nested($data, 'transaction')),
            transactionType: Reference::fromNullable(self::nested($data, 'transaction_type')),
            contact: Contact::fromNullable(self::nested($data, 'contact')),
            deletedAt: self::dateTime($data, 'deleted_at'),
            contactName: self::string($data, 'contact_name'),
            contactReference: self::string($data, 'contact_reference'),
            date: self::dateTime($data, 'date'),
            dueDate: self::dateTime($data, 'due_date'),
            reference: self::string($data, 'reference'),
            vendorReference: self::string($data, 'vendor_reference'),
            notes: self::string($data, 'notes'),
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
            inverseExchangeRate: self::string($data, 'inverse_exchange_rate'),
            baseCurrencyNetAmount: self::float($data, 'base_currency_net_amount'),
            baseCurrencyTaxAmount: self::float($data, 'base_currency_tax_amount'),
            baseCurrencyTotalAmount: self::float($data, 'base_currency_total_amount'),
            baseCurrencyOutstandingAmount: self::float($data, 'base_currency_outstanding_amount'),
            status: Reference::fromNullable(self::nested($data, 'status')),
            voidReason: self::string($data, 'void_reason'),
            invoiceLines: array_map(static fn (array $item): PurchaseInvoiceLineItem => PurchaseInvoiceLineItem::fromArray($item), self::nestedList($data, 'invoice_lines')),
            taxAnalysis: array_map(static fn (array $item): ArtefactTaxAnalysis => ArtefactTaxAnalysis::fromArray($item), self::nestedList($data, 'tax_analysis')),
            detailedTaxAnalysis: ArtefactDetailedTaxAnalysis::fromNullable(self::nested($data, 'detailed_tax_analysis')),
            paymentsAllocations: array_map(static fn (array $item): PaymentAllocation => PaymentAllocation::fromArray($item), self::nestedList($data, 'payments_allocations')),
            lastPaid: self::dateTime($data, 'last_paid'),
            withholdingTaxRate: self::float($data, 'withholding_tax_rate'),
            withholdingTaxAmount: self::float($data, 'withholding_tax_amount'),
            baseCurrencyWithholdingTaxAmount: self::float($data, 'base_currency_withholding_tax_amount'),
            originalInvoice: Generic::fromNullable(self::nested($data, 'original_invoice')),
            originalInvoiceNumber: self::string($data, 'original_invoice_number'),
            originalInvoiceDate: self::string($data, 'original_invoice_date'),
            taxReconciled: self::boolean($data, 'tax_reconciled'),
            import: self::boolean($data, 'import'),
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
