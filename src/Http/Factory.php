<?php

namespace Corp104\Rester\Http;

use Corp104\Rester\Exception\InvalidArgumentException;
use Corp104\Rester\UriAwareInterface;
use Corp104\Rester\UriAwareTrait;
use Corp104\Support\GuzzleClientAwareInterface;
use Corp104\Support\GuzzleClientAwareTrait;
use GuzzleHttp\Client;
use Psr\Http\Message\UriInterface;

/**
 * Http factory
 */
class Factory implements FactoryInterface, GuzzleClientAwareInterface, UriAwareInterface
{
    use GuzzleClientAwareTrait;
    use UriAwareTrait;

    public function __construct(Client $httpClient, UriInterface $uri)
    {
        $this->setHttpClient($httpClient);
        $this->setUri($uri);
    }

    /**
     * @param string $method
     * @return ResterRequestInterface
     * @throws InvalidArgumentException
     */
    public function create(string $method): ResterRequestInterface
    {
        switch ($method) {
            case 'GET':
                $instance = new Get($this->httpClient, $this->uri);
                break;
            case 'HEAD':
                throw new \LogicException('Incomplete yet: ' . $method);
                break;
            case 'POST':
                $instance = new Post($this->httpClient, $this->uri);
                break;
            case 'PUT':
                $instance = new Put($this->httpClient, $this->uri);
                break;
            case 'DELETE':
                $instance = new Delete($this->httpClient, $this->uri);
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
