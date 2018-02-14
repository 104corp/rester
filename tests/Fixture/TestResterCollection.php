<?php

namespace Tests\Fixture;

use Corp104\Rester\Api\Endpoint;
use Corp104\Rester\Api\Path;
use Corp104\Rester\ResterClient;
use Corp104\Rester\ResterCollection;
use Corp104\Rester\ResterRequest;
use GuzzleHttp\Psr7\Response;

/**
 * @property TestResterClient tester
 */
class TestResterCollection extends ResterCollection
{
    public function __construct()
    {
        $this->provisionCollection([
            'tester' => new TestResterClient(),
        ]);
    }
}
