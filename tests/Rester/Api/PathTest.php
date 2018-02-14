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
        $exceptedUrl = $baseUrl . '/foo';

        $target = new Path($method, '/foo');
        $target->setBaseUrl($baseUrl);

        $actual = $target->createRequest([], ['q' => 'some']);

        $this->assertEquals($method, $actual->getMethod());
        $this->assertContains($exceptedUrl, (string)$actual->getUri());
        $this->assertContains('q=some', (string)$actual->getUri());
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
