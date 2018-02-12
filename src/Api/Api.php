<?php

namespace Corp104\Rester\Api;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Http\Factory;
use Corp104\Rester\Http\ResterRequestInterface;
use GuzzleHttp\Psr7\Uri;

/**
 * Api Class
 */
class Api implements ApiInterface
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
     * API constructor.
     *
     * @param string $method
     * @param string $path
     * @throws InvalidArgumentException
     */
    public function __construct($method, $path)
    {
        if (!static::isValidMethod($method)) {
            throw new InvalidArgumentException('Invalid HTTP method: ' . $method);
        }

        if ('/' !== $path[0]) {
            $path = '/' . $path;
        }

        $this->method = $method;
        $this->path = $path;
    }

    /**
     * @param Factory $factory
     * @param string $baseUrl
     * @param array $binding
     * @return ResterRequestInterface
     * @throws InvalidArgumentException
     */
    public function createRequest(Factory $factory, string $baseUrl, array $binding = []): ResterRequestInterface
    {
        return $factory->create(
            $this->getMethod(),
            new Uri($baseUrl . $this->getPath($binding))
        );
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