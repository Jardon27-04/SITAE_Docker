<?php

$id_docente = $_POST['id_docente'];
$num_empleado = $_POST['num_empleado'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];


require("conexion.php");



    $update_datos = $mysqli->query("UPDATE docentes SET num_empleado = '$num_empleado', nombre = '$nombre', telefono = '$telefono', correo = '$correo' WHERE id_docente = '$id_docente'");
    
    if ($update_datos) {
        echo "Actualizacion exitosa.";
        echo '<script>setTimeout(function(){ location.href="panel_admin.php"; }, 1000);</script>';
    }
   
?>
