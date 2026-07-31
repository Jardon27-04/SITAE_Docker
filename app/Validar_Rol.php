<?php


session_start();

require("conexion.php");

$rol = $_SESSION['rol'];
if ($rol == "1") {
    echo "<script>location.href='panel_admin.php'</script>";

}
$rol = $_SESSION['rol'];
if ($rol == "2")
    
    echo "<script>location.href='panel_docente.php'</script>";

$rol = $_SESSION['rol'];
if ($rol == "3") {
    echo "<script>location.href='panel_admin.php'</script>";

}

?>