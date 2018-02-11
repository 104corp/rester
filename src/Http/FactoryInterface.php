<?php

namespace Corp104\Rester\Http;

use Psr\Http\Message\UriInterface;

/**
 * Http interface
 */
interface FactoryInterface
{
    /**
     * @param string $method
     * @param UriInterface $uri
     * @return ResterRequestInterface
     */
    public function create(string $method, UriInterface $uri): ResterRequestInterface;
}
