<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class TransactionOrigin
{
    use MapsAttributes;

    /**
     * @param  list<Link>  $links
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public array $links = [],
        public ?DateTimeImmutable $dueDate = null,
        public ?float $outstandingAmount = null,
        public ?Reference $currency = null,
        public ?Reference $status = null,
        public ?bool $sent = null,
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
            links: array_map(static fn (array $item): Link => Link::fromArray($item), self::nestedList($data, 'links')),
            dueDate: self::dateTime($data, 'due_date'),
            outstandingAmount: self::float($data, 'outstanding_amount'),
            currency: Reference::fromNullable(self::nested($data, 'currency')),
            status: Reference::fromNullable(self::nested($data, 'status')),
            sent: self::boolean($data, 'sent'),
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
