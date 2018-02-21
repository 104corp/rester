<?php

use Psr\Http\Message\ServerRequestInterface;

require_once __DIR__ . '/../../../../vendor/autoload.php';

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

config(['app.debug' => true]);

function build_response(ServerRequestInterface $request)
{
    return response()->json([
        'headers' => $request->getHeaders(),
        'query' => $request->getQueryParams(),
        'json' => $request->getParsedBody(),
    ]);
}

$app->router->get('/foo', function (ServerRequestInterface $request) {
    return build_response($request);
});

$app->router->post('/foo', function (ServerRequestInterface $request) {
    return build_response($request);
});

$app->router->put('/foo', function (ServerRequestInterface $request) {
    return build_response($request);
});

$app->router->patch('/foo', function (ServerRequestInterface $request) {
    return build_response($request);
});

$app->router->delete('/foo', function (ServerRequestInterface $request) {
    return build_response($request);
});

$app->run();
