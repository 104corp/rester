<?php

namespace Corp104\Rester;

use Corp104\Rester\Api\Api;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Exceptions\ResterException;
use Corp104\Rester\Http\Factory;
use Corp104\Support\GuzzleClientAwareTrait;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * ResterClient trait
 */
trait ResterClientTrait
{
    use GuzzleClientAwareTrait;
    use MappingAwareTrait;

    /**
     * @var string
     */
    protected $baseUrl = '';

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

        $this->beforeSendRequest($api, $parsedBody, $queryParams);

        $requestFactory = new Factory($this->httpClient);
        $request = $api->createRequest($requestFactory, $this->baseUrl, $binding);

        try {
            /** @var ResponseInterface $response */
            $response = $request->sendRequest($parsedBody, $queryParams, $this->options);
        } catch (RequestException $e) {
            throw $this->handleException($e);
        }

        $this->afterSendRequest($response, $api, $parsedBody, $queryParams);

        return $this->transformResponse($response);
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Send request hook when after
     *
     * @param ResponseInterface $response
     * @param Api $api
     * @param array $parsedBody
     * @param array $queryParams
     */
    protected function afterSendRequest(
        ResponseInterface $response,
        Api $api,
        array $parsedBody = [],
        array $queryParams = []
    ) {
    }

    /**
     * Send request hook when before
     *
     * @param Api $api
     * @param array $parsedBody
     * @param array $queryParams
     */
    protected function beforeSendRequest(Api $api, array $parsedBody = [], array $queryParams = [])
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
