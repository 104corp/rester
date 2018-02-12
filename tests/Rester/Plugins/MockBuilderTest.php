<?php

namespace Tests\Rester\Plugins;

use Corp104\Rester\ResterClient;
use GuzzleHttp\Client;
use Tests\Fixture\TestResterClientWithMockBuilder;
use Tests\TestCase;

/**
 * Mock builder test
 */
class MockBuilderTest extends TestCase
{
    /**
     * @var ResterClient
     */
    protected $target;

    /**
     * @test
     */
    public function shouldReturnCorrectDataWhenSettingMock()
    {
        $excepted = 'something';

        $clientMock = TestResterClientWithMockBuilder::createMock([
            'getFoo' => $excepted,
        ]);

        $this->assertSame($excepted, $clientMock->getFoo());
    }

    /**
     * @test
     */
    public function shouldBeOkayWithoutSetting()
    {
        $clientMock = TestResterClientWithMockBuilder::createMock();

        $this->assertInstanceOf(Client::class, $clientMock->getHttpClient());
    }
}
