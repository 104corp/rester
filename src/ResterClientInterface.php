<?php

declare(strict_types=1);

namespace Corp104\Rester;

/**
 * ResterClient base Interface
 */
interface ResterClientInterface extends ResterInterface
{
    /**
     * Call api asynchronous
     *
     * @param string $name
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return mixed
     */
    public function callAsync($name, array $binding = [], array $queryParams = [], array $parsedBody = []);

    /**
     * Call api synchronous
     *
     * @param string $name
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return mixed
     */
    public function callSync($name, array $binding = [], array $queryParams = [], array $parsedBody = []);
}
