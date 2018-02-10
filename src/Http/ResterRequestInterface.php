<?php

namespace Corp104\Rester\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Http interface
 */
interface ResterRequestInterface
{
    /**
     * @param string $url
     * @param array $parsedBody
     * @param array $queryParams
     * @param array $guzzleOptions
     * @return ResponseInterface
     */
    public function sendRequest(
        $url,
        array $parsedBody = [],
        array $queryParams = [],
        array $guzzleOptions = []
    ): ResponseInterface;
}
