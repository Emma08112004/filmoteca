<?php

declare(strict_types=1); 

require __DIR__ . '/../vendor/autoload.php'; 

use App\Core\Router; 
$router = new Router(); 
$router->route(); 