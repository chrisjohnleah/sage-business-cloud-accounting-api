<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\PurchaseQuickEntries;

use ChrisJohnLeah\SageAccounting\Data\PurchaseQuickEntry;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Updates a Purchase Quick Entry
 *
 * PUT /purchase_quick_entries/{key}
 */
class PutPurchaseQuickEntriesKey extends Request implements HasBody
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
        return str_replace('{key}', rawurlencode($this->key), '/purchase_quick_entries/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?PurchaseQuickEntry
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return PurchaseQuickEntry::fromArray($data);
    }
}
