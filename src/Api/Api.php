<?php

namespace Corp104\Rester\Api;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\SynchronousAwareInterface;
use Corp104\Rester\SynchronousNullTrait;

/**
 * Api abstract Class
 */
abstract class Api implements ApiInterface, SynchronousAwareInterface
{
    use SynchronousNullTrait;

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
     * @param array $bindingKeys
     * @param array $bindingValue
     * @return array
     * @throws InvalidArgumentException
     */
    public static function buildBindingBySequence(array $bindingKeys, array $bindingValue): array
    {
        if (count($bindingKeys) !== count($bindingValue)) {
            throw new InvalidArgumentException('Binding and key count is not same');
        }

        return array_combine($bindingKeys, $bindingValue);
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
     * @param array $binding
     * @return bool
     */
    protected static function guessArrayIsSequence(array $binding): bool
    {
        if (empty($binding)) {
            return false;
        }

        $keys = array_keys($binding);

        return \is_int($keys[0]);
    }

    /**
     * @param string $method
     * @param string $uri
     * @throws InvalidArgumentException
     */
    public function __construct(string $method, string $uri)
    {
        $method = strtoupper($method);

        if (!\in_array($method, static::VALID_METHOD, true)) {
            throw new InvalidArgumentException('Invalid HTTP method: ' . $method);
        }

        $this->method = $method;
        $this->uri = $uri;
    }

    /**
     * @param array $binding
     * @return string
     * @throws InvalidArgumentException
     */
    public function bindUri(array $binding = []): string
    {
        $uri = $this->getUri();

        if (static::guessArrayIsSequence($binding)) {
            $binding = static::buildBindingBySequence(
                $this->getUriBindingKeys(),
                $binding
            );
        }

        foreach ($binding as $key => $value) {
            $uri = str_replace("{{$key}}", $value, $uri);
        }

        if (preg_match('/{.+}/', $uri)) {
            throw new InvalidArgumentException('Binding not complete');
        }

        return $uri;
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
     * @return array
     */
    public function getUriBindingKeys(): array
    {
        $binding = [];

        preg_match_all('/\/{(.*)}/U', $this->uri, $binding);

        return $binding[1];
    }

    /**
     * @return string
     */
    public function getUriWithoutBinding(): string
    {
        return $this->getUri(false);
    }
}
