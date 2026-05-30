<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class postLedgerAccountOpeningBalances
{
    use MapsAttributes;

    /**
     * @param  array<string, mixed>|null  $ledgerAccountOpeningBalance
     */
    public function __construct(
        public ?array $ledgerAccountOpeningBalance = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            ledgerAccountOpeningBalance: self::nested($data, 'ledger_account_opening_balance'),
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
