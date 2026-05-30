<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class BankReconciliation
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?Reference $bankAccount = null,
        public ?DateTimeImmutable $statementDate = null,
        public ?float $statementEndBalance = null,
        public ?string $reference = null,
        public ?float $totalReceived = null,
        public ?float $totalPaid = null,
        public ?float $startingBalance = null,
        public ?float $closingBalance = null,
        public ?float $reconciledBalance = null,
        public ?float $balanceDifference = null,
        public ?BankReconciliationStatus $status = null,
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
            bankAccount: Reference::fromNullable(self::nested($data, 'bank_account')),
            statementDate: self::dateTime($data, 'statement_date'),
            statementEndBalance: self::float($data, 'statement_end_balance'),
            reference: self::string($data, 'reference'),
            totalReceived: self::float($data, 'total_received'),
            totalPaid: self::float($data, 'total_paid'),
            startingBalance: self::float($data, 'starting_balance'),
            closingBalance: self::float($data, 'closing_balance'),
            reconciledBalance: self::float($data, 'reconciled_balance'),
            balanceDifference: self::float($data, 'balance_difference'),
            status: BankReconciliationStatus::fromNullable(self::nested($data, 'status')),
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
