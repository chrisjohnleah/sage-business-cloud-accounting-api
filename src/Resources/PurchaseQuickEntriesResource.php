<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Resources;

use ChrisJohnLeah\SageAccounting\Data\PurchaseQuickEntry;
use ChrisJohnLeah\SageAccounting\Requests\PurchaseQuickEntries\GetPurchaseQuickEntries;
use ChrisJohnLeah\SageAccounting\Sage;

final readonly class PurchaseQuickEntriesResource
{
    public function __construct(private Sage $sage)
    {
    }

    /**
     * Lazily iterate every purchase quick entry across all pages. In Sage,
     * quick entries are the fast way to record supplier bills/expenses — for
     * many businesses this is where payables actually live (rather than full
     * purchase invoices).
     *
     * Useful filters: updated_or_created_since (incremental sync), deleted_since,
     * status_id, from_date, to_date, contact_id.
     *
     * @param  array<string, scalar|null>  $filters
     * @return iterable<PurchaseQuickEntry>
     */
    public function list(array $filters = []): iterable
    {
        $paginator = $this->sage->connector()->paginate(
            new GetPurchaseQuickEntries(array_merge(['attributes' => 'all'], $filters)),
        );

        foreach ($paginator->items() as $item) {
            if (is_array($item)) {
                /** @var array<string, mixed> $item */
                yield PurchaseQuickEntry::fromArray($item);
            }
        }
    }
}
