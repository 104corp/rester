<?php

namespace Corp104\Rester;

use Psr\Http\Message\ResponseInterface;

interface ResterClientInterface
{
    /**
     * @param string $url
     * @param array $params
     * @param array $query
     * @return ResponseInterface
     */
    public function get(string $url, array $params = [], array $query = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $params
     * @param array $query
     * @return ResponseInterface
     */
    public function post(string $url, array $params = [], array $query = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $params
     * @param array $query
     * @return ResponseInterface
     */
    public function put(string $url, array $params = [], array $query = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $params
     * @param array $query
     * @return ResponseInterface
     */
    public function delete(string $url, array $params = [], array $query = []): ResponseInterface;
}
