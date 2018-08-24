[![Route Logo](https://raw.githubusercontent.com/yolfry/route/master/route.png)](https://github.com/yolfry/route)

[Route](https://github.com/yolfry/route) Control de ruta, para aplicaciones MVC (Modelo – Vista - Controlador).

[![Route Version][Route-image]][Route-url]
[![PHP Version][php-image]][php-url]


## Instalación
```bach
--view
--route
    route.php
    route.web.php
--model
--controller
index.php
.htaccess
```
```php
   /*index.php*/
   <?php
      require 'route.web.php';
   ?>
```

## Inicio rápido

La forma más rápida de comenzar con Route es incluyendo la librería en el index de la aplicación mvc, como se muestra a continuación:

Incluir la librería:
NOTA: El archivo route.web.php, solo es un archivo de configuración y agregación de ruta, puedes cambiarle el nombre o modificarlo.

```php
   /*route.web.php*/
   <?php
      require 'route.php';
      use route as route;
   ?>
```

 Crear instancia de la librería:

```php
    /*route.web.php*/
    $route = new route\route();
```

 Configurar route en el archivo:

```php
    /*route.web.php*/
    <?php
      require 'route.php';
      use route as route;
      $route = new route\route();           /*instancia*/
      $route->ext = ".php";                /*Tipo de extensión*/
      $route->dir_default = "view_/";       /*Carpeta publica (Directorio público).*/
      $route->home_default = "home";        /*Index del directorio publico home, index etc.*/

      /*Activar enrutador home, iniciar el índex de la página (Directorio público).*/
      if ($route->home()) {
      /*code...  Código de ejecución cuando se inicie el enrutador "home"*/
      }
    ?>
```


Crear auto enrutador:

```php
    /*route.web.php*/
    <?php


      #Explicado
      /*require 'route.php';
      use route as route;
      $route = new route\route();
      $route->ext = ".php";
      $route->dir_default = "view_/";
      $route->home_default = "home";

      if ($route->home()) {

      }*/
      #Explicado



       #NOTA: ¿Qué es .htaccess?
       /*Htaccess es la abreviatura de Hypertext Access. Se trata de un archivo de configuración utilizado por servidores web basados en apache. Este tipo de archivos configura los ajustes iniciales de un programa o, como ocurre en este caso, del servidor. Esto significa que se puede utilizar el archivo .htaccess para que el servidor se comporte de una determinada forma. */

       #.htaccess
       #Configurar  .htaccess
       /*
          RewriteEngine On
          RewriteRule ^([a-zA-Z0-9/_]+)$ index.php?view=$1
       */


      /*Auto Route*/
      $url = explode('/', (!empty($_GET['view']) ? $_GET['view'] : ''));  /*Esta variable "$url" contiene pagina1 de la url del cliente   URL -> www.miweb.com/pagina1. */


      if ($route->route_exists("/" . str_replace('.html', '', str_replace('.php', '', str_replace('/', '', $url[0]))) )) { /*Mandamos la variable url a la librería route utilizando el método route_exists().*/
         $route->ext = ".html";       /*Cargamos el tipo de extensión, para completar pagina1.php */
         $route->add_route();         /*Crear y mostrar contenido de la ruta.*/
         $route->end_route();         /*Finalizar enrutador*/
      }

    ?>
```


Crear enrutador estático:

```php
    /*route.web.php*/
    <?php


      #Explicado
      /*require 'route.php';
      use route as route;
      $route = new route\route();
      $route->ext = ".php";
      $route->dir_default = "view_/";
      $route->home_default = "home";

      if ($route->home()) {

      }*/
      #Explicado

       #Enrutador estático
      if ($route->route_exists("/pagina1")) {
        $route->ext = ".php";                       /*Cargamos el tipo de extensión, para completar pagina1.php */
        $route->add_route();                         /*Crear y mostrar contenido de la ruta.*/
        $route->end_route();                         /*Finalizar enrutador*/
      }

    ?>
```


Crear enrutador con datos:

```php
    /*route.web.php*/
    <?php


      #Explicado
      /*require 'route.php';
      use route as route;
      $route = new route\route();
      $route->ext = ".php";
      $route->dir_default = "view_/";
      $route->home_default = "home";

      if ($route->home()) {

      }*/
      #Explicado

       #Enrutador estático
      if ($route->route_exists("/pagina1/{dato1}/{dato2}")) {
        $route->ext = ".php";                       /*Cargamos el tipo de extensión, para completar pagina1.php */
        $route->add_route($route->URL_DATA);         /*Crear y mostrar contenido de la ruta.*/
        $route->end_route();                         /*Finalizar enrutador*/
      }

      /*  Los datos por la url se mandan de la siguiente manera:
          www.miweb.com/pagina1/profile/yolfry,
          Y se recogen por la configuración del enrutador de la siguiente manera:
          $route->route_exists("/pagina1/{dato1}/{dato2}");
          Para mandar esos datos al contenido de la página web, tenemos que utilizar la propiedad $route->URL_DATA y pasarla por el método $route->add_route($route->URL_DATA).
          Para utilizar los datos en la página en rutada, en este caso pagina1.php que se encuentra en el directorio público "view",
          Utilizamos la variable array $_URL_GET[''], ej. <?php echo $_URL_GET['dato1'] .' '. $_URL_GET['dato2']; ?>.  Devuelve  profile yolfry.
     */

    ?>
```

Crear pagina de error
```php
    /*route.web.php*/
    <?php


      #Explicado
      /*require 'route.php';
      use route as route;
      $route = new route\route();
      $route->ext = ".php";
      $route->dir_default = "view_/";
      $route->home_default = "home";

      if ($route->home()) {

      }*/

      /* Enrutador estático
      if ($route->route_exists("/pagina1/{dato1}/{dato2}")) {
        $route->ext = ".php";
        $route->add_route($route->URL_DATA);
        $route->end_route();
      }*/



       /*Esta página de error 404 se muestra en caso de que no se encuentre la página solicitada por la url del cliente ej. www.miweb.com/pagina3
       Si la pagina3.html no se encuentra $route->active_route devuelve falso, el cual podemos aprovechar y establecer una condición e incluir una página de error como se muestra a continuación.
       */
      if ($route->active_route != true) {
         require_once 'view_/404.html';
      }

      /*Esta condición siempre se coloca al final de la configuración del enrutador.*/




    ?>
}
```

**©2018 YOLFRY BAUTISTA REYNOSO | YOLFRI1997@HOTMAIL.COM**
LICENCIA GPL V3


[Route-image]: https://img.shields.io/badge/Route%20Vercion-1.0.0-04265e.svg
[Route-url]: https://github.com/yolfry/route
[php-image]: https://img.shields.io/badge/Php%20Versión-7.X-8F9ED1.svg
[php-url]: http://php.net/archive/2018.php#id2018-08-17-1

