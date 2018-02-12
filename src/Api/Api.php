<?php

namespace Corp104\Rester\Api;

use Corp104\Rester\Exceptions\InvalidArgumentException;

/**
 * Api abstract Class
 */
abstract class Api implements ApiInterface
{
    /**
     * @var array
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     */
    const VALID_METHOD = [
        'GET',
        'HEAD',
        'POST',
        'PUT',
        'DELETE',
        'CONNECT',
        'OPTIONS',
        'TRACE',
        'PATCH',
    ];

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @param string $method
     * @return bool
     */
    public static function isValidMethod(string $method): bool
    {
        $method = strtoupper($method);

        return \in_array($method, static::VALID_METHOD, true);
    }

    /**
     * @param array $queryParams
     * @return string
     */
    public static function buildQueryString(array $queryParams): string
    {
        return http_build_query($queryParams, null, '&', PHP_QUERY_RFC3986);
    }

    /**
     * @param string $uri
     * @param array $binding
     * @return string
     * @throws InvalidArgumentException
     */
    public static function bindUri(string $uri, array $binding = []): string
    {
        foreach ($binding as $key => $value) {
            $uri = str_replace("{{$key}}", $value, $uri);
        }

        if (preg_match('/\{.+\}/', $uri)) {
            throw new InvalidArgumentException('Binding not complete');
        }

        return $uri;
    }

    /**
     * @param string $method
     * @param string $uri
     * @throws InvalidArgumentException
     */
    public function __construct(string $method, string $uri)
    {
        if (!static::isValidMethod($method)) {
            throw new InvalidArgumentException('Invalid HTTP method: ' . $method);
        }

        $this->method = $method;
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param bool $withBinding
     * @return string
     */
    public function getUri($withBinding = true): string
    {
        if ($withBinding) {
            return $this->uri;
        }

        return preg_replace('/\/{.*}/', '', $this->uri);
    }

    /**
     * @return string
     */
    public function getUriWithoutBinding(): string
    {
        return $this->getUri(false);
    }

    /**
     * @return array
     */
    public function getUriBindingKeys(): array
    {
        $binding = [];

        preg_match_all('/\/{(.*)}/U', $this->uri, $binding);

        return $binding[1];
    }
}
