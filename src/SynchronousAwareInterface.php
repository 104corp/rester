<?php

namespace Corp104\Rester;

/**
 * Synchronous aware interface
 */
interface SynchronousAwareInterface
{
    /**
     * @param bool|null $synchronous
     */
    public function setSynchronous($synchronous);
}
