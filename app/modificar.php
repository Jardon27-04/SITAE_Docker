<?php
session_start();
require('conexion.php');

$reiniciado = false;

$actual = $mysqli->query("SELECT id_periodo FROM periodo WHERE status = 1")->fetch_assoc();

if (!$actual) {
    $mysqli->query("UPDATE periodo SET status = 1 ORDER BY id_periodo ASC LIMIT 1");
} else {
    $id_actual = $actual['id_periodo'];
    $siguiente = $mysqli->query("SELECT id_periodo FROM periodo WHERE id_periodo > $id_actual ORDER BY id_periodo ASC LIMIT 1")->fetch_assoc();
        $act_c = $mysqli->query("UPDATE alumno a JOIN cuatrimestre c_new ON c_new.id_cuatrimestre = a.cuatrimestre + 1  SET a.cuatrimestre = a.cuatrimestre + 1 WHERE a.status = 1");


        $act_n = $mysqli->query("UPDATE alumno SET nivel = 'ING/LIC' WHERE cuatrimestre >= 6 AND nivel = 'TSU'");
    if ($siguiente) {
        $id_siguiente = $siguiente['id_periodo'];
        $mysqli->query("UPDATE periodo SET status = 1 WHERE id_periodo = $id_siguiente");
        $mysqli->query("UPDATE periodo SET status = 2 WHERE id_periodo != $id_siguiente");

       // $mysqli->query("UPDATE alumno SET cuatrimestre = cuatrimestre + 1");

       // $mysqli->query("UPDATE alumno SET nivel = 'ING/LIC' WHERE cuatrimestre >= 5 AND nivel = 'TSU'");

    } else {
        $mysqli->query("UPDATE periodo SET status = 1 ORDER BY id_periodo ASC LIMIT 1");
        $primero = $mysqli->query("SELECT id_periodo FROM periodo ORDER BY id_periodo ASC LIMIT 1")->fetch_assoc()['id_periodo'];
        $mysqli->query("UPDATE periodo SET status = 2 WHERE id_periodo != $primero");

        $mysqli->query("UPDATE anios SET status = 2");
        $reiniciado = true;

       // $mysqli->query("UPDATE alumno SET cuatrimestre = cuatrimestre + 1");

       // $mysqli->query("UPDATE alumno SET nivel = 'ING/LIC' WHERE cuatrimestre >= 5 AND nivel = 'TSU'");
    }

    $mysqli->query("UPDATE talleres SET status = 2");
    $mysqli->query("UPDATE inscripciones SET status = 2");
     $mysqli->query("UPDATE fecha_limite SET status = 2");
     $mysqli->query("UPDATE limite SET status = 2");
}

$periodoActivo = $mysqli->query("SELECT nombre_p FROM periodo WHERE status = 1 LIMIT 1");

if ($periodoActivo && $periodoActivo->num_rows > 0) {
    $rowPeriodo = $periodoActivo->fetch_assoc();
    $_SESSION['nombre_p'] = $rowPeriodo['nombre_p'];
}

$nuevo_anio = $mysqli->query("SELECT anio FROM anios WHERE status = 1 LIMIT 1");

if ($nuevo_anio && $nuevo_anio->num_rows > 0) {
    $rowAnio = $nuevo_anio->fetch_assoc();
    $_SESSION['anio'] = $rowAnio['anio'];
}


$actualiza_status = $mysqli->query("UPDATE alumno SET status = 2 WHERE cuatrimestre = 11");
//$actualiza_matricula = $mysqli->query("UPDATE alumno SET matricula = ''");


echo json_encode([
    'status' => 'ok',
    'nombre_p' => $_SESSION['nombre_p'],
    'anio' => $_SESSION['anio'],
    'reiniciado' => $reiniciado]);
?>
