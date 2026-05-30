<?php

declare(strict_types=1);

use ChrisJohnLeah\SageAccounting\Data\LedgerAccount;
use ChrisJohnLeah\SageAccounting\Requests\Contacts\DeleteContactsKey;
use ChrisJohnLeah\SageAccounting\Requests\Contacts\GetContacts;
use ChrisJohnLeah\SageAccounting\Requests\Contacts\GetContactsKey;
use ChrisJohnLeah\SageAccounting\Requests\Contacts\PostContacts;
use ChrisJohnLeah\SageAccounting\Requests\Contacts\PutContactsKey;
use ChrisJohnLeah\SageAccounting\Requests\LedgerAccounts\GetLedgerAccounts;
use ChrisJohnLeah\SageAccounting\Requests\PurchaseInvoices\GetPurchaseInvoices;
use Saloon\Http\Request;

/*
 * Contract tests: prove the generated SDK covers the entire OpenAPI spec, so
 * coverage can never silently regress. Run `php tools/generate.php` after a
 * spec update and these assert nothing was missed.
 */

function sageSpec(): array
{
    /** @var array<string, mixed> $spec */
    $spec = json_decode(
        (string) file_get_contents(__DIR__.'/../../resources/openapi/sage-accounting-3.1.0.json'),
        true,
    );

    return $spec;
}

it('generates a typed DTO for every schema in the spec', function () {
    $skip = ['Base', 'Reference', 'Paginated'];
    $missing = [];

    foreach (array_keys(sageSpec()['components']['schemas']) as $name) {
        if (in_array($name, $skip, true)) {
            continue;
        }

        if (! class_exists("ChrisJohnLeah\\SageAccounting\\Data\\{$name}")) {
            $missing[] = $name;
        }
    }

    expect($missing)->toBe([], 'Schemas without a generated DTO: '.implode(', ', $missing));
});

it('generates a request class for every operation in the spec', function () {
    $operations = 0;

    foreach (sageSpec()['paths'] as $item) {
        foreach (array_keys($item) as $method) {
            if (in_array(strtolower((string) $method), ['get', 'post', 'put', 'delete'], true)) {
                $operations++;
            }
        }
    }

    $requestFiles = 0;

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../../src/Requests')) as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $requestFiles++;
        }
    }

    expect($requestFiles)->toBe($operations);
});

it('exposes generated requests as real Saloon requests', function () {
    $classes = [
        GetContacts::class,
        GetContactsKey::class,
        PostContacts::class,
        PutContactsKey::class,
        DeleteContactsKey::class,
        GetPurchaseInvoices::class,
        GetLedgerAccounts::class,
    ];

    foreach ($classes as $class) {
        expect(class_exists($class))->toBeTrue("Missing request: {$class}")
            ->and(is_subclass_of($class, Request::class))->toBeTrue("Not a Saloon request: {$class}");
    }
});

it('hydrates a generated DTO from a representative payload', function () {
    $ledger = LedgerAccount::fromArray([
        'id' => 'ledger-1',
        'displayed_as' => 'Sales',
        'nominal_code' => '4000',
    ]);

    expect($ledger->id)->toBe('ledger-1')
        ->and($ledger->displayedAs)->toBe('Sales');
});
