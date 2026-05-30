<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests;

use ChrisJohnLeah\SageAccounting\Data\Paginated;
use ChrisJohnLeah\SageAccounting\Http\SageRequest;
use Saloon\Http\Response;

/**
 * GET /contacts — the customers and suppliers in the targeted business.
 *
 * Requests `attributes=all` so the full contact object (including nested
 * addresses) is hydrated rather than Sage's default trimmed view.
 *
 * Supported filter keys:
 * - updated_or_created_since: ISO-8601 timestamp; only changed records
 * - deleted_since: ISO-8601 timestamp; tombstones for sync
 * - contact_type_id: filter to CUSTOMER or VENDOR
 * - items_per_page: page size (max 200)
 * - page: 1-based page number
 * - search: free-text match on name / reference
 * - email: filter to a specific email address
 */
class GetContactsRequest extends SageRequest
{
    /**
     * @param  array<string, scalar|null>  $filters  e.g. ['contact_type_id' => 'CUSTOMER', 'search' => 'Acme']
     */
    public function __construct(private readonly array $filters = [])
    {
    }

    protected function endpoint(): string
    {
        return '/contacts';
    }

    /**
     * @return array<string, scalar>
     */
    protected function defaultQuery(): array
    {
        return array_filter(
            array_merge(['attributes' => 'all'], $this->filters),
            static fn (mixed $value): bool => $value !== null,
        );
    }

    public function createDtoFromResponse(Response $response): Paginated
    {
        $data = $response->json();

        if (! is_array($data)) {
            return Paginated::fromArray([]);
        }

        /** @var array<string, mixed> $data */
        return Paginated::fromArray($data);
    }
}
