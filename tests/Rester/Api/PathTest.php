<?php

namespace Tests\Rester\Api;

use Corp104\Rester\Api\Path;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Tests\TestCase;

class PathTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowInvalidArgumentExceptionWhenPassUnknownHttpMethod()
    {
        $this->expectException(InvalidArgumentException::class);

        new Path('Unknown', 'some-url');
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallGetMethod()
    {
        $target = new Path('GET', '/foo');

        $this->assertSame('GET', $target->getMethod());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallGetUriBindingKeys()
    {
        $target = new Path('GET', '/{foo}/{bar}');

        $excepted = ['foo', 'bar'];

        $this->assertSame($excepted, $target->getUriBindingKeys());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallGetUriWithAndWithoutBinding()
    {
        $target = new Path('GET', '/some/{foo}/bar/{baz}');

        $this->assertSame('/some/{foo}/bar/{baz}', $target->getUri());
        $this->assertSame('/some', $target->getUriWithoutBinding());
    }

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
