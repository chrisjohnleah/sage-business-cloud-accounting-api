<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\DraftTaxReturns;

use ChrisJohnLeah\SageAccounting\Data\DraftTaxReturn;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create a Draft Tax Return
 *
 * POST /draft_tax_returns
 */
class PostDraftTaxReturns extends Request implements HasBody
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
        return '/draft_tax_returns';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
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
