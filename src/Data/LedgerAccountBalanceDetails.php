<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class LedgerAccountBalanceDetails
{
    use MapsAttributes;

    public function __construct(
        public ?float $balance = null,
        public ?string $creditOrDebit = null,
        public ?float $credits = null,
        public ?float $debits = null,
        public ?string $fromDate = null,
        public ?string $toDate = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            balance: self::float($data, 'balance'),
            creditOrDebit: self::string($data, 'credit_or_debit'),
            credits: self::float($data, 'credits'),
            debits: self::float($data, 'debits'),
            fromDate: self::string($data, 'from_date'),
            toDate: self::string($data, 'to_date'),
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
