<?php

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
    public static function create(array $binding = [], array $queryParams = [], array $parsedBody = []): ResterRequest
    {
        return new static($binding, $queryParams, $parsedBody);
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
    public function getBinding(): array
    {
        return $this->binding;
    }

    /**
     * @return array
     */
    public function getParsedBody(): array
    {
        return $this->parsedBody;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
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
