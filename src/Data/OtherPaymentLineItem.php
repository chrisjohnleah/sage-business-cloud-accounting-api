<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class OtherPaymentLineItem
{
    use MapsAttributes;

    /**
     * @param  list<AnalysisTypeLineItem>  $analysisTypeCategories
     * @param  list<TaxBreakdown>  $taxBreakdown
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public array $analysisTypeCategories = [],
        public ?Reference $ledgerAccount = null,
        public ?string $details = null,
        public ?Reference $taxRate = null,
        public ?float $netAmount = null,
        public ?float $taxAmount = null,
        public ?float $totalAmount = null,
        public array $taxBreakdown = [],
        public ?bool $isPurchaseForResale = null,
        public ?bool $tradeOfAsset = null,
        public ?float $gstAmount = null,
        public ?float $pstAmount = null,
        public ?bool $taxRecoverable = null,
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
            analysisTypeCategories: array_map(static fn (array $item): AnalysisTypeLineItem => AnalysisTypeLineItem::fromArray($item), self::nestedList($data, 'analysis_type_categories')),
            ledgerAccount: Reference::fromNullable(self::nested($data, 'ledger_account')),
            details: self::string($data, 'details'),
            taxRate: Reference::fromNullable(self::nested($data, 'tax_rate')),
            netAmount: self::float($data, 'net_amount'),
            taxAmount: self::float($data, 'tax_amount'),
            totalAmount: self::float($data, 'total_amount'),
            taxBreakdown: array_map(static fn (array $item): TaxBreakdown => TaxBreakdown::fromArray($item), self::nestedList($data, 'tax_breakdown')),
            isPurchaseForResale: self::boolean($data, 'is_purchase_for_resale'),
            tradeOfAsset: self::boolean($data, 'trade_of_asset'),
            gstAmount: self::float($data, 'gst_amount'),
            pstAmount: self::float($data, 'pst_amount'),
            taxRecoverable: self::boolean($data, 'tax_recoverable'),
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
