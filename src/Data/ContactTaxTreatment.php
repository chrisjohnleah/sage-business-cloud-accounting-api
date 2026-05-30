<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class ContactTaxTreatment
{
    use MapsAttributes;

    public function __construct(
        public ?bool $homeTax = null,
        public ?bool $euTaxRegistered = null,
        public ?bool $euNotTaxRegistered = null,
        public ?bool $restOfWorldTax = null,
        public ?bool $isImporter = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            homeTax: self::boolean($data, 'home_tax'),
            euTaxRegistered: self::boolean($data, 'eu_tax_registered'),
            euNotTaxRegistered: self::boolean($data, 'eu_not_tax_registered'),
            restOfWorldTax: self::boolean($data, 'rest_of_world_tax'),
            isImporter: self::boolean($data, 'is_importer'),
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
