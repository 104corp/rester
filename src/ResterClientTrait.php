<?php

namespace Corp104\Rester;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Plugins\SynchronousTrait;
use Corp104\Support\HttpClientAwareTrait;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
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
    use SynchronousTrait;

    /**
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws Exception
     */
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

        return $this->callBySynchronousStatus($method, $binding, $queryParams, $parsedBody);
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
        $request = $this->createRequest($name, $binding, $queryParams, $parsedBody);

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
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return mixed
     * @throws Exception
     */
    public function callAsync($name, array $binding = [], array $queryParams = [], array $parsedBody = [])
    {
        $request = $this->createRequest($name, $binding, $queryParams, $parsedBody);

        $this->beforeSendRequest($request, $name);

        $promise = $this->httpClient->sendAsync($request, $this->httpOptions);

        $this->afterSendRequestAsync($promise, $request, $name);

        return $this->transformPromise($promise, $name);
    }

    /**
     * @param string $name
     * @param ResterRequest $resterRequest
     * @return mixed
     * @throws Exception
     */
    public function callByResterRequest(string $name, ResterRequest $resterRequest)
    {
        $binding = $resterRequest->getBinding();
        $queryParams = $resterRequest->getQueryParams();
        $parsedBody = $resterRequest->getParsedBody();

        return $this->callBySynchronousStatus($name, $binding, $queryParams, $parsedBody);
    }

    /**
     * @param string $name
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return mixed
     */
    public function callBySynchronousStatus($name, $binding, $queryParams, $parsedBody)
    {
        if ($this->synchronous) {
            return $this->call($name, $binding, $queryParams, $parsedBody);
        }

        return $this->callAsync($name, $binding, $queryParams, $parsedBody);
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
     * Send request async hook when after
     *
     * @param PromiseInterface $promise
     * @param RequestInterface $request
     * @param string $name
     */
    protected function afterSendRequestAsync(PromiseInterface $promise, RequestInterface $request, string $name)
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
     * @param string $name
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return RequestInterface
     */
    protected function createRequest($name, $binding, $queryParams, $parsedBody): RequestInterface
    {
        $api = $this->restMapping->get($name);

        return $api->createRequest($binding, $queryParams, $parsedBody);
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
     * Transform promise hook
     *
     * @param PromiseInterface $promise
     * @param string $name
     * @return mixed
     */
    protected function transformPromise(PromiseInterface $promise, string $name)
    {
        return $promise;
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
