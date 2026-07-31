<?php

$mysqli = new mysqli(
    "mysql",
    "admin",
    "admin123",
    "tecnol64_talleres2026V2"
);

$mysqli->set_charset("utf8");

if ($mysqli->connect_errno) {
    echo "Error al conectar con la base de datos: (" . 
    $mysqli->connect_errno . ") " . 
    $mysqli->connect_error;
}

?>