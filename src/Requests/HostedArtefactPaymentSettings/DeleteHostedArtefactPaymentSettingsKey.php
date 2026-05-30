<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\HostedArtefactPaymentSettings;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Hosted Artefact Payment Setting
 *
 * DELETE /hosted_artefact_payment_settings/{key}
 */
class DeleteHostedArtefactPaymentSettingsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/hosted_artefact_payment_settings/{key}');
    }
}
