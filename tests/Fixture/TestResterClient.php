<?php

namespace Tests\Fixture;

use Corp104\Rester\Api\Endpoint;
use Corp104\Rester\Api\Path;
use Corp104\Rester\ResterClient;
use Corp104\Rester\ResterRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Tests\Fixture\Server\Server;

/**
 * @method Response getFoo(array|ResterRequest $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response postFoo(array|ResterRequest $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response putFoo(array|ResterRequest $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response deleteFoo(array|ResterRequest $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response getEndpoint(array|ResterRequest $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response postEndpoint(array|ResterRequest $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response putEndpoint(array|ResterRequest $binding = [], array $queryParams = [], array $parsedBody = [])
 * @method Response deleteEndpoint(array|ResterRequest $binding = [], array $queryParams = [], array $parsedBody = [])
 */
class TestResterClient extends ResterClient
{
    public function __construct()
    {
        parent::__construct(Server::$baseUrl);

        $this->provisionMapping([
            'getFoo' => new Path('GET', '/foo'),
            'postFoo' => new Path('POST', '/foo'),
            'putFoo' => new Path('PUT', '/foo'),
            'deleteFoo' => new Path('DELETE', '/foo'),
            'getEndpoint' => new Endpoint('GET', '/foo'),
            'postEndpoint' => new Endpoint('POST', '/foo'),
            'putEndpoint' => new Endpoint('PUT', '/foo'),
            'deleteEndpoint' => new Endpoint('DELETE', '/foo'),
        ], Server::$baseUrl);

        $this->setHttpClient(new Client($this->httpOptions));
    }
}
