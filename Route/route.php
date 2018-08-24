<?php namespace route;


//Route (C)2018 Yolfry Bautista Reynsoso -> yolfri1997@hotmail.com
//Esta libreria te permite controlar las rutas de una aplicaión web [[APPWEB]] o plataforma web
class route
{
    #Propiedades de las rutas
    public $validate_route; #propiedad que contiene la validación de la ruta
    public $url_server;     #propiedad que contiene la url del cliente servidor
    public $URL_DATA;       #propiedad que contiene la url del data class
    public $dir_default;    #propiedad que contiene el directorio vista publica
    public $home_default;   #propiedad que contiene el archivo home de la web
    public $ext;            #propiedad que contiene la extención del archivo home de la web
    public $active_route;   #propiedad que contiene la activación global de una ruta, el uso correcto es para mostrar  un error 404



    public function __construct()
    {
        $this->dir_default = 'view_/';
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
                         $this->URL_DATA = $data;
                }
            }
        }
        #Validamos la ruta del view o public
        $this->url_server = str_replace('/','', $this->url_server);
        if (file_exists($this->dir_default . $this->url_server . '' . $this->ext)) {
            $this->validate_route = true;
            return true;
        } else {
            $this->validate_route = false;
            $this->validate_route = null;
            $this->url_server = null;
            $this->URL_DATA = null;
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
            array('n', 'N', 'c', 'C', ),
            $data
        );
        return $data;
    }
    public function add_route($_URL_GET="")
    {
        #Agregar Ruta
        if ($this->validate_route == true) {
            if (include_once $this->dir_default . $this->url_server . '' . $this->ext) {
                $this->active_route = true;
                return true;
            } else {
                $this->validate_route = null;
                $this->url_server = null;
                $this->URL_DATA = null;
                return false;
            }
        }
    }
    #Activar Home
    public function home($active = null)
    {
        if ($_SERVER["REQUEST_URI"] == '/') {
            include_once $this->dir_default . $this->home_default . $this->ext; #Agregar el directorio por defecto
            $this->active_route = true;
            return true;
        } else {
            return false;
        }
    }
    public function end_route()
    {
        #Finalizar Class Route
        $this->validate_route = null;
        $this->url_server = null;
        unset($this);
    }


}


?>