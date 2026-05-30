<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class PrintContactDetails
{
    use MapsAttributes;

    public function __construct(
        public ?bool $businessName = null,
        public ?bool $website = null,
        public ?bool $telephone = null,
        public ?bool $mobile = null,
        public ?bool $emailAddress = null,
        public ?bool $dueDate = null,
        public ?string $defaultDeliveryAddress = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            businessName: self::boolean($data, 'business_name'),
            website: self::boolean($data, 'website'),
            telephone: self::boolean($data, 'telephone'),
            mobile: self::boolean($data, 'mobile'),
            emailAddress: self::boolean($data, 'email_address'),
            dueDate: self::boolean($data, 'due_date'),
            defaultDeliveryAddress: self::string($data, 'default_delivery_address'),
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
