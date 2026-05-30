<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Resources;

use ChrisJohnLeah\SageAccounting\Data\PurchaseInvoice;
use ChrisJohnLeah\SageAccounting\Requests\PurchaseInvoices\GetPurchaseInvoices;
use ChrisJohnLeah\SageAccounting\Sage;

final readonly class PurchaseInvoicesResource
{
    public function __construct(private Sage $sage)
    {
    }

    /**
     * Lazily iterate every purchase invoice (supplier bill) across all pages.
     *
     * Useful filters: updated_or_created_since (incremental sync), deleted_since,
     * status_id, from_date, to_date, contact_id.
     *
     * @param  array<string, scalar|null>  $filters
     * @return iterable<PurchaseInvoice>
     */
    public function list(array $filters = []): iterable
    {
        $paginator = $this->sage->connector()->paginate(
            new GetPurchaseInvoices(array_merge(['attributes' => 'all'], $filters)),
        );

        foreach ($paginator->items() as $item) {
            if (is_array($item)) {
                /** @var array<string, mixed> $item */
                yield PurchaseInvoice::fromArray($item);
            }
        }
    }
}
