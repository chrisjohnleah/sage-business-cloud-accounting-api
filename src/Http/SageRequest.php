<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Http;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * Base class for Sage collection requests.
 *
 * Sage paginates by returning a full absolute "$next" URL in the response body.
 * The paginator injects that URL into {@see $paginationUrl}; resolveEndpoint()
 * then returns it verbatim. Saloon v4 only honours an absolute endpoint when
 * {@see $allowBaseUrlOverride} is true, so we opt in here.
 */
abstract class SageRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public ?bool $allowBaseUrlOverride = true;

    public ?string $paginationUrl = null;

    public function resolveEndpoint(): string
    {
        return $this->paginationUrl ?? $this->endpoint();
    }

    abstract protected function endpoint(): string;
}
