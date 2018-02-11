<?php

namespace Corp104\Rester\Http;

/**
 * Http interface
 */
interface FactoryInterface
{
    /**
     * @param string $method
     * @return ResterRequestInterface
     */
    public function create(string $method): ResterRequestInterface;
}
