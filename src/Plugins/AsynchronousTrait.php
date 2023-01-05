<?php

declare(strict_types=1);

namespace Corp104\Rester\Plugins;

/**
 * AsynchronousTrait
 */
trait AsynchronousTrait
{
    /**
     * @return bool
     */
    public function isAsynchronous(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isSynchronous(): bool
    {
        return false;
    }
}
