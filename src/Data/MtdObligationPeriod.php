<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class MtdObligationPeriod
{
    use MapsAttributes;

    public function __construct(
        public ?DateTimeImmutable $startDate = null,
        public ?DateTimeImmutable $endDate = null,
        public ?DateTimeImmutable $dueDate = null,
        public ?DateTimeImmutable $receivedDate = null,
        public ?string $hmrcStatus = null,
        public ?string $periodKey = null,
        public ?string $status = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            startDate: self::dateTime($data, 'start_date'),
            endDate: self::dateTime($data, 'end_date'),
            dueDate: self::dateTime($data, 'due_date'),
            receivedDate: self::dateTime($data, 'received_date'),
            hmrcStatus: self::string($data, 'hmrc_status'),
            periodKey: self::string($data, 'period_key'),
            status: self::string($data, 'status'),
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
