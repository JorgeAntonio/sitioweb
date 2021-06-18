<?php

$host = "localhost";
$bd = "sitioweb";
$usuario = "root";
$contrasena = "";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasena);
} catch (PDOException $exception) {
    echo "Error: " . $exception->getMessage();
}