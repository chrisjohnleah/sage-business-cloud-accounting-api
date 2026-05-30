<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class ContactPerson
{
    use MapsAttributes;

    /**
     * @param  list<ContactPersonType>  $contactPersonTypes
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?DateTimeImmutable $deletedAt = null,
        public array $contactPersonTypes = [],
        public ?string $name = null,
        public ?string $jobTitle = null,
        public ?string $telephone = null,
        public ?string $mobile = null,
        public ?string $email = null,
        public ?string $fax = null,
        public ?bool $isMainContact = null,
        public ?Reference $address = null,
        public ?bool $isPreferredContact = null,
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
            deletedAt: self::dateTime($data, 'deleted_at'),
            contactPersonTypes: array_map(static fn (array $item): ContactPersonType => ContactPersonType::fromArray($item), self::nestedList($data, 'contact_person_types')),
            name: self::string($data, 'name'),
            jobTitle: self::string($data, 'job_title'),
            telephone: self::string($data, 'telephone'),
            mobile: self::string($data, 'mobile'),
            email: self::string($data, 'email'),
            fax: self::string($data, 'fax'),
            isMainContact: self::boolean($data, 'is_main_contact'),
            address: Reference::fromNullable(self::nested($data, 'address')),
            isPreferredContact: self::boolean($data, 'is_preferred_contact'),
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
