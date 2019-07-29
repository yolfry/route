<?php 

/*Instalar clase route*/
require 'route/route.php';
use route as route;

$route = new route\route();

/*
---------------------------------
Espesificar Directorio de Inicio
---------------------------------
*/

$route->ext = ".html";
$route->dir_default = "views/";
$route->home_default = "home";

/*
---------------------------------
Espesificar Pagina de error 404 de la siguiente manera
---------------------------------
*/
$route->ERROR404 = "page-404.html";




/*
--------------------------------------
Crear variable para entorno Html {var}
--------------------------------------
*/


/*RUTA: NOMBRE DE LA VARIABLE*/
/*http://localhost: CONTENIDO DE LA VARIABLE*/
$var['RUTA'] = "http://localhost";
$var['RUTA_'] = $var['RUTA'] . "/views";
$route->var = $var;


/*
-------------------
Cargar pagina index, init Route
-------------------
*/

$route->home();


/* 
--------------
AUTO ENRUTADOR
--------------
*/

#Auto Route    /user   =  $_GET['view']  == RewriteRule ^([a-zA-Z0-9/_]+)$ index.php?view=$1
$url = explode('/', (!empty($_GET['view']) ? $_GET['view'] : ''));
if ($route->route_exists("/" . str_replace('.html', '', str_replace('.php', '', str_replace('/', '', $url[0]))) . "/{user}/{profile_img}")) {

    $route->ext = ".html";
    $route->add_route($route->GET/*$GET*/); #Agrega la pagina web y le manda los datos requeridos /{id}/{name}  
    $route->end_route();

}


/*
-----------------------------------------------------------
Pagina de error 404 no se encontro la página que busca.
-----------------------------------------------------------
*/

if ($route->active_route != true) {
    /*Mostrar página de error 404*/
    $route->ERROR404();
}


/*
-----------------------------------------------------------
Carga directa.
-----------------------------------------------------------
*/

#$route->load("views/login.html");
