<?php

require("conexion.php"); 

$id_alumno = $_POST['id_alumno'];
$nombre_alumno = $_POST['nombre_alumno'];
$curp = $_POST['curp'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$matricula = $_POST['matricula'];

$consulta = $mysqli->query("SELECT nivel, cuatrimestre, grupo, carrera FROM alumno WHERE id_alumno = '$id_alumno'");
$row0 = $consulta->fetch_assoc();

$nivel_actual = $row0['nivel'];
$cuatri_actual = $row0['cuatrimestre'];
$grupo_actual = $row0['grupo'];
$carrera_actual = $row0['carrera'];

$nivel = isset($_POST['nivel']) && $_POST['nivel'] != '' 
? $_POST['nivel'] 
: $nivel_actual;

$cuatrimestre = isset($_POST['cuatrimestre']) && $_POST['cuatrimestre'] != '' 
? $_POST['cuatrimestre'] 
: $cuatri_actual;

$grupo = isset($_POST['grupo']) && $_POST['grupo'] != '' 
? $_POST['grupo'] 
: $grupo_actual;

$carrera = isset($_POST['carrera']) && $_POST['carrera'] != '' 
? $_POST['carrera'] 
: $carrera_actual;

if($cuatrimestre >= 6 AND $nivel == "TSU"){
    echo 'Actualizacion no valida porque estas en 6to o superior';
    echo '<script>setTimeout(function(){ location.href="panel_alumno.php"; }, 1000);</script>';
    exit;
}

if($cuatrimestre <= 5 AND $nivel == "ING/LIC"){
    echo 'Actualizacion no valida porque estas en 5to o inferior';
    echo '<script>setTimeout(function(){ location.href="panel_alumno.php"; }, 1000);</script>';
    exit;
}

$update_datos = $mysqli->query("
UPDATE alumno SET 
nombre_alumno = '$nombre_alumno',
curp = '$curp',
correo = '$correo',
telefono = '$telefono',
matricula = '$matricula',
nivel = '$nivel',
cuatrimestre = '$cuatrimestre',
grupo = '$grupo',
carrera = '$carrera'
WHERE id_alumno = '$id_alumno'
");

if ($update_datos) {
    echo "Actualizacion exitosa.";
    echo '<script>setTimeout(function(){ location.href="panel_alumno.php"; }, 1000);</script>';
} else {
    echo "Error en la actualizacion: " . $mysqli->error;
}
?>