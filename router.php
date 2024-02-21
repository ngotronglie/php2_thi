<?php
use Bramus\Router\Router;
use Ngotr\Thithu1\Controllers\GiangvienController;

$router = new Router();

// Define routes // định nghĩa đường dẫn
// ...
$router->mount('/teacher', function () use ($router) {
    $router->get('/', GiangvienController::class . '@index');
    $router->get('/{id}/show', GiangvienController::class . '@show');
    $router->match('GET|POST', '/{id}/update', GiangvienController::class . '@update');
    $router->match('GET|POST', '/add', GiangvienController::class . '@add');
    $router->match('GET|POST', '/{id}/delete', GiangvienController::class . '@delete');
});

// Run it!
$router->run();