<?php

namespace Corp104\Rester\Support;

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
