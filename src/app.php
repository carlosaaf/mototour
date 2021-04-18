<?php

namespace Mototour;

require __DIR__ . '/util/config.php';
require __DIR__ . '/util/router.php';
require __DIR__ . '/model/tour_repository.php';
require __DIR__ . '/controller/page_controller.php';
require __DIR__ . '/controller/home_controller.php';
require __DIR__ . '/controller/tour_controller.php';

use Closure;
use Mototour\Util\Router;

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';
$router = new Router($method, $path);

$router->get('/', 'Mototour\\Controler\\HomeController::hello');

$router->get('/tours', 'Mototour\\Controler\\TourController::list');
$router->get('/tours/add', 'Mototour\\Controler\\TourController::edit');
$router->get('/tours/{id}', 'Mototour\\Controler\\TourController::show');
$router->get('/tours/{id}/edit', 'Mototour\\Controler\\TourController::edit');
$router->post('/tours/save', 'Mototour\\Controler\\TourController::save');
$router->get('/tours/{id}/delete', 'Mototour\\Controler\\TourController::delete');

$result = $router->handler();

if (!$result) {
    http_response_code(404);
    echo 'Página não encontrada!';
    die();
}

if ($result instanceof Closure) {
    echo $result($router->getParams());
} elseif (is_string($result)) {
    $result = explode('::', $result);
    $controller = new $result[0];
    $action = $result[1];
    echo $controller->$action($router->getParams());
}