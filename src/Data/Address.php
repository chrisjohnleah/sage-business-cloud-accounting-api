<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

/**
 * A postal address attached to a {@see Contact} (or a business). Sage exposes
 * both a contact's main and delivery addresses as full address objects.
 */
final readonly class Address
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?string $addressLine1 = null,
        public ?string $addressLine2 = null,
        public ?string $city = null,
        public ?string $postalCode = null,
        public ?Reference $country = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?Reference $bankAccount = null,
        public ?Reference $contact = null,
        public ?Reference $addressType = null,
        public ?string $name = null,
        public ?string $region = null,
        public ?Reference $countryGroup = null,
        public ?bool $isMainAddress = null,
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
            addressLine1: self::string($data, 'address_line_1'),
            addressLine2: self::string($data, 'address_line_2'),
            city: self::string($data, 'city'),
            postalCode: self::string($data, 'postal_code'),
            country: Reference::fromNullable(self::nested($data, 'country')),
            deletedAt: self::dateTime($data, 'deleted_at'),
            createdAt: self::dateTime($data, 'created_at'),
            updatedAt: self::dateTime($data, 'updated_at'),
            bankAccount: Reference::fromNullable(self::nested($data, 'bank_account')),
            contact: Reference::fromNullable(self::nested($data, 'contact')),
            addressType: Reference::fromNullable(self::nested($data, 'address_type')),
            name: self::string($data, 'name'),
            region: self::string($data, 'region'),
            countryGroup: Reference::fromNullable(self::nested($data, 'country_group')),
            isMainAddress: self::boolean($data, 'is_main_address'),
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
