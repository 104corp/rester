<?php

namespace Tests\Fixture;

use Corp104\Rester\Api\Api;
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

        $mapping->set('getFoo', new Api('GET', '/foo'));
        $mapping->set('postFoo', new Api('POST', '/foo'));
        $mapping->set('putFoo', new Api('PUT', '/foo'));
        $mapping->set('deleteFoo', new Api('DELETE', '/foo'));
        $mapping->set('deleteFoo', new Api('DELETE', '/foo', 'http://baseurl'));

        $this->setRestMapping($mapping);
    }
}
