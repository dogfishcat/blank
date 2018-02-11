<?php declare(strict_types = 1);

error_reporting(E_ALL);

require ROOT . '/vendor/autoload.php';

$environment = 'development';

$whoops = new \Whoops\Run;

if ($environment !== 'production') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
}
else {
    $whoops->pushHandler(function ($e) {
        echo 'TODO: Friendly error page and send an email?';
    });
}

$whoops->register();

include 'routes.php';

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $class = new $routeInfo[1][0]();
        $class->{$routeInfo[1][1]}($routeInfo[2]);
        break;
}