<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class TaxReturn
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?string $taxReturnNumber = null,
        public ?DateTimeImmutable $periodStartDate = null,
        public ?DateTimeImmutable $periodEndDate = null,
        public ?float $totalAmount = null,
        public ?bool $paid = null,
        public ?TaxReturnStatus $status = null,
        public ?TaxReturnType $taxReturnType = null,
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
            taxReturnNumber: self::string($data, 'tax_return_number'),
            periodStartDate: self::dateTime($data, 'period_start_date'),
            periodEndDate: self::dateTime($data, 'period_end_date'),
            totalAmount: self::float($data, 'total_amount'),
            paid: self::boolean($data, 'paid'),
            status: TaxReturnStatus::fromNullable(self::nested($data, 'status')),
            taxReturnType: TaxReturnType::fromNullable(self::nested($data, 'tax_return_type')),
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
