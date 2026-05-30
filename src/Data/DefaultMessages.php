<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class DefaultMessages
{
    use MapsAttributes;

    public function __construct(
        public ?string $messageType = null,
        public ?string $locale = null,
        public ?string $message = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            messageType: self::string($data, 'message_type'),
            locale: self::string($data, 'locale'),
            message: self::string($data, 'message'),
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
