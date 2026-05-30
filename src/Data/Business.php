<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

/**
 * A Sage business (company). Its {@see $id} is the GUID sent in the
 * `X-Business` header to target API calls at this company.
 */
final readonly class Business
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $name = null,
        public ?string $addressLine1 = null,
        public ?string $addressLine2 = null,
        public ?string $city = null,
        public ?string $postalCode = null,
        public ?Reference $country = null,
        public ?string $region = null,
        public ?string $telephone = null,
        public ?string $mobile = null,
        public ?string $website = null,
        public ?bool $isDemo = null,
        public ?bool $niBased = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
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
            name: self::string($data, 'name'),
            addressLine1: self::string($data, 'address_line_1'),
            addressLine2: self::string($data, 'address_line_2'),
            city: self::string($data, 'city'),
            postalCode: self::string($data, 'postal_code'),
            country: Reference::fromNullable(self::nested($data, 'country')),
            region: self::string($data, 'region'),
            telephone: self::string($data, 'telephone'),
            mobile: self::string($data, 'mobile'),
            website: self::string($data, 'website'),
            isDemo: self::boolean($data, 'is_demo'),
            niBased: self::boolean($data, 'ni_based'),
            createdAt: self::dateTime($data, 'created_at'),
            updatedAt: self::dateTime($data, 'updated_at'),
        );
    }
}
