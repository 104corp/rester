<?php

namespace Corp104\Rester;

use Corp104\Rester\Plugins\ResterClientTrait;
use Corp104\Rester\Plugins\ResterMagicTrait;
use Corp104\Rester\Support\BaseUrlAwareInterface;
use Corp104\Rester\Support\MappingAwareInterface;
use Corp104\Support\HttpClientAwareInterface;
use GuzzleHttp\Client;
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
     * @param string|null $baseUrl
     * @param array $httpOptions
     */
    public function __construct($baseUrl = null, array $httpOptions = [])
    {
        $this->setBaseUrl($baseUrl);
        $this->httpOptions = array_merge([
            RequestOptions::CONNECT_TIMEOUT => 3,
            RequestOptions::HEADERS => [],
            RequestOptions::TIMEOUT => 5,
        ], $httpOptions);

        $this->setHttpClient(new Client($this->httpOptions));
    }
}
