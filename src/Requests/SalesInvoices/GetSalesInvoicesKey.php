<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\SalesInvoices;

use ChrisJohnLeah\SageAccounting\Data\SalesInvoice;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Returns a Sales Invoice
 *
 * GET /sales_invoices/{key}
 */
class GetSalesInvoicesKey extends Request
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
        return str_replace('{key}', rawurlencode($this->key), '/sales_invoices/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }

    public function createDtoFromResponse(Response $response): ?SalesInvoice
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return SalesInvoice::fromArray($data);
    }
}
