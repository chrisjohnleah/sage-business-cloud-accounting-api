<?php

declare(strict_types=1);

use ChrisJohnLeah\SageAccounting\Data\PurchaseQuickEntry;
use ChrisJohnLeah\SageAccounting\Data\Reference;
use ChrisJohnLeah\SageAccounting\Requests\PurchaseQuickEntries\GetPurchaseQuickEntries;
use ChrisJohnLeah\SageAccounting\SageConnector;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('hydrates a PurchaseQuickEntry with the cashflow fields the payables screen needs', function () {
    $mock = new MockClient([
        GetPurchaseQuickEntries::class => MockResponse::make([
            '$total' => 1,
            '$items' => [[
                'id' => 'pqe-1',
                'displayed_as' => 'A Grade Coating Ltd',
                'contact_name' => 'A Grade Coating Ltd',
                'due_date' => '2026-06-30',
                'total_amount' => 234.91,
                'outstanding_amount' => 234.91,
                'status' => ['id' => 'UNPAID', 'displayed_as' => 'Unpaid'],
                'contact' => ['id' => 'c-1', 'displayed_as' => 'A Grade Coating Ltd'],
            ]],
        ]),
    ]);

    $connector = new SageConnector('id', 'secret', 'https://app.test/cb', ['readonly'], 'biz-1');
    $connector->withMockClient($mock);

    $page = $connector->send(new GetPurchaseQuickEntries(['attributes' => 'all']))->dto();
    $entry = PurchaseQuickEntry::fromArray($page->items[0]);

    expect($entry)->toBeInstanceOf(PurchaseQuickEntry::class)
        ->and($entry->contactName)->toBe('A Grade Coating Ltd')
        ->and($entry->totalAmount)->toBe(234.91)
        ->and($entry->outstandingAmount)->toBe(234.91)
        ->and($entry->dueDate)->toBeInstanceOf(DateTimeImmutable::class)
        ->and($entry->dueDate?->format('Y-m-d'))->toBe('2026-06-30')
        ->and($entry->status)->toBeInstanceOf(Reference::class)
        ->and($entry->status?->displayedAs)->toBe('Unpaid');
});
