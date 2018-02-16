<?php

namespace Corp104\Rester\Api;

use Corp104\Rester\Support\BaseUrlAwareInterface;
use Corp104\Rester\Support\BaseUrlAwareTrait;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

/**
 * Api Class
 */
class Path extends Api implements BaseUrlAwareInterface
{
    use BaseUrlAwareTrait;

    /**
     * API constructor.
     *
     * @param string $method
     * @param string $path
     * @throws InvalidArgumentException
     */
    public function __construct($method, $path)
    {
        if ('/' !== $path[0]) {
            $path = '/' . $path;
        }

        parent::__construct($method, $path);
    }

    public function createRequest(
        array $binding = [],
        array $queryParams = [],
        array $parsedBody = []
    ): RequestInterface {
        $method = $this->getMethod();
        $headers = [];
        $body = null;

        $uri = $this->baseUrl . $this->bindUri($binding);

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
