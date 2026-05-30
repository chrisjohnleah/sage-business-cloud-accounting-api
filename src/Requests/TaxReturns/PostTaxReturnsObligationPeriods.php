<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\TaxReturns;

use ChrisJohnLeah\SageAccounting\Data\MtdObligationPeriod;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Returns a Tax Return of the Obligation Period
 *
 * POST /tax_returns/obligation_periods
 */
class PostTaxReturnsObligationPeriods extends Request implements HasBody
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
        return '/tax_returns/obligation_periods';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?MtdObligationPeriod
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return MtdObligationPeriod::fromArray($data);
    }
}
