<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class postSalesCorrectiveInvoices
{
    use MapsAttributes;

    /**
     * @param  array<string, mixed>|null  $salesCorrectiveInvoice
     */
    public function __construct(
        public ?array $salesCorrectiveInvoice = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            salesCorrectiveInvoice: self::nested($data, 'sales_corrective_invoice'),
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
