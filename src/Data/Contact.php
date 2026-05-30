<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

/**
 * A Sage contact — a customer and/or supplier. The {@see $contactTypes}
 * references distinguish the two (Sage models a single contact that can be
 * both). Deep association objects (ledger accounts, the main contact person,
 * bank account details, tax treatment and CIS settings) are not yet typed.
 */
final readonly class Contact
{
    use MapsAttributes;

    /**
     * @param  list<Reference>  $contactTypes
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?float $balance = null,
        public ?string $name = null,
        public ?string $reference = null,
        public ?string $taxNumber = null,
        public ?string $notes = null,
        public ?string $locale = null,
        public ?float $creditLimit = null,
        public ?int $creditDays = null,
        public ?string $creditTerms = null,
        public ?string $creditTermsAndConditions = null,
        public ?string $auxReference = null,
        public ?string $sourceGuid = null,
        public ?string $registeredNumber = null,
        public ?string $email = null,
        public ?string $taxCalculation = null,
        public ?string $auxiliaryAccount = null,
        public ?bool $deletable = null,
        public ?bool $gdprObfuscated = null,
        public ?bool $system = null,
        public ?bool $hasUnfinishedRecurringInvoices = null,
        public ?bool $cisRegistered = null,
        public ?bool $niBased = null,
        public ?bool $isActive = null,
        public ?bool $gbBased = null,
        public ?bool $destinationVatBlocking = null,
        public array $contactTypes = [],
        public ?Reference $defaultSalesTaxRate = null,
        public ?Reference $productSalesPriceType = null,
        public ?Reference $currency = null,
        public ?Address $mainAddress = null,
        public ?Address $deliveryAddress = null,
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
            balance: self::float($data, 'balance'),
            name: self::string($data, 'name'),
            reference: self::string($data, 'reference'),
            taxNumber: self::string($data, 'tax_number'),
            notes: self::string($data, 'notes'),
            locale: self::string($data, 'locale'),
            creditLimit: self::float($data, 'credit_limit'),
            creditDays: self::integer($data, 'credit_days'),
            creditTerms: self::string($data, 'credit_terms'),
            creditTermsAndConditions: self::string($data, 'credit_terms_and_conditions'),
            auxReference: self::string($data, 'aux_reference'),
            sourceGuid: self::string($data, 'source_guid'),
            registeredNumber: self::string($data, 'registered_number'),
            email: self::string($data, 'email'),
            taxCalculation: self::string($data, 'tax_calculation'),
            auxiliaryAccount: self::string($data, 'auxiliary_account'),
            deletable: self::boolean($data, 'deletable'),
            gdprObfuscated: self::boolean($data, 'gdpr_obfuscated'),
            system: self::boolean($data, 'system'),
            hasUnfinishedRecurringInvoices: self::boolean($data, 'has_unfinished_recurring_invoices'),
            cisRegistered: self::boolean($data, 'cis_registered'),
            niBased: self::boolean($data, 'ni_based'),
            isActive: self::boolean($data, 'is_active'),
            gbBased: self::boolean($data, 'gb_based'),
            destinationVatBlocking: self::boolean($data, 'destination_vat_blocking'),
            contactTypes: array_map(
                static fn (array $item): Reference => Reference::fromArray($item),
                self::nestedList($data, 'contact_types'),
            ),
            defaultSalesTaxRate: Reference::fromNullable(self::nested($data, 'default_sales_tax_rate')),
            productSalesPriceType: Reference::fromNullable(self::nested($data, 'product_sales_price_type')),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
            mainAddress: Address::fromNullable(self::nested($data, 'main_address')),
            deliveryAddress: Address::fromNullable(self::nested($data, 'delivery_address')),
            // v0.1: not yet typed — default_sales_ledger_account
            // v0.1: not yet typed — default_purchase_ledger_account
            // v0.1: not yet typed — main_contact_person
            // v0.1: not yet typed — bank_account_details
            // v0.1: not yet typed — tax_treatment
            // v0.1: not yet typed — cis_settings
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
