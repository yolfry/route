<?php

require 'route.php';
use route as route;

$route = new route\route();
$route->ext = ".html";
$route->dir_default = "view_/";
$route->home_default = "home";

#Activar ruta  Home
if ($route->home()) {
    /*code...*/
}



#Auto Route
$url = explode('/', (!empty($_GET['view']) ? $_GET['view'] : ''));
if ($route->route_exists("/" . str_replace('.html', '', str_replace('.php', '', str_replace('/', '', $url[0]))) . "/{key}")) {
    $route->ext = ".html";
    $route->add_route($route->URL_DATA); #Agrega la pagina web y le manda los datos requeridos /{id}/{name}  $_URL_GET
    $route->end_route();
}


if ($route->active_route != true) {
    require_once 'view_/404.html';
}


#routes stat
/*if ($route->route_exists("/customer_service/{id_user}")) {
    $route->ext = ".html";
    $route->add_route($route->URL_DATA);
    $route->end_route();
}*/


?>