<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class InvoiceSettingsDocumentHeadings
{
    use MapsAttributes;

    public function __construct(
        public ?string $salesInvoice = null,
        public ?string $salesCreditNote = null,
        public ?string $salesCorrectiveInvoice = null,
        public ?string $salesQuote = null,
        public ?string $salesEstimate = null,
        public ?string $proForma = null,
        public ?string $remittanceAdvice = null,
        public ?string $statement = null,
        public ?string $deliveryNote = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            salesInvoice: self::string($data, 'sales_invoice'),
            salesCreditNote: self::string($data, 'sales_credit_note'),
            salesCorrectiveInvoice: self::string($data, 'sales_corrective_invoice'),
            salesQuote: self::string($data, 'sales_quote'),
            salesEstimate: self::string($data, 'sales_estimate'),
            proForma: self::string($data, 'pro_forma'),
            remittanceAdvice: self::string($data, 'remittance_advice'),
            statement: self::string($data, 'statement'),
            deliveryNote: self::string($data, 'delivery_note'),
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
