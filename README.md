# Sage Business Cloud Accounting API — PHP SDK

A modern, framework-agnostic PHP SDK for the [Sage Business Cloud Accounting API (v3.1)](https://developer.sage.com/accounting/), built on [Saloon](https://docs.saloon.dev). Typed responses, OAuth2 with rotating-refresh handling, `X-Business` targeting, automatic `$next` pagination, and rate-limit/429 backoff baked in.

> For Laravel apps, see the companion bridge package
> [`chrisjohnleah/sage-business-cloud-accounting-api-laravel`](https://github.com/chrisjohnleah/sage-business-cloud-accounting-api-laravel)
> (service provider, Eloquent token store, and artisan commands).

## Why this package

The Sage Accounting API has some sharp edges that this SDK handles for you:

- **5-minute access tokens + rotating refresh tokens** — refresh tokens are single-use; the SDK surfaces the rotated token so you can persist it.
- **Mandatory `X-Business` header** — every request must target a specific business.
- **No webhooks** — incremental polling via `updated_or_created_since` / `deleted_since` is the supported sync model.
- **Body-based `$next` pagination** — the SDK iterates pages transparently.
- **Rate limits** — 100 req/min per company; the SDK honours `429 Retry-After` and backs off.

## Requirements

- PHP 8.3+
- A Sage Developer app (OAuth2 client id + secret) — register at [developerselfservice.sageone.com](https://developerselfservice.sageone.com)

## Installation

```bash
composer require chrisjohnleah/sage-business-cloud-accounting-api
```

## Status

🚧 Early development. v0.1 targets read access to **businesses**, **contacts**, and **purchase invoices**; broader endpoint coverage follows.

## Licence

MIT © Chris John Leah
