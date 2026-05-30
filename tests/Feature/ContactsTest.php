<?php

declare(strict_types=1);

use ChrisJohnLeah\SageAccounting\Data\Address;
use ChrisJohnLeah\SageAccounting\Data\Contact;
use ChrisJohnLeah\SageAccounting\Data\Paginated;
use ChrisJohnLeah\SageAccounting\Data\Reference;
use ChrisJohnLeah\SageAccounting\Requests\Contacts\GetContacts;
use ChrisJohnLeah\SageAccounting\SageConnector;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('hydrates a Contact DTO including its main address and contact types', function () {
    $mock = new MockClient([
        GetContacts::class => MockResponse::make([
            '$total' => 1,
            '$page' => 1,
            '$next' => null,
            '$items_per_page' => 200,
            '$items' => [[
                'id' => 'contact-guid-1',
                'displayed_as' => 'Acme Steel Ltd',
                '$path' => '/contacts/contact-guid-1',
                'name' => 'Acme Steel Ltd',
                'reference' => 'ACME01',
                'email' => 'accounts@acme.test',
                'balance' => 1234.56,
                'credit_limit' => 5000.0,
                'credit_days' => 30,
                'is_active' => true,
                'gdpr_obfuscated' => false,
                'contact_types' => [
                    ['id' => 'VENDOR', 'displayed_as' => 'Supplier', '$path' => '/contact_types/VENDOR'],
                ],
                'currency' => ['id' => 'GBP', 'displayed_as' => 'Pound Sterling'],
                'main_address' => [
                    'id' => 'address-guid-1',
                    'displayed_as' => 'Unit 4, Redditch',
                    'address_line_1' => 'Unit 4',
                    'city' => 'Redditch',
                    'postal_code' => 'B98 1AB',
                    'country' => ['id' => 'GB', 'displayed_as' => 'United Kingdom'],
                    'is_main_address' => true,
                ],
            ]],
        ]),
    ]);

    $connector = new SageConnector(
        clientId: 'id',
        clientSecret: 'secret',
        redirectUri: 'https://app.test/cb',
        scopes: ['full_access'],
        businessId: 'biz-guid-1',
    );
    $connector->withMockClient($mock);

    $page = $connector->send(new GetContacts())->dto();

    expect($page)->toBeInstanceOf(Paginated::class)
        ->and($page->items)->toHaveCount(1);

    $contact = Contact::fromArray($page->items[0]);

    expect($contact)->toBeInstanceOf(Contact::class)
        ->and($contact->id)->toBe('contact-guid-1')
        ->and($contact->reference)->toBe('ACME01')
        ->and($contact->email)->toBe('accounts@acme.test')
        ->and($contact->isActive)->toBeTrue()
        ->and($contact->balance)->toBe(1234.56)
        ->and($contact->creditDays)->toBe(30);

    expect($contact->contactTypes)->toHaveCount(1)
        ->and($contact->contactTypes[0])->toBeInstanceOf(Reference::class)
        ->and($contact->contactTypes[0]->id)->toBe('VENDOR');

    expect($contact->mainAddress)->toBeInstanceOf(Address::class)
        ->and($contact->mainAddress->city)->toBe('Redditch')
        ->and($contact->mainAddress->postalCode)->toBe('B98 1AB')
        ->and($contact->mainAddress->country)->toBeInstanceOf(Reference::class)
        ->and($contact->mainAddress->country->id)->toBe('GB')
        ->and($contact->mainAddress->isMainAddress)->toBeTrue();
});

it('requests attributes=all on the contacts endpoint', function () {
    $mock = new MockClient([
        GetContacts::class => MockResponse::make(['$items' => []]),
    ]);

    $connector = new SageConnector(
        clientId: 'id',
        clientSecret: 'secret',
        redirectUri: 'https://app.test/cb',
        scopes: ['full_access'],
        businessId: 'biz-guid-1',
    );
    $connector->withMockClient($mock);

    $connector->send(new GetContacts(['attributes' => 'all']));

    $mock->assertSent(function ($request): bool {
        return $request->query()->get('attributes') === 'all';
    });
});

it('walks every contact page via the $next URL in the response body', function () {
    $mock = new MockClient([
        MockResponse::make([
            '$next' => 'https://api.accounting.sage.com/v3.1/contacts?page=2',
            '$items' => [['id' => 'a'], ['id' => 'b']],
        ]),
        MockResponse::make([
            '$next' => null,
            '$items' => [['id' => 'c']],
        ]),
    ]);

    $connector = new SageConnector(
        clientId: 'id',
        clientSecret: 'secret',
        redirectUri: 'https://app.test/cb',
        scopes: ['full_access'],
        businessId: 'biz-guid-1',
    );
    $connector->withMockClient($mock);

    $ids = [];

    foreach ($connector->paginate(new GetContacts())->items() as $item) {
        $ids[] = $item['id'];
    }

    expect($ids)->toBe(['a', 'b', 'c']);
    $mock->assertSentCount(2);
});
