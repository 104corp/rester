<?php

namespace Corp104\Rester;

/**
 * Base URL trait
 */
interface BaseUrlAwareInterface
{
    /**
     * @param null|string $baseUrl
     */
    public function setBaseUrl($baseUrl);
}
