<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Auth;

use DateTimeImmutable;

/**
 * The persisted OAuth state for a single Sage connection.
 *
 * Saloon v4 removed serialize()/unserialize() from its authenticator, so we
 * persist the three primitive token fields (plus the resolved business GUID)
 * and rebuild the Saloon authenticator from them when needed.
 */
final readonly class StoredToken
{
    public function __construct(
        public string $accessToken,
        public ?string $refreshToken = null,
        public ?DateTimeImmutable $expiresAt = null,
        public ?string $businessId = null,
    ) {
    }

    public function hasExpired(?DateTimeImmutable $now = null): bool
    {
        if ($this->expiresAt === null) {
            return false;
        }

        return $this->expiresAt <= ($now ?? new DateTimeImmutable());
    }

    /**
     * True when the access token expires within the given number of seconds —
     * used to refresh proactively before the 5-minute Sage token lapses.
     */
    public function expiresWithin(int $seconds, ?DateTimeImmutable $now = null): bool
    {
        if ($this->expiresAt === null) {
            return false;
        }

        $now ??= new DateTimeImmutable();

        return $this->expiresAt <= $now->modify(sprintf('+%d seconds', $seconds));
    }

    public function withBusinessId(?string $businessId): self
    {
        return new self($this->accessToken, $this->refreshToken, $this->expiresAt, $businessId);
    }
}
