<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\Attachments;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Deletes a Attachment
 *
 * DELETE /attachments/{key}
 */
class DeleteAttachmentsKey extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $key,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return str_replace('{key}', rawurlencode($this->key), '/attachments/{key}');
    }
}
