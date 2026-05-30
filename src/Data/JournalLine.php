<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class JournalLine
{
    use MapsAttributes;

    /**
     * @param  list<AnalysisTypeLineItem>  $analysisTypeCategories
     */
    public function __construct(
        public ?string $id = null,
        public ?LedgerAccount $ledgerAccount = null,
        public ?string $details = null,
        public ?float $debit = null,
        public ?float $credit = null,
        public array $analysisTypeCategories = [],
        public ?bool $includeOnTaxReturn = null,
        public ?bool $taxReconciled = null,
        public ?bool $cleared = null,
        public ?bool $bankReconciled = null,
        public ?string $journalLineForeignCurrency = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: self::string($data, 'id'),
            ledgerAccount: LedgerAccount::fromNullable(self::nested($data, 'ledger_account')),
            details: self::string($data, 'details'),
            debit: self::float($data, 'debit'),
            credit: self::float($data, 'credit'),
            analysisTypeCategories: array_map(static fn (array $item): AnalysisTypeLineItem => AnalysisTypeLineItem::fromArray($item), self::nestedList($data, 'analysis_type_categories')),
            includeOnTaxReturn: self::boolean($data, 'include_on_tax_return'),
            taxReconciled: self::boolean($data, 'tax_reconciled'),
            cleared: self::boolean($data, 'cleared'),
            bankReconciled: self::boolean($data, 'bank_reconciled'),
            journalLineForeignCurrency: self::string($data, 'journal_line_foreign_currency'),
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
