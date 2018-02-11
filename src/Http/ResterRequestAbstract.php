<?php

namespace Corp104\Rester\Http;

use Corp104\Rester\UriAwareInterface;
use Corp104\Rester\UriAwareTrait;
use Corp104\Support\GuzzleClientAwareInterface;
use Corp104\Support\GuzzleClientAwareTrait;
use GuzzleHttp\Client;
use Psr\Http\Message\UriInterface;

/**
 * Http abstract class
 */
abstract class ResterRequestAbstract implements ResterRequestInterface, GuzzleClientAwareInterface, UriAwareInterface
{
    use GuzzleClientAwareTrait;
    use UriAwareTrait;

    /**
     * @param Client $httpClient
     * @param UriInterface $uri
     */
    public function __construct(Client $httpClient, UriInterface $uri)
    {
        $this->setHttpClient($httpClient);
        $this->setUri($uri);
    }

    /**
     * @param array $queryParams
     * @return string
     */
    protected function buildQueryString(array $queryParams): string
    {
        return http_build_query($queryParams, null, '&', PHP_QUERY_RFC3986);
    }
}
