```php
<?php

/*
|--------------------------------------------------------------------------
| CONEXIÓN A BASE DE DATOS
|--------------------------------------------------------------------------
| LOCAL - DOCKER:
|   Se conecta al servicio "mysql" definido en docker-compose.yml.
|
| RENDER:
|   Utiliza las variables de entorno configuradas en Render.
|--------------------------------------------------------------------------
*/


if (getenv('DB_HOST')) {

    // ==========================================
    // RENDER
    // ==========================================

    $host = getenv('DB_HOST');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');
    $db   = getenv('DB_NAME');
    $port = getenv('DB_PORT') ?: '3306';

} else {

    // ==========================================
    // LOCAL - DOCKER
    // ==========================================

    $host = 'mysql';

    // Estos valores vienen de tu .env de Docker
    $user = getenv('MYSQL_USER') ?: 'root';
    $pass = getenv('MYSQL_PASSWORD') ?: getenv('MYSQL_ROOT_PASSWORD');
    $db   = getenv('MYSQL_DATABASE') ?: 'sitae';

    $port = '3306';
}


// ==========================================
// CREAR CONEXIÓN
// ==========================================

$mysqli = new mysqli(
    $host,
    $user,
    $pass,
    $db,
    $port
);


// ==========================================
// VERIFICAR CONEXIÓN
// ==========================================

if ($mysqli->connect_errno) {

    die(
        "Error al conectar con la base de datos: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error
    );

}


// ==========================================
// UTF-8
// ==========================================

$mysqli->set_charset("utf8");

?>
```
