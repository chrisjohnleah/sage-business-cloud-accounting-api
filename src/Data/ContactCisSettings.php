<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class ContactCisSettings
{
    use MapsAttributes;

    public function __construct(
        public ?string $registeredCisName = null,
        public ?string $subcontractorVerificationNumber = null,
        public ?ContactCisDeductionRate $deductionRate = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            registeredCisName: self::string($data, 'registered_cis_name'),
            subcontractorVerificationNumber: self::string($data, 'subcontractor_verification_number'),
            deductionRate: ContactCisDeductionRate::fromNullable(self::nested($data, 'deduction_rate')),
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
