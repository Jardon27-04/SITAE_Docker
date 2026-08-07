<?php

$nombre_alumno = $_POST['nombre_completo'];
$curp = $_POST['curp'];
$matricula = $_POST['matricula'];
$cuatrimestre = $_POST['cuatrimestre'];
$grupo = $_POST['grupo'];
$carrera = $_POST['carrera'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$password = $_POST['password'];
$nivel;
$codigo = "";

require("conexion.php");
 
if ($cuatrimestre <= 6 ) {
   $nivel = "TSU";
}
else {
    $nivel = "ING/LIC";
}
  
    $consultardato = $mysqli->query("SELECT * FROM alumno WHERE curp = '$curp' OR matricula = '$matricula' OR correo = '$correo'");

if ($consultardato && $consultardato->num_rows > 0) {
    echo "Datos duplicados, ingresa nuevos datos";
} else {
    $insertar = $mysqli->query("INSERT INTO alumno (nombre_alumno, curp, matricula, cuatrimestre, grupo, carrera, telefono, correo, password, nivel, codigo,status) 
                                VALUES ('$nombre_alumno', '$curp', '$matricula', '$cuatrimestre', '$grupo', '$carrera','$telefono', '$correo', '$password', '$nivel','$codigo','1')");

    if ($insertar) {
       
        $asunto = "Te damos la Bienvenida";

$carta = "Hola ".$nombre_alumno." ya estas registrado(a) en el sistema.\n\n";
$carta .= "Saludos.";
 

mail($correo, $asunto, $carta,);


        echo "El registro tuvo éxito.";
         echo '<script>setTimeout(function(){ location.href="login.php"; }, 1500);</script>';
    } else {
        echo "Ocurrió un error al registrarse.";
    
}
}

?>
