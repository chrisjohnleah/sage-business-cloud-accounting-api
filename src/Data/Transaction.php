<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

/**
 * Sage's posted transaction — the ledger record that a purchase invoice (and
 * other documents) post against. On the cashflow screen it links an invoice to
 * its underlying journal so totals can be reconciled.
 */
final readonly class Transaction
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?DateTimeImmutable $date = null,
        public ?bool $deleted = null,
        public ?string $reference = null,
        public ?float $total = null,
        public ?float $totalInTransactionCurrency = null,
        public ?Reference $contact = null,
        public ?Reference $transactionType = null,
        public ?string $auditTrailId = null,
        public ?string $numberOfAttachments = null,
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
            date: self::dateTime($data, 'date'),
            deleted: self::boolean($data, 'deleted'),
            reference: self::string($data, 'reference'),
            total: self::float($data, 'total'),
            totalInTransactionCurrency: self::float($data, 'total_in_transaction_currency'),
            contact: Reference::fromNullable(self::nested($data, 'contact')),
            transactionType: Reference::fromNullable(self::nested($data, 'transaction_type')),
            auditTrailId: self::string($data, 'audit_trail_id'),
            numberOfAttachments: self::string($data, 'number_of_attachments'),
            // v0.1: not yet typed — origin (TransactionOrigin)
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
