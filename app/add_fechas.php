<?php

$fecha_limite = $_POST['fecha_limite'];
 $status = 1;

require("conexion.php");


 

    $update_datos = $mysqli->query("INSERT INTO fecha_limite (fecha_limite,status) VALUES('$fecha_limite','$status')");
    $upd_datos = $mysqli->query("UPDATE talleres SET fecha_limite = '$fecha_limite' WHERE status = '1'");
    if ($update_datos) {
        echo "Actualizacion exitosa.";
        echo '<script>setTimeout(function(){ location.href="panel_admin.php"; }, 1000);</script>';
    }
    
?>
