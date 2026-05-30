<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class BankAccountContact
{
    use MapsAttributes;

    public function __construct(
        public ?string $name = null,
        public ?string $jobTitle = null,
        public ?string $telephone = null,
        public ?string $mobile = null,
        public ?string $email = null,
        public ?string $fax = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: self::string($data, 'name'),
            jobTitle: self::string($data, 'job_title'),
            telephone: self::string($data, 'telephone'),
            mobile: self::string($data, 'mobile'),
            email: self::string($data, 'email'),
            fax: self::string($data, 'fax'),
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
