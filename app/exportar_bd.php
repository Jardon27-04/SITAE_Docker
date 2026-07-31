<?php 
require('conexion.php');

 
$actualizar_talleres = $mysqli->query("UPDATE talleres SET status = '1' WHERE periodo = '2'");

$actualizar_insc = $mysqli->query("UPDATE inscripciones i JOIN talleres t ON i.id_taller = t.id_taller SET i.status = '1' WHERE t.periodo = '2'");

$actualizar_cuatrimestre = $mysqli->query("UPDATE alumno a JOIN cuatrimestre c_new ON c_new.id_cuatrimestre = a.cuatrimestre - 1 SET a.cuatrimestre = a.cuatrimestre - '1' WHERE a.status = '1'");

$actualizar_periodo = $mysqli->query("UPDATE periodo SET status = '1' WHERE id_periodo = '2'");

$actualizar_pe = $mysqli->query("UPDATE periodo SET status = '2' WHERE id_periodo = '1'");

$actualizar_p = $mysqli->query("UPDATE periodo SET status = '2' WHERE id_periodo = '3'");


echo '<script>setTimeout(function(){ location.href="panel_admin.php"; }, 1800);</script>';

?> 



