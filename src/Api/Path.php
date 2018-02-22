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
        $headers = $this->getHeaders();
        $body = null;

        $uri = $this->baseUrl . $this->bindUri($binding);

        $uri = new Uri($uri);
        $uri = $uri->withQuery(static::buildQueryString($queryParams));

        if (!empty($parsedBody)) {
            // TODO: JSON only now, but it is not good
            $headers['Content-type'] = 'application/json; charset=UTF-8';
            $headers['Expect'] = '100-continue';

            $body = \GuzzleHttp\json_encode($parsedBody);
        }

        return new Request(
            $this->getMethod(),
            $uri,
            $headers,
            $body
        );
    }
}
