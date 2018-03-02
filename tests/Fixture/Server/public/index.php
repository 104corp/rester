<?php

use Slim\Http\Request;
use Slim\Http\Response;

require_once __DIR__ . '/../../../../vendor/autoload.php';

function build_response(Request $request)
{
    return (new Response())->withJson([
        'headers' => $request->getHeaders(),
        'query' => $request->getQueryParams(),
        'json' => $request->getParsedBody(),
    ]);
}

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ],
]);

$app->get('/foo', function (Request $request) {
    return build_response($request);
});

$app->post('/foo', function (Request $request) {
    return build_response($request);
});

$app->put('/foo', function (Request $request) {
    return build_response($request);
});

$app->patch('/foo', function (Request $request) {
    return build_response($request);
});

$app->delete('/foo', function (Request $request) {
    return build_response($request);
});

$app->run();
