<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\AnalysisTypeCategories;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Returns a Analysis Type Category
 *
 * GET /analysis_type_categories/{key}
 */
class GetAnalysisTypeCategoriesKey extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $filters
     */
    public function __construct(
        private readonly string $key,
        private readonly array $filters = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/analysis_type_categories/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }
}
