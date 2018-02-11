<?php declare(strict_types = 1);

$dispatcher = FastRoute\cachedDispatcher(function(FastRoute\RouteCollector $router) {

    $router->addRoute('GET', '/', ['App\Controllers\Frontend\Guest\LoginController', 'getView']);

}, [ 'cacheFile' => ROOT . '/storage/cache/route.cache', 'cacheDisabled' => false, ]);