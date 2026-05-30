<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class GBBoxData
{
    use MapsAttributes;

    public function __construct(
        public ?float $box1 = null,
        public ?float $box2 = null,
        public ?float $box3 = null,
        public ?float $box4 = null,
        public ?float $box5 = null,
        public ?float $box6 = null,
        public ?float $box7 = null,
        public ?float $box8 = null,
        public ?float $box9 = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            box1: self::float($data, 'box_1'),
            box2: self::float($data, 'box_2'),
            box3: self::float($data, 'box_3'),
            box4: self::float($data, 'box_4'),
            box5: self::float($data, 'box_5'),
            box6: self::float($data, 'box_6'),
            box7: self::float($data, 'box_7'),
            box8: self::float($data, 'box_8'),
            box9: self::float($data, 'box_9'),
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
