<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class TaxProfile
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?Reference $taxType = null,
        public ?string $taxNumber = null,
        public ?string $taxNumberSuffix = null,
        public ?bool $collectTax = null,
        public ?Reference $taxReturnFrequency = null,
        public ?AddressRegion $addressRegion = null,
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
            taxType: Reference::fromNullable(self::nested($data, 'tax_type')),
            taxNumber: self::string($data, 'tax_number'),
            taxNumberSuffix: self::string($data, 'tax_number_suffix'),
            collectTax: self::boolean($data, 'collect_tax'),
            taxReturnFrequency: Reference::fromNullable(self::nested($data, 'tax_return_frequency')),
            addressRegion: AddressRegion::fromNullable(self::nested($data, 'address_region')),
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
