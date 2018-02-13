<?php

namespace Corp104\Rester;

/**
 * ResterClient base Interface
 */
interface ResterClientInterface
{
    /**
     * @param string $apiName
     * @param ResterRequest $resterRequest
     * @return mixed
     */
    public function call(string $apiName, ResterRequest $resterRequest);
}
