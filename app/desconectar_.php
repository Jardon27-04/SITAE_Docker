<?php

session_start();
if ($_SESSION['correo']) {
    session_destroy();
    require("login.php");
} else {
require("login.php");
}
?>