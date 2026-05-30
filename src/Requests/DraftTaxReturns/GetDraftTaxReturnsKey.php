<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\DraftTaxReturns;

use ChrisJohnLeah\SageAccounting\Data\DraftTaxReturn;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Returns a Draft Tax Return
 *
 * GET /draft_tax_returns/{key}
 */
class GetDraftTaxReturnsKey extends Request
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
        return str_replace('{key}', rawurlencode($this->key), '/draft_tax_returns/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }

    public function createDtoFromResponse(Response $response): ?DraftTaxReturn
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return DraftTaxReturn::fromArray($data);
    }
}
