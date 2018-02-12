<?php

namespace Corp104\Rester;

/**
 * ResterClient base Interface
 */
interface ResterClientInterface
{
    /**
     * @param $apiName
     * @param array $binding
     * @param array $parsedBody
     * @param array $queryParams
     * @return mixed
     */
    public function call($apiName, array $binding = [], array $parsedBody = [], array $queryParams = []);
}
