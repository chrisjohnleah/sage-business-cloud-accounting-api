<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class BusinessSettings
{
    use MapsAttributes;

    public function __construct(
        public ?string $path = null,
        public ?string $siret = null,
        public ?bool $managementCentreMember = null,
        public ?string $rcsNumber = null,
        public ?float $shareCapital = null,
        public ?BusinessActivityType $businessActivityType = null,
        public ?LegalFormType $legalFormType = null,
        public ?bool $auxiliaryAccountsVisible = null,
        public ?DefaultLedgerAccounts $defaultLedgerAccounts = null,
        public ?BusinessType $businessType = null,
        public ?Reference $countryOfRegistration = null,
        public ?DateTimeImmutable $businessCreatedAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?bool $wizardComplete = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            path: self::string($data, '$path'),
            siret: self::string($data, 'siret'),
            managementCentreMember: self::boolean($data, 'management_centre_member'),
            rcsNumber: self::string($data, 'rcs_number'),
            shareCapital: self::float($data, 'share_capital'),
            businessActivityType: BusinessActivityType::fromNullable(self::nested($data, 'business_activity_type')),
            legalFormType: LegalFormType::fromNullable(self::nested($data, 'legal_form_type')),
            auxiliaryAccountsVisible: self::boolean($data, 'auxiliary_accounts_visible'),
            defaultLedgerAccounts: DefaultLedgerAccounts::fromNullable(self::nested($data, 'default_ledger_accounts')),
            businessType: BusinessType::fromNullable(self::nested($data, 'business_type')),
            countryOfRegistration: Reference::fromNullable(self::nested($data, 'country_of_registration')),
            businessCreatedAt: self::dateTime($data, 'business_created_at'),
            updatedAt: self::dateTime($data, 'updated_at'),
            wizardComplete: self::boolean($data, 'wizard_complete'),
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
