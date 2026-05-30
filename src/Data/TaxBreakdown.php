<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class TaxBreakdown
{
    use MapsAttributes;

    public function __construct(
        public ?Reference $taxRate = null,
        public ?float $percentage = null,
        public ?float $amount = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            taxRate: Reference::fromNullable(self::nested($data, 'tax_rate')),
            percentage: self::float($data, 'percentage'),
            amount: self::float($data, 'amount'),
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
