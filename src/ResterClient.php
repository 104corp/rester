<?php

namespace Corp104\Rester;

use Corp104\Support\HttpClientAwareInterface;
use GuzzleHttp\RequestOptions;

/**
 * Client base Class
 */
class ResterClient implements ResterClientInterface, HttpClientAwareInterface, MappingAwareInterface
{
    use ResterClientTrait;

    /**
     * @var array
     */
    const DEFAULT_HTTP_OPTIONS = [
        RequestOptions::CONNECT_TIMEOUT => 3,
        RequestOptions::HEADERS => [],
        RequestOptions::TIMEOUT => 5,
    ];

    /**
     * @param string $baseUrl
     * @param array $httpOptions
     */
    public function __construct($baseUrl, array $httpOptions = [])
    {
        $this->setBaseUrl($baseUrl);

        $this->httpOptions = array_merge(static::DEFAULT_HTTP_OPTIONS, $httpOptions);
    }
}
