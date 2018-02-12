<?php

namespace Corp104\Rester\Api;

use Psr\Http\Message\RequestInterface;

/**
 * Api Class
 */
interface ApiInterface
{
    /**
     * @param string $baseUrl
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return RequestInterface
     */
    public function createRequest(
        string $baseUrl,
        array $binding = [],
        array $queryParams = [],
        array $parsedBody = []
    ): RequestInterface;

    /**
     * @return string
     */
    public function getMethod(): string;
}
