<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class postOpeningBalanceJournals
{
    use MapsAttributes;

    /**
     * @param  array<string, mixed>|null  $openingBalanceJournal
     */
    public function __construct(
        public ?array $openingBalanceJournal = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            openingBalanceJournal: self::nested($data, 'opening_balance_journal'),
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
