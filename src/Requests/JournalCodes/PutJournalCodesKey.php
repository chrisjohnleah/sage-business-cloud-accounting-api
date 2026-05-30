<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\JournalCodes;

use ChrisJohnLeah\SageAccounting\Data\JournalCode;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Updates a Journal Code
 *
 * PUT /journal_codes/{key}
 */
class PutJournalCodesKey extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        private readonly string $key,
        private readonly array $payload = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/journal_codes/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?JournalCode
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return JournalCode::fromArray($data);
    }
}
