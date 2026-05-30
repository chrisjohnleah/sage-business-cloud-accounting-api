<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class RecurringSalesInvoice
{
    use MapsAttributes;

    /**
     * @param  list<Link>  $links
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public array $links = [],
        public ?int $frequency = null,
        public ?int $onWeekDay = null,
        public ?int $onDayNumber = null,
        public ?string $recurrenceType = null,
        public ?string $recurrenceStatusIdentifier = null,
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
            links: array_map(static fn (array $item): Link => Link::fromArray($item), self::nestedList($data, 'links')),
            frequency: self::integer($data, 'frequency'),
            onWeekDay: self::integer($data, 'on_week_day'),
            onDayNumber: self::integer($data, 'on_day_number'),
            recurrenceType: self::string($data, 'recurrence_type'),
            recurrenceStatusIdentifier: self::string($data, 'recurrence_status_identifier'),
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
