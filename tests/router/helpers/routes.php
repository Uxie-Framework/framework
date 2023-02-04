<?php

$route->get('testGet', function () {
    return true;
});

$route->post('testPost', function () {
    return true;
});

$route->put('testPut', function ($req, $res) {
    return true;
});

$route->patch('testPatch', function () {
    return true;
});

$route->delete('testDelete', function () {
    return true;
});

$route->group('group', function ($route) {
    $route->get('test', function () {
        return true;
    });
});

$route->resource('testResource', 'controller');

$route->get('variables/{$one}/{$two}', function () {
    return true;
});

$route->get('testMiddleware', function () {
    return true;
})->middleware('test');

$route->get('testLateMiddleware', function () {
    return true;
})->middleware('test', true);
