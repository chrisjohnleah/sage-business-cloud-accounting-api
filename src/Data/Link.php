<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

/**
 * A HATEOAS link returned in an entity's "links" collection.
 */
final readonly class Link
{
    use MapsAttributes;

    public function __construct(
        public ?string $href = null,
        public ?string $rel = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            href: self::string($data, 'href'),
            rel: self::string($data, 'rel'),
            type: self::string($data, 'type'),
        );
    }
}
