<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class Product
{
    use MapsAttributes;

    /**
     * @param  list<SalesPrice>  $salesPrices
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?bool $deletable = null,
        public ?bool $deactivatable = null,
        public ?bool $usedOnRecurringInvoice = null,
        public ?string $itemCode = null,
        public ?string $description = null,
        public ?string $notes = null,
        public ?Reference $salesLedgerAccount = null,
        public ?Reference $salesTaxRate = null,
        public ?Reference $purchaseLedgerAccount = null,
        public ?Contact $usualSupplier = null,
        public ?Reference $purchaseTaxRate = null,
        public ?float $costPrice = null,
        public array $salesPrices = [],
        public ?string $sourceGuid = null,
        public ?string $purchaseDescription = null,
        public ?bool $active = null,
        public ?Reference $catalogItemType = null,
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
            deletable: self::boolean($data, 'deletable'),
            deactivatable: self::boolean($data, 'deactivatable'),
            usedOnRecurringInvoice: self::boolean($data, 'used_on_recurring_invoice'),
            itemCode: self::string($data, 'item_code'),
            description: self::string($data, 'description'),
            notes: self::string($data, 'notes'),
            salesLedgerAccount: Reference::fromNullable(self::nested($data, 'sales_ledger_account')),
            salesTaxRate: Reference::fromNullable(self::nested($data, 'sales_tax_rate')),
            purchaseLedgerAccount: Reference::fromNullable(self::nested($data, 'purchase_ledger_account')),
            usualSupplier: Contact::fromNullable(self::nested($data, 'usual_supplier')),
            purchaseTaxRate: Reference::fromNullable(self::nested($data, 'purchase_tax_rate')),
            costPrice: self::float($data, 'cost_price'),
            salesPrices: array_map(static fn (array $item): SalesPrice => SalesPrice::fromArray($item), self::nestedList($data, 'sales_prices')),
            sourceGuid: self::string($data, 'source_guid'),
            purchaseDescription: self::string($data, 'purchase_description'),
            active: self::boolean($data, 'active'),
            catalogItemType: Reference::fromNullable(self::nested($data, 'catalog_item_type')),
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
