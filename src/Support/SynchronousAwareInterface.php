<?php

declare(strict_types=1);

namespace Corp104\Rester\Support;

/**
 * Synchronous aware interface
 */
interface SynchronousAwareInterface
{
    /**
     * @return bool|null
     */
    public function isAsynchronous();

    /**
     * @return bool|null
     */
    public function isSynchronous();
}
