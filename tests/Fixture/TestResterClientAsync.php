<?php

namespace Tests\Fixture;

use Corp104\Rester\Api\Endpoint;
use Corp104\Rester\Api\Path;
use Corp104\Rester\Plugins\AsynchronousTrait;
use Corp104\Rester\ResterClient;
use Corp104\Rester\ResterRequest;
use GuzzleHttp\Psr7\Response;

/**
 * Async client
 */
class TestResterClientAsync extends TestResterClient
{
    use AsynchronousTrait;
}
