<?php

namespace Tests\Fixture;

use Corp104\Rester\Api\Path;
use Corp104\Rester\Mapping;
use Corp104\Rester\ResterClient;
use GuzzleHttp\Psr7\Response;

/**
 * @method Response getFoo(array $binding = [], array $parsedBody = [], array $query = [])
 * @method Response postFoo(array $binding = [], array $parsedBody = [], array $query = [])
 * @method Response putFoo(array $binding = [], array $parsedBody = [], array $query = [])
 * @method Response deleteFoo(array $binding = [], array $parsedBody = [], array $query = [])
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

        $this->setRestMapping($mapping);
    }
}
