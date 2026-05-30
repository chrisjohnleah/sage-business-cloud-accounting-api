<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\InvoiceSettings;

use ChrisJohnLeah\SageAccounting\Data\InvoiceSettings;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Updates a Invoice Settings
 *
 * PUT /invoice_settings
 */
class PutInvoiceSettings extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        private readonly array $payload = [],
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/invoice_settings';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?InvoiceSettings
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return InvoiceSettings::fromArray($data);
    }
}
