<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class FinancialSettings
{
    use MapsAttributes;

    public function __construct(
        public ?string $path = null,
        public ?DateTimeImmutable $yearEndDate = null,
        public ?DateTimeImmutable $yearEndLockdownDate = null,
        public ?string $accountingType = null,
        public ?DateTimeImmutable $accountsStartDate = null,
        public ?Reference $baseCurrency = null,
        public ?bool $multiCurrencyEnabled = null,
        public ?bool $useLiveExchangeRates = null,
        public ?string $mtdActivationStatus = null,
        public ?bool $mtdConnected = null,
        public ?DateTimeImmutable $mtdAuthenticatedDate = null,
        public ?TaxScheme $taxScheme = null,
        public ?Reference $taxReturnFrequency = null,
        public ?string $taxNumber = null,
        public ?string $generalTaxNumber = null,
        public ?Reference $taxOffice = null,
        public ?float $defaultIrpfRate = null,
        public ?float $flatRateTaxPercentage = null,
        public ?float $recoverablePercentage = null,
        public ?string $salesTaxCalculation = null,
        public ?string $purchaseTaxCalculation = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?bool $postponedAccounting = null,
        public ?bool $destinationVat = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            path: self::string($data, '$path'),
            yearEndDate: self::dateTime($data, 'year_end_date'),
            yearEndLockdownDate: self::dateTime($data, 'year_end_lockdown_date'),
            accountingType: self::string($data, 'accounting_type'),
            accountsStartDate: self::dateTime($data, 'accounts_start_date'),
            baseCurrency: Reference::fromNullable(self::nested($data, 'base_currency')),
            multiCurrencyEnabled: self::boolean($data, 'multi_currency_enabled'),
            useLiveExchangeRates: self::boolean($data, 'use_live_exchange_rates'),
            mtdActivationStatus: self::string($data, 'mtd_activation_status'),
            mtdConnected: self::boolean($data, 'mtd_connected'),
            mtdAuthenticatedDate: self::dateTime($data, 'mtd_authenticated_date'),
            taxScheme: TaxScheme::fromNullable(self::nested($data, 'tax_scheme')),
            taxReturnFrequency: Reference::fromNullable(self::nested($data, 'tax_return_frequency')),
            taxNumber: self::string($data, 'tax_number'),
            generalTaxNumber: self::string($data, 'general_tax_number'),
            taxOffice: Reference::fromNullable(self::nested($data, 'tax_office')),
            defaultIrpfRate: self::float($data, 'default_irpf_rate'),
            flatRateTaxPercentage: self::float($data, 'flat_rate_tax_percentage'),
            recoverablePercentage: self::float($data, 'recoverable_percentage'),
            salesTaxCalculation: self::string($data, 'sales_tax_calculation'),
            purchaseTaxCalculation: self::string($data, 'purchase_tax_calculation'),
            updatedAt: self::dateTime($data, 'updated_at'),
            postponedAccounting: self::boolean($data, 'postponed_accounting'),
            destinationVat: self::boolean($data, 'destination_vat'),
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
