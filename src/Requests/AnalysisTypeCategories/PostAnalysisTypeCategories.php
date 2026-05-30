<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\AnalysisTypeCategories;

use ChrisJohnLeah\SageAccounting\Data\AnalysisTypeCategory;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a Analysis Type Category
 *
 * POST /analysis_type_categories
 */
class PostAnalysisTypeCategories extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        private readonly array $payload = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/analysis_type_categories';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?AnalysisTypeCategory
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return AnalysisTypeCategory::fromArray($data);
    }
}
