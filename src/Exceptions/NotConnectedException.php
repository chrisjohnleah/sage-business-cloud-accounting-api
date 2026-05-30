<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Exceptions;

use RuntimeException;

/**
 * Thrown when an API call is attempted without a usable stored token — i.e. the
 * OAuth flow has not been completed, or the refresh token has expired (Sage
 * refresh tokens die after 31 days of inactivity) and re-authorisation is needed.
 */
final class NotConnectedException extends RuntimeException
{
}
