<?php

declare(strict_types=1);

namespace Corp104\Rester\Support;

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
