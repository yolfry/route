<?php 

require_once 'route/route.php';
use route as route;


$route = new route\route();

/*Configurar ruta home*/
$route->ext = ".php";
$route->dir_default = "view/";
$route->home_default = "home";

/*Cargar pagina index*/
$route->home();



#Auto Route    /user   =  $_GET['view']  == RewriteRule ^([a-zA-Z0-9/_]+)$ index.php?view=$1
$url = explode('/', (!empty($_GET['view']) ? $_GET['view'] : ''));
if ($route->route_exists("/" . str_replace('.html', '', str_replace('.php', '', str_replace('/', '', $url[0]))) . "/{user}/{profile_img}")) {

    $route->ext = ".php";
    $route->add_route($route->URL_DATA/*$_URL_GET*/); #Agrega la pagina web y le manda los datos requeridos /{id}/{name}  
    $route->end_route();

}


#Pagina de error
if ($route->active_route != true) {
    require_once 'view/404.html';
}




?>