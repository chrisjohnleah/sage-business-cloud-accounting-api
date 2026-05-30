<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class PurchaseQuickEntry
{
    use MapsAttributes;

    /**
     * @param  list<AnalysisTypeLineItem>  $analysisTypeCategories
     * @param  list<TaxBreakdown>  $taxBreakdown
     * @param  list<TaxBreakdown>  $baseCurrencyTaxBreakdown
     * @param  list<PaymentAllocation>  $paymentsAllocations
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?Reference $transaction = null,
        public ?Reference $transactionType = null,
        public ?DateTimeImmutable $deletedAt = null,
        public array $analysisTypeCategories = [],
        public ?Reference $quickEntryType = null,
        public ?string $contactName = null,
        public ?string $contactReference = null,
        public ?Reference $contact = null,
        public ?DateTimeImmutable $date = null,
        public ?DateTimeImmutable $dueDate = null,
        public ?string $reference = null,
        public ?Reference $ledgerAccount = null,
        public ?string $details = null,
        public ?float $netAmount = null,
        public ?Reference $taxRate = null,
        public ?float $taxAmount = null,
        public array $taxBreakdown = [],
        public ?float $totalAmount = null,
        public ?float $outstandingAmount = null,
        public ?Reference $currency = null,
        public ?float $exchangeRate = null,
        public ?float $inverseExchangeRate = null,
        public ?float $baseCurrencyNetAmount = null,
        public ?float $baseCurrencyTaxAmount = null,
        public array $baseCurrencyTaxBreakdown = [],
        public ?float $baseCurrencyTotalAmount = null,
        public ?float $baseCurrencyOutstandingAmount = null,
        public ?Reference $status = null,
        public array $paymentsAllocations = [],
        public ?Reference $taxAddressRegion = null,
        public ?bool $migrated = null,
        public ?bool $tradeOfAsset = null,
        public ?float $gstAmount = null,
        public ?float $pstAmount = null,
        public ?bool $taxRecoverable = null,
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
            transaction: Reference::fromNullable(self::nested($data, 'transaction')),
            transactionType: Reference::fromNullable(self::nested($data, 'transaction_type')),
            deletedAt: self::dateTime($data, 'deleted_at'),
            analysisTypeCategories: array_map(static fn (array $item): AnalysisTypeLineItem => AnalysisTypeLineItem::fromArray($item), self::nestedList($data, 'analysis_type_categories')),
            quickEntryType: Reference::fromNullable(self::nested($data, 'quick_entry_type')),
            contactName: self::string($data, 'contact_name'),
            contactReference: self::string($data, 'contact_reference'),
            contact: Reference::fromNullable(self::nested($data, 'contact')),
            date: self::dateTime($data, 'date'),
            dueDate: self::dateTime($data, 'due_date'),
            reference: self::string($data, 'reference'),
            ledgerAccount: Reference::fromNullable(self::nested($data, 'ledger_account')),
            details: self::string($data, 'details'),
            netAmount: self::float($data, 'net_amount'),
            taxRate: Reference::fromNullable(self::nested($data, 'tax_rate')),
            taxAmount: self::float($data, 'tax_amount'),
            taxBreakdown: array_map(static fn (array $item): TaxBreakdown => TaxBreakdown::fromArray($item), self::nestedList($data, 'tax_breakdown')),
            totalAmount: self::float($data, 'total_amount'),
            outstandingAmount: self::float($data, 'outstanding_amount'),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
            exchangeRate: self::float($data, 'exchange_rate'),
            inverseExchangeRate: self::float($data, 'inverse_exchange_rate'),
            baseCurrencyNetAmount: self::float($data, 'base_currency_net_amount'),
            baseCurrencyTaxAmount: self::float($data, 'base_currency_tax_amount'),
            baseCurrencyTaxBreakdown: array_map(static fn (array $item): TaxBreakdown => TaxBreakdown::fromArray($item), self::nestedList($data, 'base_currency_tax_breakdown')),
            baseCurrencyTotalAmount: self::float($data, 'base_currency_total_amount'),
            baseCurrencyOutstandingAmount: self::float($data, 'base_currency_outstanding_amount'),
            status: Reference::fromNullable(self::nested($data, 'status')),
            paymentsAllocations: array_map(static fn (array $item): PaymentAllocation => PaymentAllocation::fromArray($item), self::nestedList($data, 'payments_allocations')),
            taxAddressRegion: Reference::fromNullable(self::nested($data, 'tax_address_region')),
            migrated: self::boolean($data, 'migrated'),
            tradeOfAsset: self::boolean($data, 'trade_of_asset'),
            gstAmount: self::float($data, 'gst_amount'),
            pstAmount: self::float($data, 'pst_amount'),
            taxRecoverable: self::boolean($data, 'tax_recoverable'),
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
