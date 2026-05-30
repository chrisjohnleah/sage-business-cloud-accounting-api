<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class CisSettings
{
    use MapsAttributes;

    public function __construct(
        public ?string $path = null,
        public ?string $uniqueTaxReference = null,
        public ?bool $contractor = null,
        public ?bool $subcontractor = null,
        public ?string $accountsOfficeReference = null,
        public ?string $payeReference = null,
        public ?Reference $taxRate = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            path: self::string($data, '$path'),
            uniqueTaxReference: self::string($data, 'unique_tax_reference'),
            contractor: self::boolean($data, 'contractor'),
            subcontractor: self::boolean($data, 'subcontractor'),
            accountsOfficeReference: self::string($data, 'accounts_office_reference'),
            payeReference: self::string($data, 'paye_reference'),
            taxRate: Reference::fromNullable(self::nested($data, 'tax_rate')),
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
