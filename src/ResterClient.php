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
        $this->setBaseUrl($baseUrl);

        $this->options = array_merge($this->options, $guzzleOptions);
    }
}
