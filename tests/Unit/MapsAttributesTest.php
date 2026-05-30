<?php

declare(strict_types=1);

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

/**
 * Exposes the protected extractors so the coercion rules can be asserted
 * directly, independent of any particular DTO.
 */
function attributeMapper(): object
{
    return new class () {
        use MapsAttributes;

        public function mapFloat(array $data, string $key): ?float
        {
            return self::float($data, $key);
        }

        public function mapInteger(array $data, string $key): ?int
        {
            return self::integer($data, $key);
        }
    };
}

it('coerces Sage numeric-string money fields into floats', function () {
    $mapper = attributeMapper();

    // Strings are how Sage actually sends amounts on the wire.
    expect($mapper->mapFloat(['amount' => '367.09'], 'amount'))->toBe(367.09)
        ->and($mapper->mapFloat(['amount' => '0'], 'amount'))->toBe(0.0)
        ->and($mapper->mapFloat(['amount' => '-12.5'], 'amount'))->toBe(-12.5)
        // Native numerics still work.
        ->and($mapper->mapFloat(['amount' => 234.91], 'amount'))->toBe(234.91)
        ->and($mapper->mapFloat(['amount' => 5], 'amount'))->toBe(5.0)
        // Non-numeric / missing stays null rather than coercing to 0.0.
        ->and($mapper->mapFloat(['amount' => 'not-a-number'], 'amount'))->toBeNull()
        ->and($mapper->mapFloat(['amount' => null], 'amount'))->toBeNull()
        ->and($mapper->mapFloat([], 'amount'))->toBeNull();
});

it('coerces whole-number strings into integers but rejects fractions', function () {
    $mapper = attributeMapper();

    expect($mapper->mapInteger(['n' => '42'], 'n'))->toBe(42)
        ->and($mapper->mapInteger(['n' => 42], 'n'))->toBe(42)
        // A fractional value is not a clean integer, so it stays null.
        ->and($mapper->mapInteger(['n' => '42.5'], 'n'))->toBeNull()
        ->and($mapper->mapInteger(['n' => 'nope'], 'n'))->toBeNull()
        ->and($mapper->mapInteger([], 'n'))->toBeNull();
});
