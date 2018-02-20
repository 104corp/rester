<?php

namespace Corp104\Rester\Api;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

/**
 * Endpoint Class
 */
class Endpoint extends Api
{
    public function createRequest(
        array $binding = [],
        array $queryParams = [],
        array $parsedBody = []
    ): RequestInterface {
        $method = $this->getMethod();
        $headers = $this->getHeaders();
        $body = null;

        $uri = $this->bindUri($binding);

        if (!empty($queryParams)) {
            $uri = $uri . '?' . static::buildQueryString($queryParams);
        }

        $uri = new Uri($uri);

        if (!empty($parsedBody)) {
            // TODO: JSON only now, but it is not good
            $body = \GuzzleHttp\json_encode($parsedBody);

            $headers['Content-type'] = 'application/json; charset=UTF-8';
            $headers['Expect'] = '100-continue';
        }

        return new Request($method, $uri, $headers, $body);
    }
}
