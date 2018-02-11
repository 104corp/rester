<?php

namespace Corp104\Rester\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Delete request
 */
class Delete extends ResterRequestAbstract
{
    public function sendRequest(
        array $parsedBody = [],
        array $queryParams = [],
        array $guzzleOptions = []
    ): ResponseInterface {
        $this->uri->withQuery(
            $this->buildQueryString($queryParams)
        );

        return $this->httpClient->delete((string)$this->uri, $guzzleOptions);
    }
}
