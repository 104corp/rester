<?php

namespace Corp104\Rester;

use Corp104\Rester\Exception\ApiNotFoundException;
use Corp104\Rester\Exception\ClientException;
use Corp104\Rester\Exception\InvalidArgumentException;
use Corp104\Rester\Exception\ResterException;
use Corp104\Rester\Exception\ServerException;
use Corp104\Rester\Http\Factory;
use Corp104\Support\GuzzleClientAwareTrait;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;
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
     * @param string $apiName
     * @param array $binding
     * @param array $parsedBody
     * @param array $queryParams
     * @return mixed
     * @throws ResterException
     */
    public function call($apiName, array $binding = [], array $parsedBody = [], array $queryParams = [])
    {
        $api = $this->restMapping->get($apiName);

        $this->beforeCallApi($api, $parsedBody, $queryParams);
        $response = $this->callApi($api, $binding, $parsedBody, $queryParams);
        $this->afterCallApi($response, $api, $parsedBody, $queryParams);

        return $this->transformResponse($response);
    }

    /**
     * @param Api $api
     * @param array $binding
     * @param array $parsedBody
     * @param array $queryParams
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    public function callApi(
        Api $api,
        array $binding = [],
        array $parsedBody = [],
        array $queryParams = []
    ): ResponseInterface {
        $url = $this->baseUrl . $api->getPath($binding);
        $resterRequestFactory = new Factory($this->httpClient);
        $request = $api->createResterRequest($resterRequestFactory);

        try {
            /** @var ResponseInterface $response */
            $response = $request->sendRequest($url, $parsedBody, $queryParams, $this->options);
        } catch (GuzzleClientException $e) {
            $code = $e->getCode();
            switch ($code) {
                case 404:
                case 405:
                    $message = "API '{$api->getMethod()} {$url}' is not found.";
                    throw new ApiNotFoundException($message, $code, $e);
                default:
                    $message = $e->getMessage();
                    throw new ClientException($message, $code, $e);
            }
        } catch (GuzzleServerException $e) {
            $message = "Internal ERROR in API '{$api->getMethod()} {$url}'.";
            throw new ServerException($message, $e->getCode(), $e);
        }

        return $response;
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
    protected function afterCallApi(
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
    protected function beforeCallApi(Api $api, array $parsedBody = [], array $queryParams = [])
    {
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
