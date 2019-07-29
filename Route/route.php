<?php

namespace route;


//Route (C)2018 Yolfry Bautista Reynsoso -> yolfri1997@hotmail.com
//Esta libreria te permite controlar las rutas de una aplicaión web [[APPWEB]] o plataforma web
class route
{
    #Propiedades de las rutas
    public $validate_route; #propiedad que contiene la validación de la ruta
    public $url_server;     #propiedad que contiene la url del cliente servidor
    public $GET;       #propiedad que contiene la url del data class
    public $dir_default;    #propiedad que contiene el directorio vista publica
    public $home_default;   #propiedad que contiene el archivo home de la web
    public $ext;            #propiedad que contiene la extención del archivo home de la web
    public $active_route;   #propiedad que contiene la activación global de una ruta, el uso correcto es para mostrar  un error 404
    public $var;            #propiedad que contiene las variables de entorno html definidas
    public $ERROR404;       #propiedad que contiene la pagina error 404





    public function __construct()
    {
        $this->dir_default = 'views/';
        $this->home_default = 'home';
        $this->ext = ".html";
    }

    /*Validar ruta*/
    public function route_exists($url = '/home')
    {
        #Eliminar las rutas con .HTML y .PHP y limpiar ruta
        $this->url_server = str_replace('.html', '', str_replace('.php', '', stripslashes(htmlspecialchars(strip_tags($_SERVER["REQUEST_URI"])))));
        $this->url_server = self::segurity($this->url_server);

        /*Quitar variables get de la url del servidor*/
        $get_string_url_server = '';
        $url_server = $this->url_server;
        $c = false;

        for ($i = 0; $i < strlen($url_server); $i++) {

            if ($url_server[$i] == '?') {
                $c = true;
            }

            if ($url_server[$i] == '/') {
                $c = false;
            }

            if ($c == true) {
                $get_string_url_server .= $url_server[$i];
            }
        }

        #Elminar variables por get
        $this->url_server = str_replace($get_string_url_server, '', $url_server);


        #Box ruta, caracter {} de indentificador de datos por la ruta
        $box_string = '{';

        #Buscar indentificador de datos por la ruta
        $pos = strpos($url, $box_string);

        #si se  encuentran indentificador de  datos, ejecutamos el script de captura de datos.
        if ($pos !== false) {

            #separamos las rutas locales
            $url_local = explode('/', $url);

            #separamos las rutas cliente servidor
            $url_server_se = explode('/', $this->url_server);

            #creamos un array de datos
            $data = array();

            #for para validar y capturar datos mediante la URL data
            for ($i = 1; $i < count($url_local); $i++) {

                #Box ruta, caracter {} de indentificador de datos por la ruta
                $box_string = '{';

                #Buscar indentificador de datos por la ruta indicada por el separador
                $pos = strpos($url_local[$i], $box_string);

                #validamos el encuentro de datos
                if ($pos !== false && !empty($url_local[$i]) && !empty($url_server_se[$i])) {

                    #Agregamos un array['name'] para los datos encontrado
                    $name_item = str_replace('{', '', str_replace('}', '', str_replace('/', '', $url_local[$i])));
                    #Capturamos los datos
                    $data_item = str_replace('/', '', $url_server_se[$i]);


                    #Agregamos un Item de datos
                    $data['' . $name_item] = $data_item;

                    #Eliminamos la URL de datos y cargamos la nueva URL
                    $this->url_server = str_replace('/' . $url_server_se[$i], '', $this->url_server);

                    #Agregamos los datos a la propiedad  "data" de la clase de ruta
                    $this->GET = $data;
                }
            }
        }
        #Validamos la ruta del view o public
        $this->url_server = str_replace('/', '', $this->url_server);
        if (file_exists($this->dir_default . $this->url_server . '' . $this->ext)) {
            $this->validate_route = true;
            return true;
        } else {
            $this->validate_route = false;
            $this->validate_route = null;
            $this->url_server = null;
            $this->GET = null;
            return false;
        }
    }

    #Script para asegurar el flujo de rutas
    public function segurity($data = "")
    {
        $data = trim($data);
        $data = strip_tags($data);
        $data = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $data
        );
        $data = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $data
        );
        $data = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $data
        );
        $data = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $data
        );
        $data = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $data
        );
        $data = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $data
        );
        return $data;
    }
    public function add_route($GET = "")
    {
        #Agregar Ruta
        if ($this->validate_route == true) {


            if (file_exists($this->dir_default . $this->url_server . '' . $this->ext)) {

                /*Tomar el contenido de la plantilla html*/
                $conteiner = file_get_contents($this->dir_default . $this->url_server . '' . $this->ext);

                /*Recuperar Variables*/
                $var = $this->var;

                /*Evaluamos si hay variables de entorno creada $var[]*/
                if ($var != null) {
                    /*Montar esos datos como variable de entorno {GET} en html*/
                    while ($data_name = current($var)) {
                        $st = "{" . key($var) . "}";
                        $conteiner = str_replace($st, $data_name, $conteiner);
                        next($var);
                    }
                }


                /*Recuperamos los datos GET*/
                $data = $this->GET;

                /*Evaluar si hay datos GET*/
                if ($data != null) {
                    /*Montar esos datos como variable de entorno {GET} en html*/
                    while ($data_name = current($data)) {
                        $st = "{" . key($data) . "}";
                        $conteiner = str_replace($st, $data_name, $conteiner);
                        next($data);
                    }
                }

                echo $conteiner; /*Mostramos la plantilla*/

                $this->active_route = true;
                return true;
            } else {
                $this->validate_route = null;
                $this->url_server = null;
                $this->GET = null;
                return false;
            }
        }
    }
    #Activar Home
    public function home($active = null)
    {
        if ($_SERVER["REQUEST_URI"] == '/') {
            #Agregar el directorio por defecto

            if (file_exists($this->dir_default . $this->home_default . $this->ext)) {
                /*Tomar el contenido de la plantilla html*/
                $conteiner = file_get_contents($this->dir_default . $this->home_default . $this->ext);

                /*Recuperar Variables*/
                $var = $this->var;

                /*Evaluamos si hay variables de entorno creada $var[]*/
                if ($var != null) {
                    /*Montar esos datos como variable de entorno {GET} en html*/
                    while ($data_name = current($var)) {
                        $st = "{" . key($var) . "}";
                        $conteiner = str_replace($st, $data_name, $conteiner);
                        next($var);
                    }
                }

                echo $conteiner; /*Mostramos la plantilla*/

                $this->active_route = true;
                return true;
            } else {
                echo " Error, the applied directory cannot be found.";
            }
        } else {
            return false;
        }
    }

    /*Modulo, Cargar ruta directa*/
    public function load($file)
    {
        if (file_exists($file)) {
            $conteiner = file_get_contents($file);

            /*Recuperar Variables*/
            $var = $this->var;

            /*Evaluamos si hay variables de entorno creada $var[]*/
            if ($var != null) {
                /*Montar esos datos como variable de entorno {GET} en html*/
                while ($data_name = current($var)) {
                    $st = "{" . key($var) . "}";
                    $conteiner = str_replace($st, $data_name, $conteiner);
                    next($var);
                }
            }

            echo $conteiner; /*Mostramos la plantilla*/
        } else {
            echo "Error, the applied directory cannot be found.";
        }
    }
    /*Metodo de carga de pagina 404*/
    public function ERROR404()
    {
        if (file_exists($this->dir_default . $this->ERROR404)) {
            $conteiner = file_get_contents($this->dir_default . $this->ERROR404);

            /*Recuperar Variables*/
            $var = $this->var;

            /*Evaluamos si hay variables de entorno creada $var[]*/
            if ($var != null) {
                /*Montar esos datos como variable de entorno {GET} en html*/
                while ($data_name = current($var)) {
                    $st = "{" . key($var) . "}";
                    $conteiner = str_replace($st, $data_name, $conteiner);
                    next($var);
                }
            }

            echo $conteiner; /*Mostramos la plantilla*/
            $this->active_route = false;
        } else {
            echo "Error, the applied directory cannot be found.";
        }
    }


    public function end_route()
    {
        #Finalizar Class Route
        $this->validate_route = null;
        $this->url_server = null;
    }
}
