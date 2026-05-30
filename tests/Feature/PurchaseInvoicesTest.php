<?php

declare(strict_types=1);

use ChrisJohnLeah\SageAccounting\Data\Contact;
use ChrisJohnLeah\SageAccounting\Data\Paginated;
use ChrisJohnLeah\SageAccounting\Data\PurchaseInvoice;
use ChrisJohnLeah\SageAccounting\Data\PurchaseInvoiceLineItem;
use ChrisJohnLeah\SageAccounting\Data\Reference;
use ChrisJohnLeah\SageAccounting\Requests\PurchaseInvoices\GetPurchaseInvoices;
use ChrisJohnLeah\SageAccounting\SageConnector;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('hydrates a PurchaseInvoice with the cashflow fields the payables screen needs', function () {
    $mock = new MockClient([
        GetPurchaseInvoices::class => MockResponse::make([
            '$total' => 1,
            '$page' => 1,
            '$next' => null,
            '$items_per_page' => 200,
            '$items' => [[
                'id' => 'pinv-guid-1',
                'displayed_as' => 'INV-001',
                'contact_name' => 'Acme Steel Supplies',
                'contact_reference' => 'ACME',
                'due_date' => '2026-06-30',
                'total_amount' => 1200.50,
                'outstanding_amount' => 800.25,
                'status' => [
                    'id' => 'status-part-paid',
                    'displayed_as' => 'Part Paid',
                    '$path' => '/invoice_statuses/PART_PAID',
                ],
                'contact' => [
                    'id' => 'contact-guid-1',
                    'displayed_as' => 'Acme Steel Supplies',
                    'name' => 'Acme Steel Supplies Ltd',
                    'reference' => 'ACME',
                ],
                'invoice_lines' => [[
                    'id' => 'line-guid-1',
                    'description' => '6m steel RHS',
                    'quantity' => 10.0,
                    'unit_price' => 120.05,
                    'net_amount' => 1000.42,
                    'tax_amount' => 200.08,
                    'total_amount' => 1200.50,
                    'ledger_account' => [
                        'id' => 'ledger-5000',
                        'displayed_as' => 'Cost of Sales',
                    ],
                ]],
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

    $page = $connector->send(new GetPurchaseInvoices())->dto();

    expect($page)->toBeInstanceOf(Paginated::class)
        ->and($page->items)->toHaveCount(1);

    $invoice = PurchaseInvoice::fromArray($page->items[0]);

    expect($invoice)->toBeInstanceOf(PurchaseInvoice::class)
        ->and($invoice->contactName)->toBe('Acme Steel Supplies')
        ->and($invoice->totalAmount)->toBe(1200.50)
        ->and($invoice->outstandingAmount)->toBe(800.25)
        ->and($invoice->dueDate)->toBeInstanceOf(DateTimeImmutable::class)
        ->and($invoice->dueDate?->format('Y-m-d'))->toBe('2026-06-30')
        ->and($invoice->status)->toBeInstanceOf(Reference::class)
        ->and($invoice->status?->displayedAs)->toBe('Part Paid')
        ->and($invoice->contact)->toBeInstanceOf(Contact::class)
        ->and($invoice->contact?->name)->toBe('Acme Steel Supplies Ltd')
        ->and($invoice->invoiceLines)->toHaveCount(1)
        ->and($invoice->invoiceLines[0])->toBeInstanceOf(PurchaseInvoiceLineItem::class)
        ->and($invoice->invoiceLines[0]->description)->toBe('6m steel RHS')
        ->and($invoice->invoiceLines[0]->totalAmount)->toBe(1200.50);
});

it('requests the full attribute set via attributes=all', function () {
    $mock = new MockClient([
        GetPurchaseInvoices::class => MockResponse::make(['$items' => []]),
    ]);

    $connector = new SageConnector(
        clientId: 'id',
        clientSecret: 'secret',
        redirectUri: 'https://app.test/cb',
        scopes: ['full_access'],
        businessId: 'biz-guid-1',
    );
    $connector->withMockClient($mock);

    $query = null;
    $connector->middleware()->onRequest(function (PendingRequest $pending) use (&$query) {
        $query = $pending->query()->all();
    });

    $connector->send(new GetPurchaseInvoices(['attributes' => 'all']));

    expect($query)->toMatchArray(['attributes' => 'all']);
});

it('walks every purchase invoice across pages via the $next URL', function () {
    $mock = new MockClient([
        MockResponse::make([
            '$next' => 'https://api.accounting.sage.com/v3.1/purchase_invoices?page=2',
            '$items' => [['id' => 'pinv-a'], ['id' => 'pinv-b']],
        ]),
        MockResponse::make([
            '$next' => null,
            '$items' => [['id' => 'pinv-c']],
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

    foreach ($connector->paginate(new GetPurchaseInvoices())->items() as $item) {
        $ids[] = $item['id'];
    }

    expect($ids)->toBe(['pinv-a', 'pinv-b', 'pinv-c']);
    $mock->assertSentCount(2);
});
