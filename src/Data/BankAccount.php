<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class BankAccount
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?BankAccountDetails $bankAccountDetails = null,
        public ?Reference $ledgerAccount = null,
        public ?Reference $bankAccountType = null,
        public ?float $balance = null,
        public ?Address $mainAddress = null,
        public ?BankAccountContact $mainContactPerson = null,
        public ?int $nominalCode = null,
        public ?bool $editable = null,
        public ?bool $deletable = null,
        public ?JournalCode $journalCode = null,
        public ?Reference $defaultPaymentMethod = null,
        public ?int $gifiCode = null,
        public ?bool $isActive = null,
        public ?Reference $currency = null,
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
            bankAccountDetails: BankAccountDetails::fromNullable(self::nested($data, 'bank_account_details')),
            ledgerAccount: Reference::fromNullable(self::nested($data, 'ledger_account')),
            bankAccountType: Reference::fromNullable(self::nested($data, 'bank_account_type')),
            balance: self::float($data, 'balance'),
            mainAddress: Address::fromNullable(self::nested($data, 'main_address')),
            mainContactPerson: BankAccountContact::fromNullable(self::nested($data, 'main_contact_person')),
            nominalCode: self::integer($data, 'nominal_code'),
            editable: self::boolean($data, 'editable'),
            deletable: self::boolean($data, 'deletable'),
            journalCode: JournalCode::fromNullable(self::nested($data, 'journal_code')),
            defaultPaymentMethod: Reference::fromNullable(self::nested($data, 'default_payment_method')),
            gifiCode: self::integer($data, 'gifi_code'),
            isActive: self::boolean($data, 'is_active'),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
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
