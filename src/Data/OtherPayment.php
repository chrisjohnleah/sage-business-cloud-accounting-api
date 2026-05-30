<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class OtherPayment
{
    use MapsAttributes;

    /**
     * @param  list<OtherPaymentLineItem>  $paymentLines
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
        public ?float $baseCurrencyTotalItcAmount = null,
        public ?float $totalItcAmount = null,
        public ?float $baseCurrencyTotalItrAmount = null,
        public ?float $totalItrAmount = null,
        public ?bool $partRecoverable = null,
        public ?Reference $paymentMethod = null,
        public ?Reference $contact = null,
        public ?Reference $bankAccount = null,
        public ?Reference $taxAddressRegion = null,
        public ?DateTimeImmutable $date = null,
        public ?float $netAmount = null,
        public ?float $taxAmount = null,
        public ?float $totalAmount = null,
        public ?string $reference = null,
        public array $paymentLines = [],
        public ?bool $editable = null,
        public ?bool $deletable = null,
        public ?float $withholdingTaxRate = null,
        public ?float $withholdingTaxAmount = null,
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
            baseCurrencyTotalItcAmount: self::float($data, 'base_currency_total_itc_amount'),
            totalItcAmount: self::float($data, 'total_itc_amount'),
            baseCurrencyTotalItrAmount: self::float($data, 'base_currency_total_itr_amount'),
            totalItrAmount: self::float($data, 'total_itr_amount'),
            partRecoverable: self::boolean($data, 'part_recoverable'),
            paymentMethod: Reference::fromNullable(self::nested($data, 'payment_method')),
            contact: Reference::fromNullable(self::nested($data, 'contact')),
            bankAccount: Reference::fromNullable(self::nested($data, 'bank_account')),
            taxAddressRegion: Reference::fromNullable(self::nested($data, 'tax_address_region')),
            date: self::dateTime($data, 'date'),
            netAmount: self::float($data, 'net_amount'),
            taxAmount: self::float($data, 'tax_amount'),
            totalAmount: self::float($data, 'total_amount'),
            reference: self::string($data, 'reference'),
            paymentLines: array_map(static fn (array $item): OtherPaymentLineItem => OtherPaymentLineItem::fromArray($item), self::nestedList($data, 'payment_lines')),
            editable: self::boolean($data, 'editable'),
            deletable: self::boolean($data, 'deletable'),
            withholdingTaxRate: self::float($data, 'withholding_tax_rate'),
            withholdingTaxAmount: self::float($data, 'withholding_tax_amount'),
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
