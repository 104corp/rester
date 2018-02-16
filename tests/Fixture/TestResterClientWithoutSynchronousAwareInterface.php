<?php

namespace Tests\Fixture;

use Corp104\Rester\Support\SynchronousAwareInterface;
use Corp104\Rester\Support\SynchronousNullTrait;

/**
 * Client without SynchronousAwareInterface
 */
class TestResterClientWithoutSynchronousAwareInterface extends TestResterClient
{
    public function setSynchronous($synchronous)
    {
        // Do nothing
    }

    public function getSynchronous()
    {
        // Do nothing
    }
}
