<?php

namespace Corp104\Rester;

use Psr\Http\Message\UriInterface;

/**
 * URI Aware Trait
 */
trait UriAwareTrait
{
    /**
     * @var UriInterface
     */
    protected $uri;

    /**
     * @return UriInterface
     */
    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    /**
     * @param UriInterface $uri
     */
    public function setUri(UriInterface $uri)
    {
        $this->uri = $uri;
    }
}
