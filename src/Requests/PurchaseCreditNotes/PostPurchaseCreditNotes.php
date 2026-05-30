<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\PurchaseCreditNotes;

use ChrisJohnLeah\SageAccounting\Data\PurchaseCreditNote;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a Purchase Credit Note
 *
 * POST /purchase_credit_notes
 */
class PostPurchaseCreditNotes extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        private readonly array $payload = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/purchase_credit_notes';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?PurchaseCreditNote
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return PurchaseCreditNote::fromArray($data);
    }
}
