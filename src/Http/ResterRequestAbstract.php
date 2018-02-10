<?php

namespace Corp104\Rester\Http;

use Corp104\Support\GuzzleClientAwareInterface;
use Corp104\Support\GuzzleClientAwareTrait;
use GuzzleHttp\Client;

/**
 * Http abstract class
 */
abstract class ResterRequestAbstract implements ResterRequestInterface, GuzzleClientAwareInterface
{
    use GuzzleClientAwareTrait;

    /**
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->setHttpClient($httpClient);
    }

    /**
     * @param string $url
     * @param array $queryParams
     * @return string
     */
    protected function buildQueryString(string $url, array $queryParams = []): string
    {
        $queryString = http_build_query($queryParams, null, '&', PHP_QUERY_RFC3986);

        return '' === $queryString ? $url : "{$url}?{$queryString}";
    }
}
