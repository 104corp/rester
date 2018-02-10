<?php

namespace Corp104\Rester\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Delete request
 */
class Delete extends ResterRequestAbstract
{
    public function sendRequest(
        $url,
        array $parsedBody = [],
        array $queryParams = [],
        array $guzzleOptions = []
    ): ResponseInterface {
        $uri = $this->buildQueryString($url, $queryParams);

        return $this->httpClient->delete($uri, $guzzleOptions);
    }
}
