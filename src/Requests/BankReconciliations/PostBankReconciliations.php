<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\BankReconciliations;

use ChrisJohnLeah\SageAccounting\Data\BankReconciliation;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a Bank Reconciliation
 *
 * POST /bank_reconciliations
 */
class PostBankReconciliations extends Request implements HasBody
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
        return '/bank_reconciliations';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ?BankReconciliation
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return BankReconciliation::fromArray($data);
    }
}
