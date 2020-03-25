<?php

declare(strict_types=1);

namespace Corp104\Rester\Support;

/**
 * Header aware interface
 */
interface HeaderAwareInterface
{
    /**
     * @param string $key
     * @param string|array $value
     */
    public function setHeader($key, $value);
}
