<?php

namespace Corp104\Rester;

use Psr\Http\Message\ResponseInterface;

interface ResterClientInterface
{
    /**
     * @param string $url
     * @param array $queryParams
     * @return ResponseInterface
     */
    public function get(string $url, array $queryParams = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $parsedBody
     * @param array $queryParams
     * @return ResponseInterface
     */
    public function post(string $url, array $parsedBody = [], array $queryParams = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $parsedBody
     * @param array $queryParams
     * @return ResponseInterface
     */
    public function put(string $url, array $parsedBody = [], array $queryParams = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $parsedBody
     * @param array $queryParams
     * @return ResponseInterface
     */
    public function delete(string $url, array $parsedBody = [], array $queryParams = []): ResponseInterface;
}
