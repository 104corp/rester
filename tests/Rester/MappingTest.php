<?php

namespace Tests\Rester;

use Corp104\Rester\Api\Api;
use Corp104\Rester\Api\ApiInterface;
use Corp104\Rester\Api\Endpoint;
use Corp104\Rester\Api\EndpointResolver;
use Corp104\Rester\Api\Path;
use Corp104\Rester\Api\PathResolver;
use Corp104\Rester\Exceptions\ApiNotFoundException;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Mapping;
use Tests\Fixture\TestResterClientWithSynchronousAwareInterface;
use Tests\TestCase;

class MappingTest extends TestCase
{
    /**
     * @var Mapping
     */
    protected $target;

    protected function setUp()
    {
        parent::setUp();

        $this->target = new Mapping();
    }

    protected function tearDown()
    {
        $this->target = null;

        parent::tearDown();
    }

    public function trueAndFalse()
    {
        return [
            [true],
            [false],
        ];
    }

    public function invalidSetting()
    {
        return [
            [['array-count-less-then-2']],
            [['array', 'count', 'more', 'then', '2']],
            [['not-a-callable', 'whatever']],
            [
                [
                    function () {
                    },
                    'not-array'
                ]
            ],
            ['string'],
            [new \stdClass()],
        ];
    }

    /**
     * @test
     */
    public function shouldThrowInvalidApiExceptionWhenApiNotFound()
    {
        $this->expectException(ApiNotFoundException::class);

        $this->target->get('UnknownApi');
    }

    /**
     * @test
     */
    public function shouldGetEmptyArrayWhenGetApiListFirst()
    {
        $this->assertEquals([], $this->target->all());
    }

    /**
     * @test
     */
    public function shouldGetOneApiListWhenAfterSetOneApiList()
    {
        $exceptedApiName = 'some-api';
        $exceptedCount = 1;

        $this->target->set($exceptedApiName, new Path('GET', $exceptedApiName));
        $actualApiList = $this->target->all();

        $this->assertArrayHasKey($exceptedApiName, $actualApiList);
        $this->assertCount($exceptedCount, $actualApiList);
    }

    /**
     * @test
     */
    public function shouldNotCreateApiInstanceWhenSetSetting()
    {
        $apiSetting = [
            [Path::class, 'create'],    // Callable
            ['GET', '/foo'],            // Parameter
        ];

        $this->target->set('whatever', $apiSetting);

        $actual = $this->target->all();

        foreach ($actual as $item) {
            $this->assertNotInstanceOf(ApiInterface::class, $item);
        }
    }

    /**
     * @test
     */
    public function shouldReturnPathInstanceWhenSetCorrectSetting()
    {
        $apiSetting = [
            [Path::class, 'create'],    // Callable
            ['GET', '/foo'],            // Parameter
        ];

        $this->target->set('whatever', $apiSetting);
        $actual = $this->target->get('whatever');

        $this->assertInstanceOf(ApiInterface::class, $actual);
    }

    /**
     * @test
     */
    public function shouldReturnPathInstanceWhenSetCorrectSettingUsingResolver()
    {
        $apiSetting = [
            new PathResolver(),         // Resolver
            ['GET', '/foo'],            // Parameter
        ];

        $this->target->set('whatever', $apiSetting);
        $actual = $this->target->get('whatever');

        $this->assertInstanceOf(Path::class, $actual);
    }

    /**
     * @test
     */
    public function shouldReturnEndpointInstanceWhenSetCorrectSettingUsingResolver()
    {
        $apiSetting = [
            new EndpointResolver(),     // Resolver
            ['GET', '/foo'],            // Parameter
        ];

        $this->target->set('whatever', $apiSetting);
        $actual = $this->target->get('whatever');

        $this->assertInstanceOf(Endpoint::class, $actual);
    }

    /**
     * @test
     * @dataProvider invalidSetting
     */
    public function shouldThrowExceptionWhenSetInvalidSetting($invalidSetting)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->target->set('whatever', $invalidSetting);
    }
}
