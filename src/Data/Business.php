<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class Business
{
    use MapsAttributes;

    /**
     * @param  list<Subscription>  $subscriptions
     */
    public function __construct(
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?string $displayedAs = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $addressLine1 = null,
        public ?string $addressLine2 = null,
        public ?string $city = null,
        public ?string $postalCode = null,
        public ?Country $country = null,
        public ?string $region = null,
        public ?string $telephone = null,
        public ?string $mobile = null,
        public ?string $website = null,
        public ?bool $isDemo = null,
        public ?bool $niBased = null,
        public array $subscriptions = [],
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            createdAt: self::dateTime($data, 'created_at'),
            updatedAt: self::dateTime($data, 'updated_at'),
            displayedAs: self::string($data, 'displayed_as'),
            id: self::string($data, 'id'),
            name: self::string($data, 'name'),
            addressLine1: self::string($data, 'address_line_1'),
            addressLine2: self::string($data, 'address_line_2'),
            city: self::string($data, 'city'),
            postalCode: self::string($data, 'postal_code'),
            country: Country::fromNullable(self::nested($data, 'country')),
            region: self::string($data, 'region'),
            telephone: self::string($data, 'telephone'),
            mobile: self::string($data, 'mobile'),
            website: self::string($data, 'website'),
            isDemo: self::boolean($data, 'is_demo'),
            niBased: self::boolean($data, 'ni_based'),
            subscriptions: array_map(static fn (array $item): Subscription => Subscription::fromArray($item), self::nestedList($data, 'subscriptions')),
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
