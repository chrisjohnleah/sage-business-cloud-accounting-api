<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class Contact
{
    use MapsAttributes;

    /**
     * @param  list<Link>  $links
     * @param  list<Reference>  $contactTypes
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public array $links = [],
        public ?DateTimeImmutable $deletedAt = null,
        public ?float $balance = null,
        public array $contactTypes = [],
        public ?string $name = null,
        public ?string $reference = null,
        public ?LedgerAccount $defaultSalesLedgerAccount = null,
        public ?Reference $defaultSalesTaxRate = null,
        public ?LedgerAccount $defaultPurchaseLedgerAccount = null,
        public ?string $taxNumber = null,
        public ?string $notes = null,
        public ?string $locale = null,
        public ?Address $mainAddress = null,
        public ?Address $deliveryAddress = null,
        public ?ContactPerson $mainContactPerson = null,
        public ?BankAccountDetails $bankAccountDetails = null,
        public ?float $creditLimit = null,
        public ?int $creditDays = null,
        public ?string $creditTerms = null,
        public ?string $creditTermsAndConditions = null,
        public ?Reference $productSalesPriceType = null,
        public ?string $sourceGuid = null,
        public ?Reference $currency = null,
        public ?string $auxReference = null,
        public ?string $registeredNumber = null,
        public ?bool $deletable = null,
        public ?ContactTaxTreatment $taxTreatment = null,
        public ?string $email = null,
        public ?string $taxCalculation = null,
        public ?string $auxiliaryAccount = null,
        public ?bool $gdprObfuscated = null,
        public ?bool $system = null,
        public ?bool $hasUnfinishedRecurringInvoices = null,
        public ?bool $cisRegistered = null,
        public ?bool $niBased = null,
        public ?bool $isActive = null,
        public ?bool $gbBased = null,
        public ?ContactCisSettings $cisSettings = null,
        public ?bool $destinationVatBlocking = null,
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
            links: array_map(static fn (array $item): Link => Link::fromArray($item), self::nestedList($data, 'links')),
            deletedAt: self::dateTime($data, 'deleted_at'),
            balance: self::float($data, 'balance'),
            contactTypes: array_map(static fn (array $item): Reference => Reference::fromArray($item), self::nestedList($data, 'contact_types')),
            name: self::string($data, 'name'),
            reference: self::string($data, 'reference'),
            defaultSalesLedgerAccount: LedgerAccount::fromNullable(self::nested($data, 'default_sales_ledger_account')),
            defaultSalesTaxRate: Reference::fromNullable(self::nested($data, 'default_sales_tax_rate')),
            defaultPurchaseLedgerAccount: LedgerAccount::fromNullable(self::nested($data, 'default_purchase_ledger_account')),
            taxNumber: self::string($data, 'tax_number'),
            notes: self::string($data, 'notes'),
            locale: self::string($data, 'locale'),
            mainAddress: Address::fromNullable(self::nested($data, 'main_address')),
            deliveryAddress: Address::fromNullable(self::nested($data, 'delivery_address')),
            mainContactPerson: ContactPerson::fromNullable(self::nested($data, 'main_contact_person')),
            bankAccountDetails: BankAccountDetails::fromNullable(self::nested($data, 'bank_account_details')),
            creditLimit: self::float($data, 'credit_limit'),
            creditDays: self::integer($data, 'credit_days'),
            creditTerms: self::string($data, 'credit_terms'),
            creditTermsAndConditions: self::string($data, 'credit_terms_and_conditions'),
            productSalesPriceType: Reference::fromNullable(self::nested($data, 'product_sales_price_type')),
            sourceGuid: self::string($data, 'source_guid'),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
            auxReference: self::string($data, 'aux_reference'),
            registeredNumber: self::string($data, 'registered_number'),
            deletable: self::boolean($data, 'deletable'),
            taxTreatment: ContactTaxTreatment::fromNullable(self::nested($data, 'tax_treatment')),
            email: self::string($data, 'email'),
            taxCalculation: self::string($data, 'tax_calculation'),
            auxiliaryAccount: self::string($data, 'auxiliary_account'),
            gdprObfuscated: self::boolean($data, 'gdpr_obfuscated'),
            system: self::boolean($data, 'system'),
            hasUnfinishedRecurringInvoices: self::boolean($data, 'has_unfinished_recurring_invoices'),
            cisRegistered: self::boolean($data, 'cis_registered'),
            niBased: self::boolean($data, 'ni_based'),
            isActive: self::boolean($data, 'is_active'),
            gbBased: self::boolean($data, 'gb_based'),
            cisSettings: ContactCisSettings::fromNullable(self::nested($data, 'cis_settings')),
            destinationVatBlocking: self::boolean($data, 'destination_vat_blocking'),
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
