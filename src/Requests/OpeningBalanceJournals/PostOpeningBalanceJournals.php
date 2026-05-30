<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\OpeningBalanceJournals;

use ChrisJohnLeah\SageAccounting\Data\OpeningBalanceJournal;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a Opening Balance Journal
 *
 * POST /opening_balance_journals
 */
class PostOpeningBalanceJournals extends Request implements HasBody
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
        return '/opening_balance_journals';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?OpeningBalanceJournal
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return OpeningBalanceJournal::fromArray($data);
    }
}
