<?php

namespace Corp104\Rester\Api;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

/**
 * Api abstract Class
 */
abstract class ApiAbstract implements ApiInterface
{
    /**
     * @var array
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     */
    protected static $VALID_METHOD = [
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
    protected $path;

    /**
     * @return array
     */
    public static function getValidMethods(): array
    {
        return self::$VALID_METHOD;
    }

    /**
     * @param string $method
     * @return bool
     */
    public static function isValidMethod(string $method): bool
    {
        $method = strtoupper($method);

        return \in_array($method, static::$VALID_METHOD, true);
    }

    /**
     * @param array $methods
     */
    public static function setValidMethods(array $methods)
    {
        self::$VALID_METHOD = $methods;
    }

    /**
     * @param array $queryParams
     * @return string
     */
    protected static function buildQueryString(array $queryParams): string
    {
        return http_build_query($queryParams, null, '&', PHP_QUERY_RFC3986);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param array $binding
     * @return string
     * @throws InvalidArgumentException
     */
    public function getPath(array $binding = []): string
    {
        $path = $this->path;

        foreach ($binding as $key => $value) {
            $path = str_replace("{{$key}}", $value, $path);
        }

        if (preg_match('/\{.+\}/', $path)) {
            throw new InvalidArgumentException('Binding not complete');
        }

        return $path;
    }
}
