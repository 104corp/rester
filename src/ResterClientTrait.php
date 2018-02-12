<?php

namespace Corp104\Rester;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Support\GuzzleClientAwareTrait;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * ResterClient trait
 */
trait ResterClientTrait
{
    use GuzzleClientAwareTrait;
    use MappingAwareTrait;

    /**
     * @var array
     */
    protected $options = [
        RequestOptions::CONNECT_TIMEOUT => 3,
        RequestOptions::HEADERS => [],
        RequestOptions::TIMEOUT => 5,
    ];

    public function __call($method, $args)
    {
        $binding = $args[0] ?? [];

        if (!\is_array($binding)) {
            throw new InvalidArgumentException('$binding must be an array');
        }

        $parsedBody = $args[1] ?? [];

        if (!\is_array($parsedBody)) {
            throw new InvalidArgumentException('$params must be an array');
        }

        $queryParams = $args[2] ?? [];

        if (!\is_array($queryParams)) {
            throw new InvalidArgumentException('$query must be an array');
        }

        return $this->call($method, $binding, $parsedBody, $queryParams);
    }

    /**
     * @param string $name
     * @param array $binding
     * @param array $parsedBody
     * @param array $queryParams
     * @return mixed
     * @throws Exception
     */
    public function call($name, array $binding = [], array $parsedBody = [], array $queryParams = [])
    {
        $api = $this->restMapping->get($name);

        $request = $api->createRequest($this->baseUrl, $binding, $queryParams, $parsedBody);

        $this->beforeSendRequest($request);

        try {
            $response = $this->httpClient->send($request, $this->options);
        } catch (RequestException $e) {
            throw $this->handleException($e);
        }

        $this->afterSendRequest($response, $request);

        return $this->transformResponse($response);
    }

    /**
     * Send request hook when after
     *
     * @param ResponseInterface $response
     * @param RequestInterface $api
     */
    protected function afterSendRequest(ResponseInterface $response, RequestInterface $api)
    {
    }

    /**
     * Send request hook when before
     *
     * @param RequestInterface $api
     */
    protected function beforeSendRequest(RequestInterface $api)
    {
    }

    /**
     * @param RequestException $exception
     * @return null|Exception
     */
    protected function handleException(RequestException $exception): Exception
    {
        return $exception;
    }

    /**
     * Transform response hook
     *
     * @param ResponseInterface $response
     * @return mixed
     */
    protected function transformResponse(ResponseInterface $response)
    {
        return $response;
    }
}
