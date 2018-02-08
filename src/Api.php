<?php
namespace Corp104\Rester;

use Corp104\Rester\Exception\InvalidArgumentException;

/**
 * Api Class
 */
class Api
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
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @return array
     */
    public static function getValidMethods(): array
    {
        return self::$VALID_METHOD;
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
        $method = strtoupper($method);

        $validMethod = \in_array($method, static::$VALID_METHOD, true);

        if (!$validMethod) {
            throw new InvalidArgumentException('Invalid HTTP method: ' . $method);
        }

        if ('/' !== $path[0]) {
            $path = '/' . $path;
        }

        $this->method = $method;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
