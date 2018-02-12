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
     * @param string $path
     * @param array $binding
     * @return string
     * @throws InvalidArgumentException
     */
    public static function buildPath(string $path, array $binding = []): string
    {
        foreach ($binding as $key => $value) {
            $path = str_replace("{{$key}}", $value, $path);
        }

        if (preg_match('/\{.+\}/', $path)) {
            throw new InvalidArgumentException('Binding not complete');
        }

        return $path;
    }

    /**
     * @param string $method
     * @throws InvalidArgumentException
     */
    public function __construct(string $method)
    {
        if (!static::isValidMethod($method)) {
            throw new InvalidArgumentException('Invalid HTTP method: ' . $method);
        }

        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
