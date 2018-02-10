<?php

namespace Corp104\Rester\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Get request
 */
class Get extends ResterRequestAbstract
{
    public function sendRequest(
        $url,
        array $parsedBody = [],
        array $queryParams = [],
        array $guzzleOptions = []
    ): ResponseInterface {
        $uri = $this->buildQueryString($url, $queryParams);

        return $this->httpClient->get($uri, $guzzleOptions);
    }
}
