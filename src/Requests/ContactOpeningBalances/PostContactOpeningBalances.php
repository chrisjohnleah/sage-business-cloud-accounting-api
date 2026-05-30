<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\ContactOpeningBalances;

use ChrisJohnLeah\SageAccounting\Data\ContactOpeningBalance;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a Contact Opening Balance
 *
 * POST /contact_opening_balances
 */
class PostContactOpeningBalances extends Request implements HasBody
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
        return '/contact_opening_balances';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?ContactOpeningBalance
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return ContactOpeningBalance::fromArray($data);
    }
}
