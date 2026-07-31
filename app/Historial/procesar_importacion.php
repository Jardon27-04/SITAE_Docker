<?php
require '../vendor/autoload.php';
require '../conexion.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {

$archivo = $_FILES['archivo']['tmp_name'];

$spreadsheet = IOFactory::load($archivo);
$hojas = $spreadsheet->getAllSheets();

$mysqli->begin_transaction();

try {

foreach ($hojas as $sheet) {

$filas = $sheet->toArray();

for ($i = 4; $i < count($filas); $i++) {

$matricula = trim($filas[$i][1] ?? '');
$nombre = trim($filas[$i][2] ?? '');

if ($matricula == '') continue;

$stmt = $mysqli->prepare("SELECT id_alumno FROM alumno WHERE matricula = ?");
$stmt->bind_param("s", $matricula);
$stmt->execute();
$res = $stmt->get_result();
$alumno = $res->fetch_assoc();

if ($alumno) {
$id_alumno = $alumno['id_alumno'];
} else {

$stmt = $mysqli->prepare("
INSERT INTO alumno
(nombre_alumno, matricula, curp, cuatrimestre, grupo, carrera, telefono, correo, password, nivel, codigo, status)
VALUES (?, ?, '', '12', '8', '', '', '', '', '', '', 1)
");

$stmt->bind_param("ss", $nombre, $matricula);
$stmt->execute();
$id_alumno = $mysqli->insert_id;
}

$columnas = [
[4,5],
[7,8],
[10,11],
[13,14],
[16,17],
[19,20]
];

foreach ($columnas as $col) {

$periodoCompleto = trim($filas[$i][$col[0]] ?? '');
$nombreTaller = trim($filas[$i][$col[1]] ?? '');

if ($periodoCompleto == '' || $nombreTaller == '') continue;

preg_match('/(\d{4})/', $periodoCompleto, $match);
$anio = $match[0] ?? null;

if (!$anio) continue;

$texto = strtolower($periodoCompleto);

if (strpos($texto, 'enero') !== false) {
$id_periodo = 1;
} elseif (strpos($texto, 'mayo') !== false) {
$id_periodo = 2;
} elseif (strpos($texto, 'sep') !== false) {
$id_periodo = 3;
} else {
continue;
}

$stmt = $mysqli->prepare("SELECT id_anio FROM anios WHERE anio = ?");
$stmt->bind_param("s", $anio);
$stmt->execute();
$res = $stmt->get_result();
$anioRow = $res->fetch_assoc();

if ($anioRow) {
$id_anio = $anioRow['id_anio'];
} else {
$status = 2;
$stmt = $mysqli->prepare("INSERT INTO anios (anio, status) VALUES (?, ?)");
$stmt->bind_param("si", $anio, $status);
$stmt->execute();
$id_anio = $mysqli->insert_id;
}

$stmt = $mysqli->prepare("
SELECT id_historial FROM historial
WHERE id_alumno = ?
AND nombre_taller = ?
AND id_periodo = ?
AND id_anio = ?
");
$stmt->bind_param("isii", $id_alumno, $nombreTaller, $id_periodo, $id_anio);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {

$stmt = $mysqli->prepare("
INSERT INTO historial
(id_alumno, matricula, nombre_taller, id_periodo, id_anio)
VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("issii", $id_alumno, $matricula, $nombreTaller, $id_periodo, $id_anio);
$stmt->execute();
}
}
}
}

$mysqli->commit();
echo "Importación completada correctamente.";
echo '<script>setTimeout(function(){ location.href="../panel_admin.php"; }, 1500);</script>';

} catch (Exception $e) {
$mysqli->rollback();
echo "Error: " . $e->getMessage();
}
}
?> 


