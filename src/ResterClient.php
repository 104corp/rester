<?php

namespace Corp104\Rester;

use Corp104\Support\GuzzleClientAwareInterface;

/**
 * Client base Class
 */
class ResterClient implements ResterClientInterface, GuzzleClientAwareInterface, MappingAwareInterface
{
    use ResterClientTrait;

    /**
     * @param string $baseUrl
     * @param array $guzzleOptions
     */
    public function __construct($baseUrl, array $guzzleOptions = [])
    {
        if ('/' === substr($baseUrl, -1)) {
            $baseUrl = substr($baseUrl, 0, -1);
        }

        $this->setBaseUrl($baseUrl);

        $this->options = array_merge($this->options, $guzzleOptions);
    }
}
