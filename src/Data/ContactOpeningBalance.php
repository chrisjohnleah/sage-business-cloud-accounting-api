<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class ContactOpeningBalance
{
    use MapsAttributes;

    /**
     * @param  list<TaxBreakdown>  $taxBreakdown
     * @param  list<TaxBreakdown>  $baseCurrencyTaxBreakdown
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
        public ?Reference $contactOpeningBalanceType = null,
        public ?Reference $contact = null,
        public ?DateTimeImmutable $date = null,
        public ?string $reference = null,
        public ?string $details = null,
        public ?float $netAmount = null,
        public ?Reference $taxRate = null,
        public ?float $taxAmount = null,
        public array $taxBreakdown = [],
        public ?float $totalAmount = null,
        public ?Reference $currency = null,
        public ?float $exchangeRate = null,
        public ?float $baseCurrencyNetAmount = null,
        public ?float $baseCurrencyTaxAmount = null,
        public array $baseCurrencyTaxBreakdown = [],
        public ?float $baseCurrencyTotalAmount = null,
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
            contactOpeningBalanceType: Reference::fromNullable(self::nested($data, 'contact_opening_balance_type')),
            contact: Reference::fromNullable(self::nested($data, 'contact')),
            date: self::dateTime($data, 'date'),
            reference: self::string($data, 'reference'),
            details: self::string($data, 'details'),
            netAmount: self::float($data, 'net_amount'),
            taxRate: Reference::fromNullable(self::nested($data, 'tax_rate')),
            taxAmount: self::float($data, 'tax_amount'),
            taxBreakdown: array_map(static fn (array $item): TaxBreakdown => TaxBreakdown::fromArray($item), self::nestedList($data, 'tax_breakdown')),
            totalAmount: self::float($data, 'total_amount'),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
            exchangeRate: self::float($data, 'exchange_rate'),
            baseCurrencyNetAmount: self::float($data, 'base_currency_net_amount'),
            baseCurrencyTaxAmount: self::float($data, 'base_currency_tax_amount'),
            baseCurrencyTaxBreakdown: array_map(static fn (array $item): TaxBreakdown => TaxBreakdown::fromArray($item), self::nestedList($data, 'base_currency_tax_breakdown')),
            baseCurrencyTotalAmount: self::float($data, 'base_currency_total_amount'),
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
