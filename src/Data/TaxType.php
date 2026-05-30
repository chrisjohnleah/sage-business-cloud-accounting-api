<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class TaxType
{
    use MapsAttributes;

    /**
     * @param  list<Reference>  $addressRegions
     * @param  list<Reference>  $taxRates
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?bool $federalTax = null,
        public ?Reference $country = null,
        public array $addressRegions = [],
        public array $taxRates = [],
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
            federalTax: self::boolean($data, 'federal_tax'),
            country: Reference::fromNullable(self::nested($data, 'country')),
            addressRegions: array_map(static fn (array $item): Reference => Reference::fromArray($item), self::nestedList($data, 'address_regions')),
            taxRates: array_map(static fn (array $item): Reference => Reference::fromArray($item), self::nestedList($data, 'tax_rates')),
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
