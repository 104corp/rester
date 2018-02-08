<?php

namespace Corp104\Rester;

use Corp104\Rester\Exception\ApiNotFoundException;
use Corp104\Rester\Exception\ClientException;
use Corp104\Rester\Exception\InvalidArgumentException;
use Corp104\Rester\Exception\ResterException;
use Corp104\Rester\Exception\ServerException;
use Corp104\Support\GuzzleClientAwareTrait;
use Corp104\Support\LoggerTrait;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LogLevel;

/**
 * Rester Client trait
 */
trait ResterClientTrait
{
    use GuzzleClientAwareTrait;
    use LoggerTrait;
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

    /**
     * @param string $url
     * @param array $params
     * @return string
     */
    protected function buildUrl(string $url, array $params = []): string
    {
        if (!empty($params)) {
            $url = $url . '/' . implode('/', $params);
        }

        return $url;
    }

    /**
     * @param Api $route
     * @param array $params
     * @return ResponseInterface
     * @throws ResterException
     */
    protected function sendRequest($route, $params)
    {
        $url = $this->baseUrl . $route->getPath();

        $httpMethod = strtolower($route->getMethod());

        try {
            /** @var ResponseInterface $response */
            $response = $this->$httpMethod($url, $params);
        } catch (GuzzleClientException $e) {
            $httpMethod = strtoupper($httpMethod);
            $code = $e->getCode();
            switch ($code) {
                case 404:
                case 405:
                    $message = "API '$httpMethod $url' is not found.";
                    throw new ApiNotFoundException($message, $code, $e);
                default:
                    $message = $e->getMessage();
                    throw new ClientException($message, $code, $e);
            }
        } catch (GuzzleServerException $e) {
            $message = "Internal ERROR in API '$httpMethod $url'.";
            throw new ServerException($message, $e->getCode(), $e);
        }

        return $response;
    }

    public function __call($method, $args)
    {
        $params = [];

        if (isset($args[0])) {
            if (!\is_array($args[0])) {
                throw new InvalidArgumentException('args[0] must be an array');
            }

            $params = $args[0];
        }

        return $this->call($method, $params);
    }

    /**
     * @param string $api
     * @param array $params
     * @return mixed
     * @throws ResterException
     */
    public function call($api, array $params = [])
    {
        $route = $this->restMapping->get($api);

        $this->preSendRequest($route, $params);
        return $this->transformResponse($this->sendRequest($route, $params));
    }

    /**
     * Send request hook for prepare
     *
     * @param string $api
     * @param array $params
     */
    protected function preSendRequest($api, array $params = [])
    {
    }

    /**
     * Send request hook for post
     *
     * @param ResponseInterface $response
     * @return mixed
     */
    protected function transformResponse(ResponseInterface $response)
    {
        return $response;
    }

    public function delete(string $url, array $params = [])
    {
        $uri = $this->buildUrl($url, $params);

        $this->log(LogLevel::INFO, "DELETE {$uri}");
        return $this->getHttpClient()->delete($uri, $this->options);
    }

    public function get(string $url, array $params = [])
    {
        $uri = $this->buildUrl($url, $params);

        $this->log(LogLevel::INFO, "GET {$uri}");
        return $this->getHttpClient()->get($uri, $this->options);
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function post(string $url, array $params = [])
    {
        $options = $this->options;

        $options[RequestOptions::JSON] = $params;
        $options[RequestOptions::HEADERS]['Content-type'] = 'application/json; charset=UTF-8';
        $options[RequestOptions::HEADERS]['Expect'] = '100-continue';

        $uri = $this->buildUrl($url);

        $this->log(LogLevel::INFO, "POST {$uri}, payload: " . json_encode($params));
        return $this->getHttpClient()->post($uri, $options);
    }

    public function put(string $url, array $params = [])
    {
        $options = $this->options;

        $options[RequestOptions::JSON] = $params;
        $options[RequestOptions::HEADERS]['Content-type'] = 'application/json; charset=UTF-8';
        $options[RequestOptions::HEADERS]['Expect'] = '100-continue';

        $uri = $this->buildUrl($url);

        $this->log(LogLevel::INFO, "PUT {$uri}, payload: " . json_encode($params));
        return $this->getHttpClient()->put($uri, $options);
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
}
