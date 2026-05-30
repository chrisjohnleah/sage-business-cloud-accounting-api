<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\HostedArtefactPaymentSettings;

use ChrisJohnLeah\SageAccounting\Data\HostedArtefactPaymentSetting;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a Hosted Artefact Payment Setting
 *
 * POST /hosted_artefact_payment_settings
 */
class PostHostedArtefactPaymentSettings extends Request implements HasBody
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
        return '/hosted_artefact_payment_settings';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?HostedArtefactPaymentSetting
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return HostedArtefactPaymentSetting::fromArray($data);
    }
}
