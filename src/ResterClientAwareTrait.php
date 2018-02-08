<?php
namespace Corp104\Rester;

/**
 * Trait ResterClientAwareTrait is used by classes that implements ClientAwareInterface.
 */
trait ResterClientAwareTrait
{
    /**
     * @var ResterClient
     */
    protected $restClient;

    /**
     * Sets the API Client.
     *
     * @param ResterClient $restClient
     */
    public function setRestClient(ResterClient $restClient)
    {
        $this->restClient = $restClient;
    }
}
