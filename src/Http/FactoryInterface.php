<?php

namespace Corp104\Rester\Http;

use GuzzleHttp\Client;

/**
 * Http interface
 */
interface FactoryInterface
{
    /**
     * @param string $method
     * @param Client $httpClient
     * @return ResterRequestInterface
     */
    public function create(string $method, Client $httpClient): ResterRequestInterface;
}
