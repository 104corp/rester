<?php

namespace Corp104\Rester\Resolvers;

use Corp104\Rester\Api\Path;
use Corp104\Rester\Resolver;

/**
 * Resolver for Path object
 */
class PathResolver extends Resolver
{
    public function resolve(string $method, string $path)
    {
        return new Path($method, $path);
    }
}
