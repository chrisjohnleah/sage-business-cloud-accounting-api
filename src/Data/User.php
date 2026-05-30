<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class User
{
    use MapsAttributes;

    public function __construct(
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?string $displayedAs = null,
        public ?string $id = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $initials = null,
        public ?string $email = null,
        public ?string $locale = null,
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
            firstName: self::string($data, 'first_name'),
            lastName: self::string($data, 'last_name'),
            initials: self::string($data, 'initials'),
            email: self::string($data, 'email'),
            locale: self::string($data, 'locale'),
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
