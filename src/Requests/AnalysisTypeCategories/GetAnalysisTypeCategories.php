<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\AnalysisTypeCategories;

use ChrisJohnLeah\SageAccounting\Data\Paginated;
use ChrisJohnLeah\SageAccounting\Http\SageRequest;
use Saloon\Http\Response;

/**
 * Returns all Analysis Type Categories
 *
 * GET /analysis_type_categories
 */
class GetAnalysisTypeCategories extends SageRequest
{
    /**
     * @param  array<string, mixed>  $filters
     */
    public function __construct(
        private readonly array $filters = [],
    ) {
    }

    protected function endpoint(): string
    {
        return '/analysis_type_categories';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }

    public function createDtoFromResponse(Response $response): Paginated
    {
        $data = $response->json();

        /** @var array<string, mixed> $payload */
        $payload = is_array($data) ? $data : [];

        return Paginated::fromArray($payload);
    }
}
