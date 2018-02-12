<?php

namespace Corp104\Rester;

/**
 * Base URL trait
 */
interface BaseUrlAwareInterface
{
    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl);
}
