<?php

namespace Corp104\Rester\Plugins;

/**
 * AsynchronousTrait
 */
trait AsynchronousTrait
{
    /**
     * @return bool
     */
    public function isAsynchronous()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isSynchronous()
    {
        return false;
    }
}
