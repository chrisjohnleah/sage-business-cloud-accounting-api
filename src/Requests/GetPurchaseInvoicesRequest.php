<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests;

use ChrisJohnLeah\SageAccounting\Data\Paginated;
use ChrisJohnLeah\SageAccounting\Http\SageRequest;
use Saloon\Http\Response;

/**
 * GET /purchase_invoices — supplier invoices the business owes. Requests the
 * full attribute set so the cashflow screen gets outstanding amounts, due dates
 * and the nested contact/status/lines in a single round trip.
 *
 * Supported filters: updated_or_created_since, deleted_since, status_id,
 * contact_id, from_date, to_date, items_per_page, page, sort, search.
 */
class GetPurchaseInvoicesRequest extends SageRequest
{
    /**
     * @param  array<string, scalar|null>  $filters  e.g. ['contact_id' => 'abc', 'from_date' => '2026-01-01']
     */
    public function __construct(private readonly array $filters = [])
    {
    }

    protected function endpoint(): string
    {
        return '/purchase_invoices';
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
