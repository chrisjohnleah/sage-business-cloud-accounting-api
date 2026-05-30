<?php

declare(strict_types=1);

use ChrisJohnLeah\SageAccounting\Tests\TestCase;
use Saloon\Config;

/*
 * Bind the base test case and guarantee no test ever performs a real HTTP call
 * to Sage — any unmocked request throws instead of hitting the network.
 */
uses(TestCase::class)
    ->beforeEach(fn () => Config::preventStrayRequests())
    ->in('Feature', 'Unit');
