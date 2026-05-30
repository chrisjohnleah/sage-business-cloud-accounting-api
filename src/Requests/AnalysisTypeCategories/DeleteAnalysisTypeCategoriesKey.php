<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\AnalysisTypeCategories;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Analysis Type Category
 *
 * DELETE /analysis_type_categories/{key}
 */
class DeleteAnalysisTypeCategoriesKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/analysis_type_categories/{key}');
    }
}
