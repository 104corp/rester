<?php

namespace Corp104\Rester;

use Psr\Http\Message\UriInterface;

/**
 * URI Aware Interface
 */
interface UriAwareInterface
{
    /**
     * Sets the URI.
     *
     * @param UriInterface $uri
     */
    public function setUri(UriInterface $uri);
}
