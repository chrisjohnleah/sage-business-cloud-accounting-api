<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class ProfitBreakdown
{
    use MapsAttributes;

    public function __construct(
        public ?string $description = null,
        public ?float $totalCost = null,
        public ?float $totalSale = null,
        public ?float $profit = null,
        public ?float $profitPercentage = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            description: self::string($data, 'description'),
            totalCost: self::float($data, 'total_cost'),
            totalSale: self::float($data, 'total_sale'),
            profit: self::float($data, 'profit'),
            profitPercentage: self::float($data, 'profit_percentage'),
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
