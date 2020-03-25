<?php

declare(strict_types=1);

namespace Corp104\Rester\Resolvers;

use Corp104\Rester\Api\Endpoint;
use Corp104\Rester\Resolver;

/**
 * Resolver for Endpoint object
 */
class EndpointResolver extends Resolver
{
    public function resolve($method, $uri)
    {
        return new Endpoint($method, $uri);
    }
}
