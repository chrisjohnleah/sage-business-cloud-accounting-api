<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Requests\BankOpeningBalances;

use ChrisJohnLeah\SageAccounting\Data\BankOpeningBalance;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Returns a Bank Opening Balance
 *
 * GET /bank_opening_balances/{key}
 */
class GetBankOpeningBalancesKey extends Request
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
        return str_replace('{key}', rawurlencode($this->key), '/bank_opening_balances/{key}');
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return array_filter($this->filters, static fn (mixed $v): bool => $v !== null);
    }

    public function createDtoFromResponse(Response $response): ?BankOpeningBalance
    {
        $data = $response->json();

        if (! is_array($data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        return BankOpeningBalance::fromArray($data);
    }
}
