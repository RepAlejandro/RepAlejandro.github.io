<?php

$servername = "db"; // Cambiado a "db" según el nombre del servicio en docker-compose.yml
$username = "mariadb"; // Usuario definido en las variables de entorno en docker-compose.yml
$password = "mariadb"; // Contraseña definida en las variables de entorno en docker-compose.yml
$database = "mariadb"; // Base de datos definida en las variables de entorno en docker-compose.yml

$conexion=mysqli_connect($servername, $username, $password, $database);

if(!$conexion){
    die ("Conexión fallida");
}

?>
