<?php

namespace Corp104\Rester;

/**
 * Base URL trait
 */
trait BaseUrlAwareTrait
{
    /**
     * @var null|string
     */
    protected $baseUrl;

    /**
     * @return null|string
     * @throws \BadMethodCallException
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param null|string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        if ('/' === substr($baseUrl, -1)) {
            $baseUrl = substr($baseUrl, 0, -1);
        }

        $this->baseUrl = $baseUrl;
    }
}
