<?php

namespace Corp104\Rester\Api;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Support\BaseUrlAwareTrait;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

/**
 * Api abstract Class
 */
class RefreshTokenApi extends Api
{
    use BaseUrlAwareTrait;

    /**
     * @var string
     */
    private $refreshToken;

    /**
     * @var callable
     */
    private $tokenHandler;

    /**
     * RefreshTokenApi constructor.
     *
     * @param string $refreshToken
     * @param string $uri
     * @param callable $tokenHandler
     * @throws InvalidArgumentException
     */
    public function __construct($refreshToken, $uri, callable $tokenHandler)
    {
        $this->refreshToken = $refreshToken;
        $this->tokenHandler = $tokenHandler;

        if ('/' !== $uri[0]) {
            $uri = '/' . $uri;
        }

        parent::__construct('POST', $uri);
    }

    /**
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return RequestInterface
     */
    public function createRequest(array $binding = [], array $queryParams = [], array $parsedBody = [])
    {
        $method = $this->getMethod();
        $headers = $this->getHeaders();
        $body = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshToken,
        ];

        $uri = $this->baseUrl . $this->bindUri($binding);

        $uri = new Uri($uri);
        $uri = $uri->withQuery(static::buildQueryString($queryParams));

        if (!empty($parsedBody)) {
            // TODO: JSON only now, but it is not good
            $body = \GuzzleHttp\json_encode($parsedBody);

            $headers['Expect'] = '100-continue';
        }

        return new Request($method, $uri, $headers, $body);
    }
}
