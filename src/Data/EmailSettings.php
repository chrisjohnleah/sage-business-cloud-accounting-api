<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class EmailSettings
{
    use MapsAttributes;

    /**
     * @param  list<DefaultMessages>  $defaultMessages
     */
    public function __construct(
        public array $defaultMessages = [],
        public ?bool $pdfAttached = null,
        public ?bool $sendBcc = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            defaultMessages: array_map(static fn (array $item): DefaultMessages => DefaultMessages::fromArray($item), self::nestedList($data, 'default_messages')),
            pdfAttached: self::boolean($data, 'pdf_attached'),
            sendBcc: self::boolean($data, 'send_bcc'),
            updatedAt: self::dateTime($data, 'updated_at'),
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
