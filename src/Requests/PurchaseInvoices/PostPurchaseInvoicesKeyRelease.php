<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\PurchaseInvoices;

use ChrisJohnLeah\SageAccounting\Data\PurchaseInvoice;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Releases a Purchase Invoice
 *
 * POST /purchase_invoices/{key}/release
 */
class PostPurchaseInvoicesKeyRelease extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        private readonly string $key,
        private readonly array $payload = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/purchase_invoices/{key}/release');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?PurchaseInvoice
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return PurchaseInvoice::fromArray($data);
    }
}
