<?php

namespace Corp104\Rester;

use Corp104\Rester\Plugins\ResterClientTrait;
use Corp104\Rester\Plugins\ResterMagicTrait;
use Corp104\Support\HttpClientAwareInterface;
use GuzzleHttp\RequestOptions;

/**
 * Client base Class
 */
class ResterClient implements
    ResterClientInterface,
    BaseUrlAwareInterface,
    HttpClientAwareInterface,
    MappingAwareInterface
{
    use ResterClientTrait;
    use ResterMagicTrait;

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
    public function __construct($baseUrl = null, array $httpOptions = [])
    {
        $this->setBaseUrl($baseUrl);

        $this->httpOptions = array_merge(static::DEFAULT_HTTP_OPTIONS, $httpOptions);
    }
}
