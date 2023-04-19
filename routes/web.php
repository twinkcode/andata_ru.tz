<?php

use App\Controllers\HomeController;
use App\Controllers\CommentController;

$router->get('/', HomeController::class . '@index');

$router->get('/comments', CommentController::class . '@index');

$router->post('/comments', CommentController::class . '@create');
