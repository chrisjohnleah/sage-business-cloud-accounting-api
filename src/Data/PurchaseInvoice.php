<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

/**
 * A Sage purchase invoice — money the business owes a supplier. The cashflow
 * screen reads {@see $outstandingAmount}, {@see $dueDate} and {@see $status} to
 * project payables; {@see $invoiceLines} carries the breakdown.
 */
final readonly class PurchaseInvoice
{
    use MapsAttributes;

    /**
     * @param  list<PurchaseInvoiceLineItem>  $invoiceLines
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?bool $editable = null,
        public ?bool $vatReverseCharge = null,
        public ?bool $postponedAccounting = null,
        public ?bool $import = null,
        public ?bool $vatExemptConsignment = null,
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
        public ?float $totalPaid = null,
        public ?float $outstandingAmount = null,
        public ?float $exchangeRate = null,
        public ?float $baseCurrencyNetAmount = null,
        public ?float $baseCurrencyTaxAmount = null,
        public ?float $baseCurrencyTotalAmount = null,
        public ?float $baseCurrencyOutstandingAmount = null,
        public ?string $voidReason = null,
        public ?DateTimeImmutable $lastPaid = null,
        public ?bool $taxReconciled = null,
        public ?bool $migrated = null,
        public ?string $taxCalculationMethod = null,
        public ?Contact $contact = null,
        public ?Transaction $transaction = null,
        public ?Reference $transactionType = null,
        public ?Reference $currency = null,
        public ?Reference $status = null,
        public ?Reference $taxAddressRegion = null,
        public array $invoiceLines = [],
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
            deletedAt: self::dateTime($data, 'deleted_at'),
            editable: self::boolean($data, 'editable'),
            vatReverseCharge: self::boolean($data, 'vat_reverse_charge'),
            postponedAccounting: self::boolean($data, 'postponed_accounting'),
            import: self::boolean($data, 'import'),
            vatExemptConsignment: self::boolean($data, 'vat_exempt_consignment'),
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
            totalPaid: self::float($data, 'total_paid'),
            outstandingAmount: self::float($data, 'outstanding_amount'),
            exchangeRate: self::float($data, 'exchange_rate'),
            baseCurrencyNetAmount: self::float($data, 'base_currency_net_amount'),
            baseCurrencyTaxAmount: self::float($data, 'base_currency_tax_amount'),
            baseCurrencyTotalAmount: self::float($data, 'base_currency_total_amount'),
            baseCurrencyOutstandingAmount: self::float($data, 'base_currency_outstanding_amount'),
            voidReason: self::string($data, 'void_reason'),
            lastPaid: self::dateTime($data, 'last_paid'),
            taxReconciled: self::boolean($data, 'tax_reconciled'),
            migrated: self::boolean($data, 'migrated'),
            taxCalculationMethod: self::string($data, 'tax_calculation_method'),
            contact: Contact::fromNullable(self::nested($data, 'contact')),
            transaction: Transaction::fromNullable(self::nested($data, 'transaction')),
            transactionType: Reference::fromNullable(self::nested($data, 'transaction_type')),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
            status: Reference::fromNullable(self::nested($data, 'status')),
            taxAddressRegion: Reference::fromNullable(self::nested($data, 'tax_address_region')),
            invoiceLines: array_map(
                static fn (array $item): PurchaseInvoiceLineItem => PurchaseInvoiceLineItem::fromArray($item),
                self::nestedList($data, 'invoice_lines'),
            ),
            // v0.1: not yet typed — tax_analysis
            // v0.1: not yet typed — detailed_tax_analysis
            // v0.1: not yet typed — payments_allocations
            // v0.1: not yet typed — corrections
            // v0.1: not yet typed — cis_* (cis_rate, cis_amount, cis_total_amount, …)
            // v0.1: not yet typed — itc / itr / withholding_* fields
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
