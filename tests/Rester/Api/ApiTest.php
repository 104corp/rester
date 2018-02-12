<?php

namespace Tests\Rester\Api;

use Corp104\Rester\Api\Api;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBindPathOkWithoutBinding()
    {
        $this->assertSame('/foo', Api::bindUri('/foo'));
    }

    /**
     * @test
     */
    public function shouldBindPathOk()
    {
        $actual = Api::bindUri('/foo/{bar}', [
            'bar' => 'some',
        ]);

        $this->assertSame('/foo/some', $actual);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingNotComplete()
    {
        $this->expectException(InvalidArgumentException::class);

        $binding = [
            'bar' => 'some',
        ];

        Api::bindUri('/foo/{bar}/{baz}', $binding);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingNotCompleteWithEmptyBinding()
    {
        $this->expectException(InvalidArgumentException::class);

        Api::bindUri('/foo/{bar}');
    }
}
