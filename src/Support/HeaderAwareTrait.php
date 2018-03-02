<?php

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
        $this->headers[$key] = $value;
    }
}
