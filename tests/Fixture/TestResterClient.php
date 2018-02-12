<?php

namespace Tests\Fixture;

use Corp104\Rester\Api\Endpoint;
use Corp104\Rester\Api\Path;
use Corp104\Rester\Mapping;
use Corp104\Rester\ResterClient;
use GuzzleHttp\Psr7\Response;

/**
 * @method Response getFoo(array $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response postFoo(array $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response putFoo(array $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response deleteFoo(array $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response getEndpoint(array $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response postEndpoint(array $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response putEndpoint(array $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response deleteEndpoint(array $binding = [], array $queryParams = [], array $parsedBody = [])
 */
class TestResterClient extends ResterClient
{
    public function __construct()
    {
        parent::__construct('http://127.0.0.1');

        $this->provisionRestMapping([
            'getFoo' => new Path('GET', '/foo'),
            'postFoo' => new Path('POST', '/foo'),
            'putFoo' => new Path('PUT', '/foo'),
            'deleteFoo' => new Path('DELETE', '/foo'),
            'getEndpoint' => new Endpoint('GET', '/foo'),
            'postEndpoint' => new Endpoint('POST', '/foo'),
            'putEndpoint' => new Endpoint('PUT', '/foo'),
            'deleteEndpoint' => new Endpoint('DELETE', '/foo'),
        ], 'http://127.0.0.1');
    }
}
