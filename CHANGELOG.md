# Changelog

All notable changes to this project are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial v0.1 read SDK built on Saloon v4.
- `SageConnector`: OAuth2 authorization-code grant with rotating-refresh handling, mandatory `X-Business` header, body-based `$next` pagination, Sage rate limits (100/min, 2500/day) and exponential backoff on 429/5xx.
- `Sage` high-level client: OAuth handshake helpers, guaranteed-fresh access token, and persistence of Sage's rotated refresh token on every refresh.
- `TokenStore` contract with an in-memory `ArrayTokenStore`.
- Typed DTOs: `Business`, `Contact`, `Address`, `PurchaseInvoice`, `PurchaseInvoiceLineItem`, `Transaction`, `Reference`, `Link`, and the `Paginated` envelope.
- Resources: `businesses()`, `contacts()`, `purchaseInvoices()` with lazy pagination.

[Unreleased]: https://github.com/chrisjohnleah/sage-business-cloud-accounting-api/commits/main
