<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class InvoiceSettingsLineItemTitles
{
    use MapsAttributes;

    public function __construct(
        public ?string $description = null,
        public ?string $unitPrice = null,
        public ?string $quantity = null,
        public ?string $discount = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            description: self::string($data, 'description'),
            unitPrice: self::string($data, 'unit_price'),
            quantity: self::string($data, 'quantity'),
            discount: self::string($data, 'discount'),
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
