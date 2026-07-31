<?php

$id_alumno = $_POST['id_alumno'];
$nombre_alumno = $_POST['nombre_alumno'];
$curp = $_POST['curp'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];


require("conexion.php");

$buscaalumno = $mysqli->query("SELECT * FROM alumno WHERE id_alumno = '$id_alumno'");

if ($buscaalumno) {

    $update_datos = $mysqli->query("UPDATE alumno SET nombre_alumno = '$nombre_alumno', curp = '$curp', correo = '$correo', telefono = '$telefono' WHERE id_alumno = '$id_alumno'");
    
    if ($update_datos) {
        echo "Actualizacion exitosa.";
        echo '<script>setTimeout(function(){ location.href="panel_admin.php"; }, 1000);</script>';
    }
    }
?>
