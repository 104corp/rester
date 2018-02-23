<?php

namespace Tests\Fixture\Server;

/**
 * @see https://github.com/kitetail/zttp/blob/master/tests/ZttpTest.php
 */
class Server
{
    /**
     * @var string
     */
    public static $baseUrl;

    public static function start()
    {
        $port = env('TEST_SERVER_PORT', 8888);

        static::$baseUrl = "http://localhost:{$port}";

        $pid = exec("php -S localhost:{$port} -t ./tests/Fixture/Server/public > /dev/null 2>&1 & echo $!");

        while (@file_get_contents("http://localhost:{$port}/foo") === false) {
            usleep(1000);
        }

        register_shutdown_function(function () use ($pid) {
            exec("kill {$pid}");
        });
    }
}
