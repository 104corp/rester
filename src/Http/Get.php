<?php

namespace Corp104\Rester\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Get request
 */
class Get extends ResterRequestAbstract
{
    public function sendRequest(
        array $parsedBody = [],
        array $queryParams = [],
        array $guzzleOptions = []
    ): ResponseInterface {
        $this->uri->withQuery(
            $this->buildQueryString($queryParams)
        );

        return $this->httpClient->get((string)$this->uri, $guzzleOptions);
    }
}
