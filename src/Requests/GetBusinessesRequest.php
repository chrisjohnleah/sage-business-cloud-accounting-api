<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests;

use ChrisJohnLeah\SageAccounting\Data\Paginated;
use ChrisJohnLeah\SageAccounting\Http\SageRequest;
use Saloon\Http\Response;

/**
 * GET /businesses — the companies the authenticated user can access. The id of
 * the chosen business is what you send in the `X-Business` header thereafter.
 */
class GetBusinessesRequest extends SageRequest
{
    /**
     * @param  array<string, scalar|null>  $filters  e.g. ['active_only' => true, 'name' => 'Acme']
     */
    public function __construct(private readonly array $filters = [])
    {
    }

    protected function endpoint(): string
    {
        return '/businesses';
    }

    /**
     * @return array<string, scalar>
     */
    protected function defaultQuery(): array
    {
        return array_filter(
            $this->filters,
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
