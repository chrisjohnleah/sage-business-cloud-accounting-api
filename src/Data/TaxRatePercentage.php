<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class TaxRatePercentage
{
    use MapsAttributes;

    public function __construct(
        public ?float $percentage = null,
        public ?DateTimeImmutable $fromDate = null,
        public ?DateTimeImmutable $toDate = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            percentage: self::float($data, 'percentage'),
            fromDate: self::dateTime($data, 'from_date'),
            toDate: self::dateTime($data, 'to_date'),
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
