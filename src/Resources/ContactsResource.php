<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Resources;

use ChrisJohnLeah\SageAccounting\Data\Contact;
use ChrisJohnLeah\SageAccounting\Requests\GetContactsRequest;
use ChrisJohnLeah\SageAccounting\Sage;

final readonly class ContactsResource
{
    public function __construct(private Sage $sage)
    {
    }

    /**
     * Lazily iterate every contact across all pages.
     *
     * Useful filters: updated_or_created_since, deleted_since, contact_type_id,
     * email, search.
     *
     * @param  array<string, scalar|null>  $filters
     * @return iterable<Contact>
     */
    public function list(array $filters = []): iterable
    {
        $paginator = $this->sage->connector()->paginate(new GetContactsRequest($filters));

        foreach ($paginator->items() as $item) {
            if (is_array($item)) {
                /** @var array<string, mixed> $item */
                yield Contact::fromArray($item);
            }
        }
    }
}
