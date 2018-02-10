<?php

namespace Corp104\Rester\Http;

use Corp104\Rester\Exception\InvalidArgumentException;
use GuzzleHttp\Client;

/**
 * Http factory
 */
class Factory implements FactoryInterface
{
    /**
     * @param string $method
     * @param Client $httpClient
     * @return ResterRequestInterface
     * @throws InvalidArgumentException
     */
    public function create(string $method, Client $httpClient): ResterRequestInterface
    {
        switch ($method) {
            case 'GET':
                $instance = new Get($httpClient);
                break;
            case 'HEAD':
                throw new \LogicException('Incomplete yet: ' . $method);
                break;
            case 'POST':
                $instance = new Post($httpClient);
                break;
            case 'PUT':
                $instance = new Put($httpClient);
                break;
            case 'DELETE':
                $instance = new Delete($httpClient);
                break;
            case 'CONNECT':
                throw new \LogicException('Incomplete yet: ' . $method);
                break;
            case 'OPTIONS':
                throw new \LogicException('Incomplete yet: ' . $method);
                break;
            case 'TRACE':
                throw new \LogicException('Incomplete yet: ' . $method);
                break;
            case 'PATCH':
                throw new \LogicException('Incomplete yet: ' . $method);
                break;
            default:
                throw new InvalidArgumentException('Can not create method instance: ' . $method);
        }

        return $instance;
    }
}
