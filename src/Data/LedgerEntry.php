<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class LedgerEntry
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?DateTimeImmutable $date = null,
        public ?float $credit = null,
        public ?float $debit = null,
        public ?LedgerAccount $ledgerAccount = null,
        public ?Transaction $transaction = null,
        public ?Contact $contact = null,
        public ?bool $deleted = null,
        public ?TaxRate $taxRate = null,
        public ?string $description = null,
        public ?JournalCode $journalCode = null,
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
            date: self::dateTime($data, 'date'),
            credit: self::float($data, 'credit'),
            debit: self::float($data, 'debit'),
            ledgerAccount: LedgerAccount::fromNullable(self::nested($data, 'ledger_account')),
            transaction: Transaction::fromNullable(self::nested($data, 'transaction')),
            contact: Contact::fromNullable(self::nested($data, 'contact')),
            deleted: self::boolean($data, 'deleted'),
            taxRate: TaxRate::fromNullable(self::nested($data, 'tax_rate')),
            description: self::string($data, 'description'),
            journalCode: JournalCode::fromNullable(self::nested($data, 'journal_code')),
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
