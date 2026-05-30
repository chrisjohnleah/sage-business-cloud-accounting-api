# Sage Business Cloud Accounting API — PHP SDK

[![CI](https://github.com/chrisjohnleah/sage-business-cloud-accounting-api/actions/workflows/ci.yml/badge.svg)](https://github.com/chrisjohnleah/sage-business-cloud-accounting-api/actions/workflows/ci.yml)
[![PHP Version](https://img.shields.io/badge/php-%E2%89%A58.3-777bb4.svg)](https://php.net)
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

<!-- Once published, add: [![Packagist](https://img.shields.io/packagist/v/chrisjohnleah/sage-business-cloud-accounting-api.svg)](https://packagist.org/packages/chrisjohnleah/sage-business-cloud-accounting-api) -->

A modern, framework-agnostic PHP SDK for the [Sage Business Cloud Accounting API (v3.1)](https://developer.sage.com/accounting/), built on [Saloon](https://docs.saloon.dev). Typed responses, OAuth2 with rotating-refresh handling, `X-Business` targeting, automatic `$next` pagination, and rate-limit / 429 backoff — all baked in.

> **Using Laravel?** Reach for the companion bridge
> [`chrisjohnleah/sage-business-cloud-accounting-api-laravel`](https://github.com/chrisjohnleah/sage-business-cloud-accounting-api-laravel)
> for a service provider, an Eloquent token store, and `sage:connect` / `sage:sync` commands.

## Why this package

The Sage Accounting API has sharp edges that this SDK smooths over for you:

| Sage quirk | What the SDK does |
|---|---|
| **5-minute access tokens** | Refreshes proactively before expiry |
| **Rotating refresh tokens** (single-use) | Surfaces the rotated token so you can persist it |
| **Mandatory `X-Business` header** | Applied automatically once a business is selected |
| **No webhooks** | First-class incremental polling via `updated_or_created_since` / `deleted_since` |
| **Body-based `$next` pagination** | Iterated transparently — `foreach` over every record |
| **Rate limits** (100/min per company) | Honours `429 Retry-After` and backs off exponentially |

## Requirements

- PHP 8.3+
- A Sage Developer app (OAuth2 client id + secret) — register at [developerselfservice.sageone.com](https://developerselfservice.sageone.com)

## Installation

```bash
composer require chrisjohnleah/sage-business-cloud-accounting-api
```

## Quick start

```php
use ChrisJohnLeah\SageAccounting\Auth\ArrayTokenStore;
use ChrisJohnLeah\SageAccounting\Sage;
use ChrisJohnLeah\SageAccounting\SageConnector;

$connector = new SageConnector(
    clientId: getenv('SAGE_CLIENT_ID'),
    clientSecret: getenv('SAGE_CLIENT_SECRET'),
    redirectUri: 'https://your-app.test/oauth/sage/callback',
    scopes: ['readonly'], // or ['full_access']
);

// Bring your own persistence (DB, cache…) by implementing TokenStore.
// ArrayTokenStore keeps tokens in memory — handy for scripts and tests.
$sage = new Sage($connector, new ArrayTokenStore);
```

### 1. Send the user to Sage to authorise

```php
$url   = $sage->authorizationUrl();   // redirect the user here
$state = $sage->generatedState();     // persist this (session/cache) for the callback
```

### 2. Handle the callback

```php
$sage->exchangeCode($_GET['code'], $_GET['state'], $expectedState: $state);
$sage->resolveBusiness();             // selects + remembers the business to target
```

### 3. Read data (auto-refreshes, auto-paginates)

```php
// Every supplier bill updated since a timestamp — typed, across all pages.
$bills = $sage->purchaseInvoices()->list([
    'updated_or_created_since' => '2026-05-01T00:00:00Z',
]);

foreach ($bills as $invoice) {
    printf(
        "%s owes %.2f, due %s [%s]\n",
        $invoice->contactName,
        $invoice->outstandingAmount ?? 0.0,
        $invoice->dueDate?->format('Y-m-d') ?? 'n/a',
        $invoice->status?->displayedAs ?? 'unknown',
    );
}

// Suppliers
foreach ($sage->contacts()->list(['contact_type_id' => 'VENDOR']) as $contact) {
    echo $contact->name, ' <', $contact->email, ">\n";
}
```

## Persisting tokens

Implement [`Contracts\TokenStore`](src/Contracts/TokenStore.php) to store tokens wherever you like (the Laravel bridge ships an Eloquent one). Sage **rotates the refresh token on every refresh**, so your `put()` must always overwrite the previous record:

```php
use ChrisJohnLeah\SageAccounting\Auth\StoredToken;
use ChrisJohnLeah\SageAccounting\Contracts\TokenStore;

final class MyTokenStore implements TokenStore
{
    public function get(): ?StoredToken { /* load access/refresh/expiresAt/businessId */ }
    public function put(StoredToken $token): void { /* overwrite */ }
    public function forget(): void { /* delete */ }
}
```

## Coverage

**The entire Sage Accounting v3.1 API.** Every schema (200+) has a typed DTO and every operation (280+, including writes) has a request class — generated from the OpenAPI spec and verified by contract tests, so coverage can't silently regress.

Ergonomic, lazily-paginated resources are provided for the common entities (`businesses()`, `contacts()`, `purchaseInvoices()`); every other endpoint is reachable by sending its generated request through `$sage->connector()`:

```php
use ChrisJohnLeah\SageAccounting\Requests\LedgerAccounts\GetLedgerAccounts;
use ChrisJohnLeah\SageAccounting\Requests\Contacts\PostContacts;

$ledgers = $sage->connector()->send(new GetLedgerAccounts(['attributes' => 'all']))->dto();
$created = $sage->connector()->send(new PostContacts(['contact' => [/* ... */]]))->dto();
```

### Regenerating from the spec

```bash
php tools/generate.php   # re-reads resources/openapi/sage-accounting-3.1.0.json
```

The hand-crafted core (connector, OAuth, paginator, client, `Reference`/`Paginated`) is never touched — only the leaf DTOs and request classes are generated.

## Testing

```bash
composer test      # Pest
composer analyse   # PHPStan (max)
composer lint      # Pint --test
composer check     # all three
```

Tests never hit the network — every request is faked with Saloon's `MockClient`.

## Contributing

Issues and PRs welcome — see [CONTRIBUTING.md](CONTRIBUTING.md). Please report security issues privately per [SECURITY.md](SECURITY.md).

## Licence

MIT © [Chris John Leah](https://github.com/chrisjohnleah). See [LICENSE](LICENSE).

> Not affiliated with or endorsed by The Sage Group plc. "Sage" is a trademark of its respective owner.
