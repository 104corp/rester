<?php

namespace Tests\Fixture;

use Corp104\Rester\Plugins\AsynchronousTrait;

/**
 * Async client
 */
class TestResterClientAsync extends TestResterClient
{
    use AsynchronousTrait;
}
