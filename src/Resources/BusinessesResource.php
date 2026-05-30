<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Resources;

use ChrisJohnLeah\SageAccounting\Data\Business;
use ChrisJohnLeah\SageAccounting\Requests\GetBusinessesRequest;
use ChrisJohnLeah\SageAccounting\Sage;

final readonly class BusinessesResource
{
    public function __construct(private Sage $sage)
    {
    }

    /**
     * Lazily iterate every business across all pages.
     *
     * @param  array<string, scalar|null>  $filters
     * @return iterable<Business>
     */
    public function list(array $filters = []): iterable
    {
        $paginator = $this->sage->connector()->paginate(new GetBusinessesRequest($filters));

        foreach ($paginator->items() as $item) {
            if (is_array($item)) {
                /** @var array<string, mixed> $item */
                yield Business::fromArray($item);
            }
        }
    }
}
