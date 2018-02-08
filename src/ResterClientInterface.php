<?php

namespace Corp104\Rester;

use Psr\Http\Message\ResponseInterface;

interface ResterClientInterface
{
    /**
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     */
    public function get(string $url, array $params = []);

    /**
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     */
    public function post(string $url, array $params = []);

    /**
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     */
    public function put(string $url, array $params = []);

    /**
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     */
    public function delete(string $url, array $params = []);
}
