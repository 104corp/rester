<?php

namespace Corp104\Rester\Api;

use Corp104\Rester\Resolver;

/**
 * Resolver for Endpoint object
 */
class EndpointResolver extends Resolver
{
    public function resolve(string $method, string $uri)
    {
        return new Endpoint($method, $uri);
    }
}
