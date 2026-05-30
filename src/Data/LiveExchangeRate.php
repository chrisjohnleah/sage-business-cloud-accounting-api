<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class LiveExchangeRate
{
    use MapsAttributes;

    public function __construct(
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?float $rate = null,
        public ?float $inverseRate = null,
        public ?Reference $baseCurrency = null,
        public ?Reference $currency = null,
        public ?DateTimeImmutable $retrievedAt = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            displayedAs: self::string($data, 'displayed_as'),
            path: self::string($data, '$path'),
            rate: self::float($data, 'rate'),
            inverseRate: self::float($data, 'inverse_rate'),
            baseCurrency: Reference::fromNullable(self::nested($data, 'base_currency')),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
            retrievedAt: self::dateTime($data, 'retrieved_at'),
            updatedAt: self::dateTime($data, 'updated_at'),
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
