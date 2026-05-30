<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class putPurchaseQuickEntries
{
    use MapsAttributes;

    /**
     * @param  array<string, mixed>|null  $purchaseQuickEntry
     */
    public function __construct(
        public ?array $purchaseQuickEntry = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            purchaseQuickEntry: self::nested($data, 'purchase_quick_entry'),
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
