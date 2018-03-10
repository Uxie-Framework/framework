<?php

$this->get('testGet', function () {
    return true;
});

$this->post('testPost', function () {
    return true;
});

$this->put('testPut', function(){
    return true;
});

$this->patch('testPatch', function() {
    return true;
});

$this->delete('testDelete', function() {
    return true;
});

$this->group('group', function () {
    $this->get('test', function () {
        return true;
    });
});

$this->resource('testResource', 'controller');

$this->get('variables/{$one}/{$two}', function () {
    return true;
});
