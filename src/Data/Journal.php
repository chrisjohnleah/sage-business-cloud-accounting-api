<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class Journal
{
    use MapsAttributes;

    /**
     * @param  list<JournalLine>  $journalLines
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?Reference $transaction = null,
        public ?Reference $transactionType = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?DateTimeImmutable $date = null,
        public ?string $reference = null,
        public ?string $description = null,
        public ?float $total = null,
        public ?JournalCode $journalCode = null,
        public array $journalLines = [],
        public ?bool $migrated = null,
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
            transaction: Reference::fromNullable(self::nested($data, 'transaction')),
            transactionType: Reference::fromNullable(self::nested($data, 'transaction_type')),
            deletedAt: self::dateTime($data, 'deleted_at'),
            date: self::dateTime($data, 'date'),
            reference: self::string($data, 'reference'),
            description: self::string($data, 'description'),
            total: self::float($data, 'total'),
            journalCode: JournalCode::fromNullable(self::nested($data, 'journal_code')),
            journalLines: array_map(static fn (array $item): JournalLine => JournalLine::fromArray($item), self::nestedList($data, 'journal_lines')),
            migrated: self::boolean($data, 'migrated'),
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
