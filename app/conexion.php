<?php

$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$db   = getenv('DB_NAME') ?: 'railway';
$port = getenv('DB_PORT') ?: '3306';


$mysqli = new mysqli($host, $user, $pass, $db, $port);


if ($mysqli->connect_errno) {
    die("Error al conectar con la base de datos: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error);
}


$mysqli->set_charset("utf8");

?>