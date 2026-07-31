<?php
session_start();
require("conexion.php");

header('Content-Type: application/json');

$id_inscripcion = (int) $_POST['id_inscripcion'];

$hoy = date("Y-m-d");

$noliberado = false;

$buscar_fecha = $mysqli->query("
SELECT t.limite_liberacion
FROM talleres t
INNER JOIN inscripciones i ON i.id_taller = t.id_taller
WHERE i.id_inscripcion = $id_inscripcion
");

$fecha = $buscar_fecha->fetch_assoc();
$limite_fecha = $fecha['limite_liberacion'];

if ($hoy > $limite_fecha) {

    echo json_encode([
        'noliberado' => true
    ]);
    exit;
}

$status = 1;

$mysqli->query("
UPDATE inscripciones 
SET status_liberado = 1
WHERE id_inscripcion = $id_inscripcion
");

echo json_encode([
    'noliberado' => false
]);