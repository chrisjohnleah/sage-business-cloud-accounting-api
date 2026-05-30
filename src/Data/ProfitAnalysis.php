<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class ProfitAnalysis
{
    use MapsAttributes;

    /**
     * @param  list<ProfitBreakdown>  $lineBreakdown
     */
    public function __construct(
        public ?ProfitBreakdown $total = null,
        public array $lineBreakdown = [],
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            total: ProfitBreakdown::fromNullable(self::nested($data, 'total')),
            lineBreakdown: array_map(static fn (array $item): ProfitBreakdown => ProfitBreakdown::fromArray($item), self::nestedList($data, 'line_breakdown')),
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
