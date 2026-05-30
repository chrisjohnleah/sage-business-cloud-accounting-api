<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class postPurchaseCorrectiveInvoices
{
    use MapsAttributes;

    /**
     * @param  array<string, mixed>|null  $purchaseCorrectiveInvoice
     */
    public function __construct(
        public ?array $purchaseCorrectiveInvoice = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            purchaseCorrectiveInvoice: self::nested($data, 'purchase_corrective_invoice'),
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
