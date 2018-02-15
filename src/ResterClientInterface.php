<?php

namespace Corp104\Rester;

/**
 * ResterClient base Interface
 */
interface ResterClientInterface
{
    /**
     * @param string $name
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return mixed
     */
    public function call($name, array $binding = [], array $queryParams = [], array $parsedBody = []);

    /**
     * @param string $name
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return mixed
     */
    public function callAsync($name, array $binding = [], array $queryParams = [], array $parsedBody = []);
}
