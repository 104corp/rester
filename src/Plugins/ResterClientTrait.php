<?php

declare(strict_types=1);

namespace Corp104\Rester\Plugins;

use Corp104\Rester\Api\ApiInterface;
use Corp104\Rester\Support\BaseUrlAwareTrait;
use Exception;
use GuzzleHttp\ClientInterface;
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
    use MappingTrait;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected array $httpOptions = [];

    /**
     * @return ClientInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    public function setHttpClient(ClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return array
     */
    public function getHttpOptions(): array
    {
        return $this->httpOptions;
    }

    public function setHttpOptions(array $httpOptions): void
    {
        $this->httpOptions = $httpOptions;
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
        $api = $this->mapping->get($name);

        if ($this->isAsynchronousCall($api)) {
            return $this->callAsync($name, $binding, $queryParams, $parsedBody);
        }

        return $this->callSync($name, $binding, $queryParams, $parsedBody);
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
        $request = $this->resolveRequest($name, $binding, $queryParams, $parsedBody);

        $this->beforeSendRequest($request, $name);

        $promise = $this->httpClient->sendAsync($request, $this->httpOptions);

        $this->afterSendRequestAsync($promise, $request, $name);

        return $this->transformPromise($promise, $name);
    }

    /**
     * @param string $name
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return mixed
     * @throws Exception
     */
    public function callSync($name, array $binding = [], array $queryParams = [], array $parsedBody = [])
    {
        $request = $this->resolveRequest($name, $binding, $queryParams, $parsedBody);

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
     * Set mapping base url
     *
     * @param $baseUrl
     */
    protected function afterSetBaseUrl($baseUrl)
    {
        if (null !== $this->mapping) {
            $this->mapping->setBaseUrl($baseUrl);
        }
    }

    /**
     * Send request hook when after
     *
     * @param ResponseInterface $response
     * @param RequestInterface $request
     * @param string $name
     */
    protected function afterSendRequest(ResponseInterface $response, RequestInterface $request, $name)
    {
    }

    /**
     * Send request async hook when after
     *
     * @param PromiseInterface $promise
     * @param RequestInterface $request
     * @param string $name
     */
    protected function afterSendRequestAsync(PromiseInterface $promise, RequestInterface $request, $name)
    {
    }

    /**
     * Send request hook when before
     *
     * @param RequestInterface $request
     * @param string $name
     */
    protected function beforeSendRequest(RequestInterface $request, $name)
    {
    }

    /**
     * Exception handler
     *
     * @param RequestException $exception
     * @param string $name
     * @return null|Exception
     */
    protected function handleException(RequestException $exception, $name)
    {
        return $exception;
    }

    /**
     * True is Asynchronous, False is Synchronous.
     *
     * @param ApiInterface $api
     * @return bool
     */
    protected function isAsynchronousCall(ApiInterface $api)
    {
        // If 'ResterClient' is asynchronous, return true
        return method_exists($this, 'isAsynchronous') && true === $this->isAsynchronous();
    }

    /**
     * Transform promise hook
     *
     * @param PromiseInterface $promise
     * @param string $name
     * @return mixed
     */
    protected function transformPromise(PromiseInterface $promise, $name)
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
    protected function transformResponse(ResponseInterface $response, $name)
    {
        return $response;
    }
}
