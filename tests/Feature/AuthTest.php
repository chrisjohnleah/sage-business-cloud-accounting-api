<?php

declare(strict_types=1);

use ChrisJohnLeah\SageAccounting\Auth\ArrayTokenStore;
use ChrisJohnLeah\SageAccounting\Auth\StoredToken;
use ChrisJohnLeah\SageAccounting\Exceptions\NotConnectedException;
use ChrisJohnLeah\SageAccounting\Sage;
use ChrisJohnLeah\SageAccounting\SageConnector;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

function tokenConnector(MockClient $mock): SageConnector
{
    $connector = new SageConnector('client-id', 'client-secret', 'https://app.test/cb', ['full_access']);
    $connector->withMockClient($mock);

    return $connector;
}

it('throws when no token has been stored', function () {
    $sage = new Sage(new SageConnector('id', 'secret', 'https://app.test/cb'), new ArrayTokenStore());

    $sage->connector();
})->throws(NotConnectedException::class);

it('refreshes and persists Sage\'s rotated refresh token', function () {
    $store = new ArrayTokenStore(new StoredToken(
        accessToken: 'old-access',
        refreshToken: 'old-refresh',
        expiresAt: new DateTimeImmutable('-1 minute'),
        businessId: 'biz-guid-1',
    ));

    $mock = new MockClient([
        '*oauth.accounting.sage.com/token*' => MockResponse::make([
            'access_token' => 'new-access',
            'refresh_token' => 'rotated-refresh',
            'expires_in' => 300,
            'token_type' => 'bearer',
        ]),
    ]);

    $sage = new Sage(tokenConnector($mock), $store);

    $rotated = $sage->refresh($store->get());

    // The returned token carries the rotated values and preserves the business.
    expect($rotated->accessToken)->toBe('new-access')
        ->and($rotated->refreshToken)->toBe('rotated-refresh')
        ->and($rotated->businessId)->toBe('biz-guid-1');

    // CRITICAL: the store was overwritten with the rotated refresh token, so the
    // next refresh won't reuse the now-invalid old one.
    expect($store->get()->accessToken)->toBe('new-access')
        ->and($store->get()->refreshToken)->toBe('rotated-refresh');
});

it('auto-refreshes an access token that is about to expire', function () {
    $store = new ArrayTokenStore(new StoredToken(
        accessToken: 'soon-stale',
        refreshToken: 'live-refresh',
        expiresAt: new DateTimeImmutable('+10 seconds'),
        businessId: 'biz-guid-1',
    ));

    $mock = new MockClient([
        '*oauth.accounting.sage.com/token*' => MockResponse::make([
            'access_token' => 'fresh-access',
            'refresh_token' => 'fresh-refresh',
            'expires_in' => 300,
        ]),
    ]);

    // 10s of validity is inside the 60s refresh buffer, so connector() refreshes.
    $sage = new Sage(tokenConnector($mock), $store, refreshBufferSeconds: 60);

    $sage->connector();

    expect($store->get()->accessToken)->toBe('fresh-access')
        ->and($store->get()->refreshToken)->toBe('fresh-refresh')
        ->and($store->get()->businessId)->toBe('biz-guid-1');
});

it('does not refresh a token with plenty of life left', function () {
    $store = new ArrayTokenStore(new StoredToken(
        accessToken: 'still-good',
        refreshToken: 'live-refresh',
        expiresAt: new DateTimeImmutable('+10 minutes'),
        businessId: 'biz-guid-1',
    ));

    // No token-endpoint mock: if it tried to refresh, preventStrayRequests would throw.
    $sage = new Sage(tokenConnector(new MockClient([])), $store, refreshBufferSeconds: 60);

    $connector = $sage->connector();

    expect($connector->getBusinessId())->toBe('biz-guid-1')
        ->and($store->get()->accessToken)->toBe('still-good');
});
