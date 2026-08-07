<?php

//$host = getenv('DB_HOST') ?: 'mysql';
$host = "sql202.infinityfree.com";
$user = getenv('DB_USER') ?: 'admin';
$pass = getenv('DB_PASS') ?: 'admin123';
$db   = getenv('DB_NAME') ?: 'tecnol64_talleres2026V2';
$port = getenv('DB_PORT') ?: '3306';

$mysqli = new mysqli($host, $user, $pass, $db, $port);

$mysqli->set_charset("utf8");

if ($mysqli->connect_errno) {
    die("Error al conectar con la base de datos: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error);
}

?>