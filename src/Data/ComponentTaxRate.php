<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class ComponentTaxRate
{
    use MapsAttributes;

    /**
     * @param  list<TaxRatePercentage>  $percentages
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?string $name = null,
        public ?string $agency = null,
        public ?float $percentage = null,
        public array $percentages = [],
        public ?bool $isVisible = null,
        public ?bool $retailer = null,
        public ?bool $editable = null,
        public ?bool $deletable = null,
        public ?bool $isCombinedRate = null,
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
            name: self::string($data, 'name'),
            agency: self::string($data, 'agency'),
            percentage: self::float($data, 'percentage'),
            percentages: array_map(static fn (array $item): TaxRatePercentage => TaxRatePercentage::fromArray($item), self::nestedList($data, 'percentages')),
            isVisible: self::boolean($data, 'is_visible'),
            retailer: self::boolean($data, 'retailer'),
            editable: self::boolean($data, 'editable'),
            deletable: self::boolean($data, 'deletable'),
            isCombinedRate: self::boolean($data, 'is_combined_rate'),
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
