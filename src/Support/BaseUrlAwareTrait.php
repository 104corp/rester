<?php

declare(strict_types=1);

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
     * @param mixed $instance
     */
    public function duplicateBaseUrlTo($instance)
    {
        if ($instance instanceof BaseUrlAwareInterface) {
            $instance->setBaseUrl($this->baseUrl);
        }
    }

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
        $baseUrl = (string)$baseUrl;

        if ('/' === substr($baseUrl, -1)) {
            $baseUrl = substr($baseUrl, 0, -1);
        }

        $this->baseUrl = $baseUrl;
        $this->afterSetBaseUrl($baseUrl);
    }

    /**
     * The hook for set base url
     */
    protected function afterSetBaseUrl()
    {
    }
}
