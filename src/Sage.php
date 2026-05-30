<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting;

use ChrisJohnLeah\SageAccounting\Auth\StoredToken;
use ChrisJohnLeah\SageAccounting\Contracts\TokenStore;
use ChrisJohnLeah\SageAccounting\Data\Business;
use ChrisJohnLeah\SageAccounting\Data\Paginated;
use ChrisJohnLeah\SageAccounting\Exceptions\NotConnectedException;
use ChrisJohnLeah\SageAccounting\Requests\Businesses\GetBusinesses;
use ChrisJohnLeah\SageAccounting\Resources\BusinessesResource;
use ChrisJohnLeah\SageAccounting\Resources\ContactsResource;
use ChrisJohnLeah\SageAccounting\Resources\PurchaseInvoicesResource;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Http\Auth\AccessTokenAuthenticator;

/**
 * High-level entry point: ties a {@see SageConnector} to a {@see TokenStore},
 * owns the OAuth handshake, keeps the access token fresh (persisting Sage's
 * rotated refresh token on every refresh), and exposes typed resources.
 */
final class Sage
{
    public function __construct(
        private readonly SageConnector $connector,
        private readonly TokenStore $tokenStore,
        private readonly int $refreshBufferSeconds = 60,
    ) {
    }

    /**
     * The URL to send the user to in order to grant access. Sage requires the
     * `filter` and `country` query parameters in addition to the OAuth params.
     */
    public function authorizationUrl(?string $state = null, string $country = 'gb'): string
    {
        return $this->connector->getAuthorizationUrl(
            state: $state,
            additionalQueryParameters: ['filter' => 'apiv3.1', 'country' => $country],
        );
    }

    /**
     * The state Saloon generated for the last authorization URL (store it and
     * pass it back to {@see exchangeCode()} as the expected state for CSRF safety).
     */
    public function generatedState(): ?string
    {
        return $this->connector->getState();
    }

    /**
     * Exchange the authorization code from the OAuth callback for tokens and
     * persist them.
     */
    public function exchangeCode(string $code, ?string $state = null, ?string $expectedState = null): StoredToken
    {
        $authenticator = $this->connector->getAccessToken($code, $state, $expectedState);

        if (! $authenticator instanceof OAuthAuthenticator) {
            throw new NotConnectedException('Unexpected response while exchanging the authorization code.');
        }

        $token = new StoredToken(
            $authenticator->getAccessToken(),
            $authenticator->getRefreshToken(),
            $authenticator->getExpiresAt(),
        );

        $this->tokenStore->put($token);

        return $token;
    }

    /**
     * An authenticated connector with a guaranteed-fresh access token and the
     * resolved business id applied to the `X-Business` header.
     */
    public function connector(): SageConnector
    {
        $token = $this->tokenStore->get();

        if ($token === null) {
            throw new NotConnectedException('No Sage token stored — complete the OAuth flow first.');
        }

        if ($token->refreshToken !== null && $token->expiresWithin($this->refreshBufferSeconds)) {
            $token = $this->refresh($token);
        }

        $this->connector->setBusinessId($token->businessId);
        $this->connector->authenticate(new AccessTokenAuthenticator(
            $token->accessToken,
            $token->refreshToken,
            $token->expiresAt,
        ));

        return $this->connector;
    }

    /**
     * Refresh the access token and immediately persist the result. Sage rotates
     * (invalidates) the refresh token on every use, so the *new* refresh token
     * from the response must overwrite the old one or the next refresh will fail.
     */
    public function refresh(StoredToken $token): StoredToken
    {
        if ($token->refreshToken === null) {
            throw new NotConnectedException('No refresh token available — re-authorise with Sage.');
        }

        $authenticator = $this->connector->refreshAccessToken($token->refreshToken);

        if (! $authenticator instanceof OAuthAuthenticator) {
            throw new NotConnectedException('Unexpected response while refreshing the access token.');
        }

        $rotated = new StoredToken(
            $authenticator->getAccessToken(),
            $authenticator->getRefreshToken(),
            $authenticator->getExpiresAt(),
            $token->businessId,
        );

        $this->tokenStore->put($rotated);

        return $rotated;
    }

    /**
     * Fetch the accessible businesses, select the first, and persist its id as
     * the business targeted by subsequent calls. Returns null if none exist.
     */
    public function resolveBusiness(): ?Business
    {
        $page = $this->connector()->send(new GetBusinesses())->dtoOrFail();

        if (! $page instanceof Paginated || $page->items === []) {
            return null;
        }

        $business = Business::fromArray($page->items[0]);

        if ($business->id !== null) {
            $token = $this->tokenStore->get();

            if ($token !== null) {
                $this->tokenStore->put($token->withBusinessId($business->id));
            }

            $this->connector->setBusinessId($business->id);
        }

        return $business;
    }

    public function businesses(): BusinessesResource
    {
        return new BusinessesResource($this);
    }

    public function contacts(): ContactsResource
    {
        return new ContactsResource($this);
    }

    public function purchaseInvoices(): PurchaseInvoicesResource
    {
        return new PurchaseInvoicesResource($this);
    }
}
