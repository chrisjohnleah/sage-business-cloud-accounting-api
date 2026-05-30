<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class AnalysisType
{
    use MapsAttributes;

    /**
     * @param  list<mixed>  $activeAreas
     * @param  list<mixed>  $analysisTypeLevel
     * @param  list<AnalysisTypeCategory>  $analysisTypeCategories
     */
    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public array $activeAreas = [],
        public array $analysisTypeLevel = [],
        public array $analysisTypeCategories = [],
        public ?string $name = null,
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
            activeAreas: self::rawList($data, 'active_areas'),
            analysisTypeLevel: self::rawList($data, 'analysis_type_level'),
            analysisTypeCategories: array_map(static fn (array $item): AnalysisTypeCategory => AnalysisTypeCategory::fromArray($item), self::nestedList($data, 'analysis_type_categories')),
            name: self::string($data, 'name'),
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
