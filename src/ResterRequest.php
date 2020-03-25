<?php

declare(strict_types=1);

namespace Corp104\Rester;

/**
 * Request for Rester
 */
class ResterRequest
{
    /**
     * @var array
     */
    private $binding;

    /**
     * @var array
     */
    private $parsedBody;

    /**
     * @var array
     */
    private $queryParams;

    /**
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return ResterRequest
     */
    public static function create(array $binding = [], array $queryParams = [], array $parsedBody = [])
    {
        return new static($binding, $queryParams, $parsedBody);
    }

    /**
     * @param array $binding
     * @return ResterRequest
     */
    public static function createFromBinding(array $binding)
    {
        return new static($binding, [], []);
    }

    /**
     * @param array $parsedBody
     * @return ResterRequest
     */
    public static function createFromParsedBody(array $parsedBody)
    {
        return new static([], [], $parsedBody);
    }

    /**
     * @param array $queryParams
     * @return ResterRequest
     */
    public static function createFromQueryParams(array $queryParams)
    {
        return new static([], $queryParams, []);
    }

    /**
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     */
    public function __construct(array $binding = [], array $queryParams = [], array $parsedBody = [])
    {
        $this->setBinding($binding);
        $this->setQueryParams($queryParams);
        $this->setParsedBody($parsedBody);
    }

    /**
     * @return array
     */
    public function getBinding()
    {
        return $this->binding;
    }

    /**
     * @return array
     */
    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * @param array $binding
     * @return static
     */
    public function setBinding(array $binding = [])
    {
        $this->binding = $binding;
        return $this;
    }

    /**
     * @param array $parsedBody
     * @return static
     */
    public function setParsedBody(array $parsedBody = [])
    {
        $this->parsedBody = $parsedBody;
        return $this;
    }

    /**
     * @param array $queryParams
     * @return static
     */
    public function setQueryParams(array $queryParams = [])
    {
        $this->queryParams = $queryParams;
        return $this;
    }
}
