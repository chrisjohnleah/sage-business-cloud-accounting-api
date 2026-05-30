<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class UnpostedTransaction
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public ?string $transactionDate = null,
        public ?string $transactionType = null,
        public ?string $description = null,
        public ?BankAccount $bankAccount = null,
        public ?string $amount = null,
        public ?string $bankFeedCategoryName = null,
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
            createdAt: self::string($data, 'created_at'),
            updatedAt: self::string($data, 'updated_at'),
            transactionDate: self::string($data, 'transaction_date'),
            transactionType: self::string($data, 'transaction_type'),
            description: self::string($data, 'description'),
            bankAccount: BankAccount::fromNullable(self::nested($data, 'bank_account')),
            amount: self::string($data, 'amount'),
            bankFeedCategoryName: self::string($data, 'bank_feed_category_name'),
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
