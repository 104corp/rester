<?php

namespace Corp104\Rester;

use Corp104\Rester\Exception\ApiNotFoundException;
use Corp104\Rester\Exception\ClientException;
use Corp104\Rester\Exception\InvalidArgumentException;
use Corp104\Rester\Exception\ResterException;
use Corp104\Rester\Exception\ServerException;
use Corp104\Support\GuzzleClientAwareTrait;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * Rester Client trait
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

        $params = $args[1] ?? [];

        if (!\is_array($params)) {
            throw new InvalidArgumentException('$params must be an array');
        }

        $query = $args[2] ?? [];

        if (!\is_array($query)) {
            throw new InvalidArgumentException('$query must be an array');
        }

        return $this->call($method, $binding, $params, $query);
    }

    /**
     * @param string $apiName
     * @param array $binding
     * @param array $params
     * @param array $query
     * @return mixed
     * @throws ResterException
     */
    public function call($apiName, array $binding = [], array $params = [], array $query = [])
    {
        $api = $this->restMapping->get($apiName);

        $this->beforeCallApi($api, $params, $query);
        $response = $this->callApi($api, $binding, $params, $query);
        $this->afterCallApi($response, $api, $params, $query);

        return $this->transformResponse($response);
    }

    /**
     * @param Api $api
     * @param array $binding
     * @param array $params
     * @param array $query
     * @return ResponseInterface
     */
    public function callApi(Api $api, array $binding = [], array $params = [], array $query = []): ResponseInterface
    {
        $method = strtolower($api->getMethod());
        $url = $this->baseUrl . $api->getPath($binding);

        return $this->sendRequest($method, $url, $params, $query);
    }

    public function delete(string $url, array $params = [], array $query = []): ResponseInterface
    {
        $uri = $this->buildQueryString($url, $query);

        return $this->httpClient->delete($uri, $this->options);
    }

    public function get(string $url, array $params = [], array $query = []): ResponseInterface
    {
        $uri = $this->buildQueryString($url, $query);

        return $this->httpClient->get($uri, $this->options);
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function post(string $url, array $params = [], array $query = []): ResponseInterface
    {
        $options = $this->options;

        $options[RequestOptions::JSON] = $params;
        $options[RequestOptions::HEADERS]['Content-type'] = 'application/json; charset=UTF-8';
        $options[RequestOptions::HEADERS]['Expect'] = '100-continue';

        $url = $this->buildQueryString($url, $query);

        return $this->httpClient->post($url, $options);
    }

    public function put(string $url, array $params = [], array $query = []): ResponseInterface
    {
        $options = $this->options;

        $options[RequestOptions::JSON] = $params;
        $options[RequestOptions::HEADERS]['Content-type'] = 'application/json; charset=UTF-8';
        $options[RequestOptions::HEADERS]['Expect'] = '100-continue';

        $url = $this->buildQueryString($url, $query);

        return $this->httpClient->put($url, $options);
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
     * @param array $params
     * @param array $query
     */
    protected function afterCallApi(ResponseInterface $response, Api $api, array $params = [], array $query = [])
    {
    }

    /**
     * Send request hook when before
     *
     * @param Api $api
     * @param array $params
     * @param array $query
     */
    protected function beforeCallApi(Api $api, array $params = [], array $query = [])
    {
    }

    /**
     * @param string $url
     * @param array $params
     * @param array $query
     * @return string
     */
    protected function buildQueryString(string $url, array $params = [], array $query = []): string
    {
        $queryString = http_build_query($query, null, '&', PHP_QUERY_RFC3986);

        return '' === $queryString ? $url : "{$url}?{$queryString}";
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $query
     * @return ResponseInterface
     */
    protected function sendRequest(
        string $method,
        string $url,
        array $params = [],
        array $query = []
    ): ResponseInterface {
        try {
            /** @var ResponseInterface $response */
            $response = $this->$method($url, $params, $query);
        } catch (GuzzleClientException $e) {
            $method = strtoupper($method);
            $code = $e->getCode();
            switch ($code) {
                case 404:
                case 405:
                    $message = "API '$method $url' is not found.";
                    throw new ApiNotFoundException($message, $code, $e);
                default:
                    $message = $e->getMessage();
                    throw new ClientException($message, $code, $e);
            }
        } catch (GuzzleServerException $e) {
            $message = "Internal ERROR in API '$method $url'.";
            throw new ServerException($message, $e->getCode(), $e);
        }

        return $response;
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
