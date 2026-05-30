<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Pagination;

use ChrisJohnLeah\SageAccounting\Http\SageRequest;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Paginator;

/**
 * Drives pagination from the absolute "$next" URL Sage returns in the response
 * body (rather than offset/cursor query params). The first page sends the
 * request untouched; each subsequent page points the request at "$next".
 */
class SagePaginator extends Paginator
{
    protected ?string $nextUrl = null;

    protected function applyPagination(Request $request): Request
    {
        if ($this->currentResponse instanceof Response) {
            $this->nextUrl = $this->extractNextUrl($this->currentResponse);
        }

        if ($this->nextUrl !== null && $request instanceof SageRequest) {
            $request->paginationUrl = $this->nextUrl;
        }

        return $request;
    }

    protected function isLastPage(Response $response): bool
    {
        return $this->extractNextUrl($response) === null;
    }

    /**
     * @return array<int, mixed>
     */
    protected function getPageItems(Response $response, Request $request): array
    {
        $items = $response->json('$items');

        return is_array($items) ? array_values($items) : [];
    }

    protected function onRewind(): void
    {
        $this->nextUrl = null;
    }

    private function extractNextUrl(Response $response): ?string
    {
        $next = $response->json('$next');

        return is_string($next) && $next !== '' ? $next : null;
    }
}
