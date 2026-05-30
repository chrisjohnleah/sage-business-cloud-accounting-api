<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class AllocatedArtefact
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?Generic $artefact = null,
        public ?float $amount = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: self::string($data, 'id'),
            artefact: Generic::fromNullable(self::nested($data, 'artefact')),
            amount: self::float($data, 'amount'),
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
