<?php

namespace Corp104\Rester\Api;

use Corp104\Rester\BaseUrlAwareTrait;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

/**
 * Api Class
 */
class Path extends Api
{
    use BaseUrlAwareTrait;

    /**
     * @var string
     */
    protected $path;

    /**
     * API constructor.
     *
     * @param string $method
     * @param string $path
     * @throws InvalidArgumentException
     */
    public function __construct($method, $path)
    {
        parent::__construct($method);

        if ('/' !== $path[0]) {
            $path = '/' . $path;
        }

        $this->path = $path;
    }

    public function createRequest(
        string $baseUrl,
        array $binding = [],
        array $queryParams = [],
        array $parsedBody = []
    ): RequestInterface {
        $method = $this->getMethod();
        $headers = [];
        $body = null;

        $uri = $baseUrl . static::buildPath($this->path, $binding);

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
