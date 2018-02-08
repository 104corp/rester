<?php

namespace Corp104\Rester;

/**
 * Interface ResterClientAwareInterface is implemented by classes that depends on a Client.
 */
interface ResterClientAwareInterface
{
    /**
     * Sets the Client.
     *
     * @param ResterClient $restClient
     */
    public function setRestClient(ResterClient $restClient);
}
