<?php

require_once __DIR__ . '/vendor/autoload';

$app = new Application();

$app->router->get('/', function (){
    return 'Hello world';
});

$app->run();