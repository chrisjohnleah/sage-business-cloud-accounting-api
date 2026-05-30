<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class PrintStatements
{
    use MapsAttributes;

    public function __construct(
        public ?bool $daysOverdue = null,
        public ?bool $tableOfBalances = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            daysOverdue: self::boolean($data, 'days_overdue'),
            tableOfBalances: self::boolean($data, 'table_of_balances'),
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
