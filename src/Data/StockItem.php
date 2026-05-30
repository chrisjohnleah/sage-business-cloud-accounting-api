<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class StockItem
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
        public ?float $reorderLevel = null,
        public ?float $reorderQuantity = null,
        public ?string $location = null,
        public ?string $barcode = null,
        public ?string $supplierPartNumber = null,
        public ?float $weight = null,
        public ?string $measurementUnit = null,
        public ?float $weightConverted = null,
        public ?bool $active = null,
        public ?float $quantityInStock = null,
        public ?float $lastCostPrice = null,
        public ?float $lastCostPriceStockValue = null,
        public ?float $averageCostPrice = null,
        public ?float $averageCostPriceStockValue = null,
        public ?DateTimeImmutable $costPriceLastUpdated = null,
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
            reorderLevel: self::float($data, 'reorder_level'),
            reorderQuantity: self::float($data, 'reorder_quantity'),
            location: self::string($data, 'location'),
            barcode: self::string($data, 'barcode'),
            supplierPartNumber: self::string($data, 'supplier_part_number'),
            weight: self::float($data, 'weight'),
            measurementUnit: self::string($data, 'measurement_unit'),
            weightConverted: self::float($data, 'weight_converted'),
            active: self::boolean($data, 'active'),
            quantityInStock: self::float($data, 'quantity_in_stock'),
            lastCostPrice: self::float($data, 'last_cost_price'),
            lastCostPriceStockValue: self::float($data, 'last_cost_price_stock_value'),
            averageCostPrice: self::float($data, 'average_cost_price'),
            averageCostPriceStockValue: self::float($data, 'average_cost_price_stock_value'),
            costPriceLastUpdated: self::dateTime($data, 'cost_price_last_updated'),
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
