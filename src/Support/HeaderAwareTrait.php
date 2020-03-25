<?php

declare(strict_types=1);

namespace Corp104\Rester\Support;

/**
 * Header trait
 */
trait HeaderAwareTrait
{
    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $key
     * @param string|array $value
     */
    public function setHeader($key, $value)
    {
        $this->beforeSetHeader($key, $value);
        $this->headers[$key] = $value;
        $this->afterSetHeader($key, $value);
    }

    /**
     * The hook for set header
     *
     * @param string $key
     * @param string $value
     */
    protected function afterSetHeader($key, $value)
    {
    }

    /**
     * The hook for set header
     *
     * @param string $key
     * @param string $value
     */
    protected function beforeSetHeader($key, $value)
    {
    }
}
