<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class FooterDetails
{
    use MapsAttributes;

    public function __construct(
        public ?string $column1 = null,
        public ?string $column2 = null,
        public ?string $column3 = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            column1: self::string($data, 'column_1'),
            column2: self::string($data, 'column_2'),
            column3: self::string($data, 'column_3'),
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
