<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Auth;

use ChrisJohnLeah\SageAccounting\Contracts\TokenStore;

/**
 * In-memory token store. Useful for tests and single-process scripts.
 * For persistence across requests, use the Laravel bridge's Eloquent store.
 */
final class ArrayTokenStore implements TokenStore
{
    public function __construct(private ?StoredToken $token = null)
    {
    }

    public function get(): ?StoredToken
    {
        return $this->token;
    }

    public function put(StoredToken $token): void
    {
        $this->token = $token;
    }

    public function forget(): void
    {
        $this->token = null;
    }
}
