<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class BaseJournalLine
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?LedgerAccount $ledgerAccount = null,
        public ?string $details = null,
        public ?float $debit = null,
        public ?float $credit = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: self::string($data, 'id'),
            ledgerAccount: LedgerAccount::fromNullable(self::nested($data, 'ledger_account')),
            details: self::string($data, 'details'),
            debit: self::float($data, 'debit'),
            credit: self::float($data, 'credit'),
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
