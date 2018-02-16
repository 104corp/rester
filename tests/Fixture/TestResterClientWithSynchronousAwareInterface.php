<?php

namespace Tests\Fixture;

use Corp104\Rester\Support\SynchronousAwareInterface;
use Corp104\Rester\Support\SynchronousNullTrait;

/**
 * Client with SynchronousAwareInterface
 */
class TestResterClientWithSynchronousAwareInterface extends TestResterClient implements SynchronousAwareInterface
{
    use SynchronousNullTrait;
}
