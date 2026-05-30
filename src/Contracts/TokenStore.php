<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Contracts;

use ChrisJohnLeah\SageAccounting\Auth\StoredToken;

/**
 * Persistence boundary for a Sage connection's OAuth token.
 *
 * The core ships an in-memory implementation; the Laravel bridge provides an
 * Eloquent-backed store. Sage rotates refresh tokens on every refresh, so
 * implementations MUST overwrite the previous token on every put().
 */
interface TokenStore
{
    public function get(): ?StoredToken;

    public function put(StoredToken $token): void;

    public function forget(): void;
}
