<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting;

use ChrisJohnLeah\SageAccounting\Pagination\SagePaginator;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\PendingRequest;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\Paginator;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;

/**
 * Saloon connector for the Sage Business Cloud Accounting API (v3.1).
 *
 * Handles OAuth2 (authorization-code grant with rotating refresh tokens),
 * the mandatory X-Business header, body-based $next pagination, Sage's rate
 * limits, and exponential backoff on 429/5xx.
 */
class SageConnector extends Connector implements HasPagination
{
    use AuthorizationCodeGrant;
    use HasRateLimits;

    public ?int $tries = 4;

    public ?int $retryInterval = 1000;

    public ?bool $useExponentialBackoff = true;

    public ?bool $throwOnMaxTries = true;

    /**
     * Custom store for rate-limit counters. Named to avoid colliding with the
     * HasRateLimits trait's own internal $rateLimitStore property.
     */
    private ?RateLimitStore $rateLimitStoreOverride;

    /**
     * @param  list<string>  $scopes
     */
    public function __construct(
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly string $redirectUri,
        private readonly array $scopes = [],
        private ?string $businessId = null,
        private readonly string $baseUrl = 'https://api.accounting.sage.com/v3.1',
        private readonly string $authorizeEndpoint = 'https://www.sageone.com/oauth2/auth/central',
        private readonly string $tokenEndpoint = 'https://oauth.accounting.sage.com/token',
        ?RateLimitStore $rateLimitStore = null,
    ) {
        $this->rateLimitStoreOverride = $rateLimitStore;
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        return ['Accept' => 'application/json'];
    }

    public function boot(PendingRequest $pendingRequest): void
    {
        if ($this->businessId !== null) {
            $pendingRequest->headers()->add('X-Business', $this->businessId);
        }
    }

    public function setBusinessId(?string $businessId): static
    {
        $this->businessId = $businessId;

        return $this;
    }

    public function getBusinessId(): ?string
    {
        return $this->businessId;
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId($this->clientId)
            ->setClientSecret($this->clientSecret)
            ->setRedirectUri($this->redirectUri)
            ->setDefaultScopes($this->scopes)
            ->setAuthorizeEndpoint($this->authorizeEndpoint)
            ->setTokenEndpoint($this->tokenEndpoint)
            // Saloon v4 blocks absolute endpoints (SSRF guard); the OAuth token
            // endpoint is absolute, so opt in or refresh/exchange fails.
            ->setAllowBaseUrlOverride(true);
    }

    public function paginate(Request $request): Paginator
    {
        return new SagePaginator($this, $request);
    }

    /**
     * @return array<int, Limit>
     */
    protected function resolveLimits(): array
    {
        return [
            Limit::allow(100)->everyMinute(),
            Limit::allow(2500)->everyDay(),
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return $this->rateLimitStoreOverride ??= new MemoryStore();
    }

    public function handleRetry(FatalRequestException|RequestException $exception, Request $request): bool
    {
        if ($exception instanceof FatalRequestException) {
            return true;
        }

        return in_array($exception->getResponse()->status(), [429], true)
            || $exception->getResponse()->status() >= 500;
    }
}
