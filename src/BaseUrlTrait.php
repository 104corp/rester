<?php

namespace Corp104\Rester;

/**
 * Base URL trait
 */
trait BaseUrlTrait
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
        $this->baseUrl = $baseUrl;
    }
}
