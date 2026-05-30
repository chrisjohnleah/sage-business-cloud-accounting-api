<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class LedgerAccount
{
    use MapsAttributes;

    /**
     * @param  list<mixed>  $visibleScopes
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?CoaGroupType $ledgerAccountGroup = null,
        public ?string $name = null,
        public ?string $displayName = null,
        public array $visibleScopes = [],
        public ?bool $includedInChart = null,
        public ?int $nominalCode = null,
        public ?Reference $ledgerAccountType = null,
        public ?Reference $ledgerAccountClassification = null,
        public ?Reference $taxRate = null,
        public ?bool $fixedTaxRate = null,
        public ?bool $visibleInBanking = null,
        public ?bool $visibleInExpenses = null,
        public ?bool $visibleInJournals = null,
        public ?bool $visibleInOtherPayments = null,
        public ?bool $visibleInOtherReceipts = null,
        public ?bool $visibleInReporting = null,
        public ?bool $visibleInSales = null,
        public ?LedgerAccountBalanceDetails $balanceDetails = null,
        public ?bool $isControlAccount = null,
        public ?string $controlName = null,
        public ?string $displayFormatted = null,
        public ?bool $taxRecoverable = null,
        public ?float $recoverablePercentage = null,
        public ?LedgerAccount $nonRecoverableLedgerAccount = null,
        public ?bool $cisMaterials = null,
        public ?bool $taxInstalment = null,
        public ?bool $cisLabour = null,
        public ?int $gifiCode = null,
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
            ledgerAccountGroup: CoaGroupType::fromNullable(self::nested($data, 'ledger_account_group')),
            name: self::string($data, 'name'),
            displayName: self::string($data, 'display_name'),
            visibleScopes: self::rawList($data, 'visible_scopes'),
            includedInChart: self::boolean($data, 'included_in_chart'),
            nominalCode: self::integer($data, 'nominal_code'),
            ledgerAccountType: Reference::fromNullable(self::nested($data, 'ledger_account_type')),
            ledgerAccountClassification: Reference::fromNullable(self::nested($data, 'ledger_account_classification')),
            taxRate: Reference::fromNullable(self::nested($data, 'tax_rate')),
            fixedTaxRate: self::boolean($data, 'fixed_tax_rate'),
            visibleInBanking: self::boolean($data, 'visible_in_banking'),
            visibleInExpenses: self::boolean($data, 'visible_in_expenses'),
            visibleInJournals: self::boolean($data, 'visible_in_journals'),
            visibleInOtherPayments: self::boolean($data, 'visible_in_other_payments'),
            visibleInOtherReceipts: self::boolean($data, 'visible_in_other_receipts'),
            visibleInReporting: self::boolean($data, 'visible_in_reporting'),
            visibleInSales: self::boolean($data, 'visible_in_sales'),
            balanceDetails: LedgerAccountBalanceDetails::fromNullable(self::nested($data, 'balance_details')),
            isControlAccount: self::boolean($data, 'is_control_account'),
            controlName: self::string($data, 'control_name'),
            displayFormatted: self::string($data, 'display_formatted'),
            taxRecoverable: self::boolean($data, 'tax_recoverable'),
            recoverablePercentage: self::float($data, 'recoverable_percentage'),
            nonRecoverableLedgerAccount: LedgerAccount::fromNullable(self::nested($data, 'non_recoverable_ledger_account')),
            cisMaterials: self::boolean($data, 'cis_materials'),
            taxInstalment: self::boolean($data, 'tax_instalment'),
            cisLabour: self::boolean($data, 'cis_labour'),
            gifiCode: self::integer($data, 'gifi_code'),
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
