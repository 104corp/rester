<?php

namespace Corp104\Rester;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Support\HttpClientAwareTrait;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * ResterClient trait
 */
trait ResterClientTrait
{
    use BaseUrlAwareTrait;
    use HttpClientAwareTrait;
    use MappingAwareTrait;

    public function __call($method, $args)
    {
        $binding = $args[0] ?? [];

        // Call directly when first parameter is instance of ResterRequest
        if ($binding instanceof ResterRequest) {
            return $this->callByResterRequest($method, $binding);
        }

        if (!\is_array($binding)) {
            throw new InvalidArgumentException('$binding must be an array');
        }

        $queryParams = $args[1] ?? [];

        if (!\is_array($queryParams)) {
            throw new InvalidArgumentException('$query must be an array');
        }

        $parsedBody = $args[2] ?? [];

        if (!\is_array($parsedBody)) {
            throw new InvalidArgumentException('$params must be an array');
        }

        return $this->call($method, $binding, $queryParams, $parsedBody);
    }

    /**
     * @param string $name
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return mixed
     * @throws Exception
     */
    public function call($name, array $binding = [], array $queryParams = [], array $parsedBody = [])
    {
        $api = $this->restMapping->get($name);

        $request = $api->createRequest($binding, $queryParams, $parsedBody);

        $this->beforeSendRequest($request, $name);

        try {
            $response = $this->httpClient->send($request, $this->httpOptions);
        } catch (RequestException $e) {
            throw $this->handleException($e, $name);
        }

        $this->afterSendRequest($response, $request, $name);

        return $this->transformResponse($response, $name);
    }

    /**
     * @param string $name
     * @param ResterRequest $resterRequest
     * @return mixed
     * @throws Exception
     */
    public function callByResterRequest(string $name, ResterRequest $resterRequest)
    {
        return $this->call(
            $name,
            $resterRequest->getBinding(),
            $resterRequest->getQueryParams(),
            $resterRequest->getParsedBody()
        );
    }

    /**
     * Send request hook when after
     *
     * @param ResponseInterface $response
     * @param RequestInterface $request
     * @param string $name
     */
    protected function afterSendRequest(ResponseInterface $response, RequestInterface $request, string $name)
    {
    }

    /**
     * Send request hook when before
     *
     * @param RequestInterface $request
     * @param string $name
     */
    protected function beforeSendRequest(RequestInterface $request, string $name)
    {
    }

    /**
     * Exception handler
     *
     * @param RequestException $exception
     * @param string $name
     * @return null|Exception
     */
    protected function handleException(RequestException $exception, string $name): Exception
    {
        return $exception;
    }

    /**
     * Transform response hook
     *
     * @param ResponseInterface $response
     * @param string $name
     * @return mixed
     */
    protected function transformResponse(ResponseInterface $response, string $name)
    {
        return $response;
    }
}
