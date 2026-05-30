<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

/**
 * Sage's collection envelope. The raw {@see $items} are left as arrays so the
 * calling resource can hydrate them into the appropriate entity DTO.
 *
 * Note: Sage is inconsistent about the per-page key — `$items_per_page` on some
 * endpoints, `$itemsPerPage` on others — so {@see fromArray()} tolerates both.
 */
final readonly class Paginated
{
    /**
     * @param  list<array<string, mixed>>  $items
     */
    public function __construct(
        public int $total,
        public int $page,
        public ?string $next,
        public ?string $back,
        public int $itemsPerPage,
        public array $items,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            total: self::int($data, '$total', 0),
            page: self::int($data, '$page', 1),
            next: is_string($data['$next'] ?? null) ? $data['$next'] : null,
            back: is_string($data['$back'] ?? null) ? $data['$back'] : null,
            itemsPerPage: self::resolveItemsPerPage($data),
            items: self::items($data),
        );
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private static function int(array $data, string $key, int $default): int
    {
        $value = $data[$key] ?? null;

        return is_int($value) ? $value : $default;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private static function resolveItemsPerPage(array $data): int
    {
        foreach (['$items_per_page', '$itemsPerPage'] as $key) {
            $value = $data[$key] ?? null;

            if (is_int($value)) {
                return $value;
            }
        }

        return 0;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return list<array<string, mixed>>
     */
    private static function items(array $data): array
    {
        $items = $data['$items'] ?? null;

        if (! is_array($items)) {
            return [];
        }

        $result = [];

        foreach ($items as $item) {
            if (is_array($item)) {
                /** @var array<string, mixed> $item */
                $result[] = $item;
            }
        }

        return $result;
    }
}
