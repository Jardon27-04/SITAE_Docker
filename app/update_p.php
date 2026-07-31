<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = trim($_POST['id']);
$password = trim($_POST['password']);
$tipo = trim($_POST['tipo']);

require("conexion.php");

if ($tipo == "docente") {

    $update_pass = $mysqli->query("UPDATE docentes SET password = '$password' WHERE id_docente = '$id'");

    if ($update_pass) {
        echo "Actualizacion exitosa.";
        echo '<script>setTimeout(function(){ location.href="login.php"; },1500);</script>';
    }

} elseif ($tipo == "alumno") {

    $update_pass = $mysqli->query("UPDATE alumno SET password = '$password' WHERE id_alumno = '$id'");

    if ($update_pass) {
        echo "Actualizacion exitosa.";
        echo '<script>setTimeout(function(){ location.href="login.php"; },1500);</script>';
    }

} else {

    echo "Usuario no encontrado.";
    echo '<script>setTimeout(function(){ location.href="login.php"; },1500);</script>';
}
?>