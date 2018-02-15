<?php

namespace Corp104\Rester;

/**
 * Synchronous aware interface
 */
interface SynchronousAwareInterface
{
    /**
     * @param bool $synchronous
     */
    public function setSynchronous(bool $synchronous);
}
