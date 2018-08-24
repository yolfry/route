<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perfil</title>
    <style>
     header{
        color:white;
        padding:10px;
        background-color:rgb(18, 22, 27);
        border-left:4px solid black;
     }
     header a{
        text-decoration:none;
        font-size:20px;
        color:white;
        padding:10px;
     }
    </style>
</head>
<body>
    <header>
       <h1><?php echo $_URL_GET['user']; ?></h1>
       <a href="/home">Salir del perfil</a>
    </header>

    <img src="<?php echo  "http://".$_SERVER['SERVER_NAME']."/view/document/". (!empty($_URL_GET['profile_img'])?$_URL_GET['profile_img']:'default') .'.jpg';?>" alt="Foto de perfil" width="150px">
</body>
</html>