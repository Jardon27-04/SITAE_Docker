<?php
$num_empleado = $_POST['num_empleado'];
$nombre = $_POST['nombre_c'];
$rol = $_POST['rol'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$password = 1111;
$status = $_POST['status'];
$codigo = "";



require("conexion.php");
 
$consultardato = $mysqli->query("SELECT * FROM docentes WHERE correo = '$correo' OR telefono = '$telefono' OR num_empleado = '$num_empleado'");

if ($consultardato && $consultardato->num_rows > 0) {
    echo "Datos duplicados, registra uno nuevo";
} else {
    
   

    
    $insertar = $mysqli->query("INSERT INTO docentes (id_docente,num_empleado,nombre, rol, telefono, correo, password, status, codigo) 
                                VALUES ('','$num_empleado','$nombre', '$rol', '$telefono', '$correo', '$password', '$status', '$codigo')");

    if ($insertar) {
        echo "El registro tuvo éxito.";
        echo '<script>setTimeout(function(){ location.href="panel_admin.php"; }, 1500);</script>';
         $asunto = "Te damos la Bienvenida";

$carta = "Hola ".$nombre." ya estas registrado(a) en el sistema.\n\n";
$carta .= "Saludos.";
 

mail($correo, $asunto, $carta,);
    } else {
        echo "Ocurrió un error al registrarse.";
    }
}

?>
