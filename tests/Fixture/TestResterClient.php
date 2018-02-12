<?php

namespace Tests\Fixture;

use Corp104\Rester\Api\Endpoint;
use Corp104\Rester\Api\Path;
use Corp104\Rester\Mapping;
use Corp104\Rester\ResterClient;
use GuzzleHttp\Psr7\Response;

/**
 * @method Response getFoo(array $binding = [], array $parsedBody = [], array $query = [])
 * @method Response postFoo(array $binding = [], array $parsedBody = [], array $query = [])
 * @method Response putFoo(array $binding = [], array $parsedBody = [], array $query = [])
 * @method Response deleteFoo(array $binding = [], array $parsedBody = [], array $query = [])
 * @method Response getEndpoint(array $binding = [], array $parsedBody = [], array $query = [])
 * @method Response postEndpoint(array $binding = [], array $parsedBody = [], array $query = [])
 * @method Response putEndpoint(array $binding = [], array $parsedBody = [], array $query = [])
 * @method Response deleteEndpoint(array $binding = [], array $parsedBody = [], array $query = [])
 */
class TestResterClient extends ResterClient
{
    public function __construct()
    {
        parent::__construct('http://127.0.0.1');

        $mapping = new Mapping();

        $mapping->set('getFoo', new Path('GET', '/foo'));
        $mapping->set('postFoo', new Path('POST', '/foo'));
        $mapping->set('putFoo', new Path('PUT', '/foo'));
        $mapping->set('deleteFoo', new Path('DELETE', '/foo'));
        $mapping->set('getEndpoint', new Endpoint('GET', '/foo'));
        $mapping->set('postEndpoint', new Endpoint('POST', '/foo'));
        $mapping->set('putEndpoint', new Endpoint('PUT', '/foo'));
        $mapping->set('deleteEndpoint', new Endpoint('DELETE', '/foo'));

        $this->setRestMapping($mapping);
    }
}
