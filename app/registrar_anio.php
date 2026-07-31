<?php
session_start();
require('conexion.php');

header('Content-Type: application/json');

if (!isset($_POST['anio']) || empty($_POST['anio'])) {
    echo json_encode([
        'status' => 'error',
        'msg' => 'No se recibió el año'
    ]);
    exit;
}

$anio = $_POST['anio'];
$status = 1;

$query = "INSERT INTO anios (anio, status) VALUES ('$anio', '$status')";
$result = $mysqli->query($query);

if (!$result) {
    echo json_encode([
        'status' => 'error',
        'msg' => $mysqli->error
    ]);
    exit;
}

$id_anio = $mysqli->insert_id;

$nuevo_anio = $mysqli->query("SELECT * FROM anios WHERE id_anio = $id_anio")->fetch_assoc();
$_SESSION['anio'] = $nuevo_anio['anio'];

echo json_encode([
    'status' => 'ok',
    'anio' => $_SESSION['anio']
]);
?>