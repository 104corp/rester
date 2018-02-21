<?php

namespace Corp104\Rester\Plugins;

/**
 * SynchronousTrait
 */
trait SynchronousTrait
{
    /**
     * @return bool
     */
    public function isAsynchronous()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isSynchronous()
    {
        return true;
    }
}
