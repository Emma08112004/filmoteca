<?php


class Router
{
    public function route()
    {
        $url = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '/') : '';
        var_dump($url);
    }
}
?>

<?php
require_once 'Router.php';
$router = new Router();
$router->route();
?>
