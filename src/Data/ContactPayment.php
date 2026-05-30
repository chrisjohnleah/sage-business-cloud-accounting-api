<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class ContactPayment
{
    use MapsAttributes;

    /**
     * @param  list<Link>  $links
     * @param  list<AllocatedPaymentArtefact>  $allocatedArtefacts
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public array $links = [],
        public ?Reference $transaction = null,
        public ?Reference $transactionType = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?Reference $paymentMethod = null,
        public ?Reference $contact = null,
        public ?Reference $bankAccount = null,
        public ?DateTimeImmutable $date = null,
        public ?float $netAmount = null,
        public ?float $taxAmount = null,
        public ?float $totalAmount = null,
        public ?Reference $currency = null,
        public ?float $exchangeRate = null,
        public ?float $baseCurrencyNetAmount = null,
        public ?float $baseCurrencyTaxAmount = null,
        public ?float $baseCurrencyTotalAmount = null,
        public ?float $baseCurrencyCurrencyCharge = null,
        public ?string $reference = null,
        public array $allocatedArtefacts = [],
        public ?Reference $taxRate = null,
        public ?PaymentOnAccount $paymentOnAccount = null,
        public ?bool $editable = null,
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
            transaction: Reference::fromNullable(self::nested($data, 'transaction')),
            transactionType: Reference::fromNullable(self::nested($data, 'transaction_type')),
            deletedAt: self::dateTime($data, 'deleted_at'),
            paymentMethod: Reference::fromNullable(self::nested($data, 'payment_method')),
            contact: Reference::fromNullable(self::nested($data, 'contact')),
            bankAccount: Reference::fromNullable(self::nested($data, 'bank_account')),
            date: self::dateTime($data, 'date'),
            netAmount: self::float($data, 'net_amount'),
            taxAmount: self::float($data, 'tax_amount'),
            totalAmount: self::float($data, 'total_amount'),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
            exchangeRate: self::float($data, 'exchange_rate'),
            baseCurrencyNetAmount: self::float($data, 'base_currency_net_amount'),
            baseCurrencyTaxAmount: self::float($data, 'base_currency_tax_amount'),
            baseCurrencyTotalAmount: self::float($data, 'base_currency_total_amount'),
            baseCurrencyCurrencyCharge: self::float($data, 'base_currency_currency_charge'),
            reference: self::string($data, 'reference'),
            allocatedArtefacts: array_map(static fn (array $item): AllocatedPaymentArtefact => AllocatedPaymentArtefact::fromArray($item), self::nestedList($data, 'allocated_artefacts')),
            taxRate: Reference::fromNullable(self::nested($data, 'tax_rate')),
            paymentOnAccount: PaymentOnAccount::fromNullable(self::nested($data, 'payment_on_account')),
            editable: self::boolean($data, 'editable'),
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
