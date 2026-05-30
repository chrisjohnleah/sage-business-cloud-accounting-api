<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class CoaAccount
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?CoaGroupType $ledgerAccountGroup = null,
        public ?string $name = null,
        public ?string $controlName = null,
        public ?int $nominalCode = null,
        public ?Reference $ledgerAccountType = null,
        public ?Reference $ledgerAccountClassification = null,
        public ?Reference $taxRate = null,
        public ?bool $fixedTaxRate = null,
        public ?bool $cisMaterials = null,
        public ?bool $cisLabour = null,
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
            path: self::string($data, '$path'),
            createdAt: self::dateTime($data, 'created_at'),
            updatedAt: self::dateTime($data, 'updated_at'),
            ledgerAccountGroup: CoaGroupType::fromNullable(self::nested($data, 'ledger_account_group')),
            name: self::string($data, 'name'),
            controlName: self::string($data, 'control_name'),
            nominalCode: self::integer($data, 'nominal_code'),
            ledgerAccountType: Reference::fromNullable(self::nested($data, 'ledger_account_type')),
            ledgerAccountClassification: Reference::fromNullable(self::nested($data, 'ledger_account_classification')),
            taxRate: Reference::fromNullable(self::nested($data, 'tax_rate')),
            fixedTaxRate: self::boolean($data, 'fixed_tax_rate'),
            cisMaterials: self::boolean($data, 'cis_materials'),
            cisLabour: self::boolean($data, 'cis_labour'),
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
