<?php

namespace Corp104\Rester\Http;

use Corp104\Rester\Exception\InvalidArgumentException;
use Corp104\Support\GuzzleClientAwareInterface;
use Corp104\Support\GuzzleClientAwareTrait;
use GuzzleHttp\Client;
use Psr\Http\Message\UriInterface;

/**
 * Http factory
 */
class Factory implements FactoryInterface, GuzzleClientAwareInterface
{
    use GuzzleClientAwareTrait;

    public function __construct(Client $httpClient)
    {
        $this->setHttpClient($httpClient);
    }

    /**
     * @param string $method
     * @param UriInterface $uri
     * @return ResterRequestInterface
     * @throws InvalidArgumentException
     */
    public function create(string $method, UriInterface $uri): ResterRequestInterface
    {
        switch ($method) {
            case 'GET':
                $instance = new Get($this->httpClient, $uri);
                break;
            case 'HEAD':
                throw new \LogicException('Incomplete yet: ' . $method);
                break;
            case 'POST':
                $instance = new Post($this->httpClient, $uri);
                break;
            case 'PUT':
                $instance = new Put($this->httpClient, $uri);
                break;
            case 'DELETE':
                $instance = new Delete($this->httpClient, $uri);
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
