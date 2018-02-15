<?php

namespace Corp104\Rester\Api;

use Psr\Http\Message\RequestInterface;

/**
 * Api interface
 */
interface ApiInterface
{
    /**
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return RequestInterface
     */
    public function createRequest(
        array $binding = [],
        array $queryParams = [],
        array $parsedBody = []
    ): RequestInterface;
}
