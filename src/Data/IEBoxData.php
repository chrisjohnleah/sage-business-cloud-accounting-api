<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class IEBoxData
{
    use MapsAttributes;

    public function __construct(
        public ?float $boxT1 = null,
        public ?float $boxT2 = null,
        public ?float $boxT3 = null,
        public ?float $boxT4 = null,
        public ?float $boxE1 = null,
        public ?float $boxE2 = null,
        public ?float $boxES1 = null,
        public ?float $boxES2 = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            boxT1: self::float($data, 'box_T1'),
            boxT2: self::float($data, 'box_T2'),
            boxT3: self::float($data, 'box_T3'),
            boxT4: self::float($data, 'box_T4'),
            boxE1: self::float($data, 'box_E1'),
            boxE2: self::float($data, 'box_E2'),
            boxES1: self::float($data, 'box_ES1'),
            boxES2: self::float($data, 'box_ES2'),
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
