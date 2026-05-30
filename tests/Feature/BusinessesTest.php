<?php

declare(strict_types=1);

use ChrisJohnLeah\SageAccounting\Data\Business;
use ChrisJohnLeah\SageAccounting\Data\Paginated;
use ChrisJohnLeah\SageAccounting\Requests\GetBusinessesRequest;
use ChrisJohnLeah\SageAccounting\SageConnector;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;
use Saloon\Http\Request;

function sageConnector(MockClient $mock): SageConnector
{
    $connector = new SageConnector(
        clientId: 'client-id',
        clientSecret: 'client-secret',
        redirectUri: 'https://app.test/oauth/sage/callback',
        scopes: ['full_access'],
        businessId: 'biz-guid-1',
    );

    $connector->withMockClient($mock);

    return $connector;
}

it('hydrates a Business DTO from the collection envelope', function () {
    $mock = new MockClient([
        GetBusinessesRequest::class => MockResponse::make([
            '$total' => 1,
            '$page' => 1,
            '$next' => null,
            '$items_per_page' => 200,
            '$items' => [[
                'id' => 'biz-guid-1',
                'displayed_as' => 'UK Workbenches',
                'name' => 'UK Workbenches Ltd',
                'city' => 'Redditch',
                'is_demo' => false,
            ]],
        ]),
    ]);

    $page = sageConnector($mock)->send(new GetBusinessesRequest())->dto();

    expect($page)->toBeInstanceOf(Paginated::class)
        ->and($page->total)->toBe(1)
        ->and($page->itemsPerPage)->toBe(200)
        ->and($page->items)->toHaveCount(1);

    $business = Business::fromArray($page->items[0]);

    expect($business->id)->toBe('biz-guid-1')
        ->and($business->name)->toBe('UK Workbenches Ltd')
        ->and($business->city)->toBe('Redditch')
        ->and($business->isDemo)->toBeFalse();
});

it('sends the X-Business header on every request', function () {
    $mock = new MockClient([
        GetBusinessesRequest::class => MockResponse::make(['$items' => []]),
    ]);

    $connector = sageConnector($mock);

    // The header is applied in the connector's boot() hook, so it lands on the
    // PendingRequest (not the original Request that assertSent would inspect).
    $header = null;
    $connector->middleware()->onRequest(function (PendingRequest $pending) use (&$header) {
        $header = $pending->headers()->get('X-Business');
    });

    $connector->send(new GetBusinessesRequest());

    expect($header)->toBe('biz-guid-1');
});

it('walks every page via the $next URL in the response body', function () {
    $mock = new MockClient([
        // A bare sequence is returned in order regardless of request class.
        MockResponse::make([
            '$next' => 'https://api.accounting.sage.com/v3.1/businesses?page=2',
            '$items' => [['id' => 'a'], ['id' => 'b']],
        ]),
        MockResponse::make([
            '$next' => null,
            '$items' => [['id' => 'c']],
        ]),
    ]);

    $connector = sageConnector($mock);

    $ids = [];

    foreach ($connector->paginate(new GetBusinessesRequest())->items() as $item) {
        $ids[] = $item['id'];
    }

    expect($ids)->toBe(['a', 'b', 'c']);
    $mock->assertSentCount(2);
});

it('points the second page request at the absolute $next URL', function () {
    $nextUrl = 'https://api.accounting.sage.com/v3.1/businesses?page=2&per_page=200';

    $mock = new MockClient([
        MockResponse::make(['$next' => $nextUrl, '$items' => [['id' => 'a']]]),
        MockResponse::make(['$next' => null, '$items' => [['id' => 'b']]]),
    ]);

    $connector = sageConnector($mock);

    $urls = [];
    $connector->middleware()->onRequest(function (PendingRequest $pending) use (&$urls) {
        $urls[] = $pending->getUrl();
    });

    iterator_to_array($connector->paginate(new GetBusinessesRequest())->items(), false);

    expect($urls)->toHaveCount(2)
        ->and($urls[0])->toBe('https://api.accounting.sage.com/v3.1/businesses')
        ->and($urls[1])->toBe($nextUrl);
});
