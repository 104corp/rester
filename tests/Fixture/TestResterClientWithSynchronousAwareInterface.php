<?php

namespace Tests\Fixture;

use Corp104\Rester\SynchronousAwareInterface;
use Corp104\Rester\SynchronousNullTrait;

/**
 * Client with SynchronousAwareInterface
 */
class TestResterClientWithSynchronousAwareInterface extends TestResterClient implements SynchronousAwareInterface
{
    use SynchronousNullTrait;
}
