<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\LedgerEntries;

use ChrisJohnLeah\SageAccounting\Data\LedgerEntry;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Returns a Ledger Entry
 *
 * GET /ledger_entries/{key}
 */
class GetLedgerEntriesKey extends Request
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
        return str_replace('{key}', rawurlencode($this->key), '/ledger_entries/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }

    public function createDtoFromResponse(Response $response): ?LedgerEntry
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return LedgerEntry::fromArray($data);
    }
}
