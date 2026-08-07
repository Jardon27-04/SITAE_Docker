<?php

$fecha_limite = $_POST['fecha_limite'];
 $status = 1;

require("conexion.php");


 

    $update_datos = $mysqli->query("INSERT INTO limite (fecha_limite,status) 
    VALUES('$fecha_limite','$status')");   

    $upd_datos = $mysqli->query("UPDATE talleres SET limite_liberacion = '$fecha_limite' WHERE status = '1'");
    
  $upd_datos2 = $mysqli->query("UPDATE talleres SET limite_liberacion = '$fecha_limite' WHERE status = '1' AND limite_liberacion IS NULL");  
    if ($update_datos) {
        echo "Actualizacion exitosa.";
        echo '<script>setTimeout(function(){ location.href="panel_admin.php"; }, 1000);</script>';
    }
    
?>
