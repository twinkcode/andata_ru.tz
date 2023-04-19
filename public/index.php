<?php
/**
 * Entry point for the application.
 * Initializes the autoloader and the router.
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Router.php';

use App\Router;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST)) {
    $_POST = json_decode(file_get_contents('php://input'), true);
}

$router = new Router();
require_once __DIR__ . '/../routes/web.php';
$router->handle($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
