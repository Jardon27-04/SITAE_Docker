<?php

session_start();
if ($_SESSION['correo']) {
    session_destroy();
    require("login_alumno.php");
} else {
require("login_alumno.php");
}
?>