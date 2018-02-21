<?php

namespace Tests\Rester\Api;

use Corp104\Rester\Api\Path;
use Tests\TestCase;

class PathTest extends TestCase
{
    /**
     * @test
     * @dataProvider availableMethod
     */
    public function shouldSendCorrectRequestWhenUsingPathRequest($method)
    {
        $baseUrl = 'http://127.0.0.1';
        $binding = ['bar' => 'some'];

        $target = new Path($method, '/foo/{bar}');
        $target->setBaseUrl($baseUrl);

        $actual = $target->createRequest($binding, ['q' => 'some']);

        $this->assertSame($method, $actual->getMethod());
        $this->assertSame('http://127.0.0.1/foo/some?q=some', (string)$actual->getUri());
    }

    public function availableMethod(): array
    {
        return [
            ['GET'],
            ['POST'],
            ['PUT'],
            ['DELETE'],
        ];
    }
}
