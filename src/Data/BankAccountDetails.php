<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class BankAccountDetails
{
    use MapsAttributes;

    public function __construct(
        public ?string $accountName = null,
        public ?string $accountNumber = null,
        public ?string $sortCode = null,
        public ?string $bic = null,
        public ?string $iban = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            accountName: self::string($data, 'account_name'),
            accountNumber: self::string($data, 'account_number'),
            sortCode: self::string($data, 'sort_code'),
            bic: self::string($data, 'bic'),
            iban: self::string($data, 'iban'),
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
