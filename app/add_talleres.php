<?php
session_start();
require("conexion.php");

if (!isset($_SESSION['id_docente'])) {
echo "Sesión no válida";
exit;
}

$nombre_taller = trim($_POST['nombre_taller'] ?? '');
$docente_id = trim($_POST['docente_id'] ?? '');
$periodo = trim($_POST['periodo'] ?? '');
$grupo = trim($_POST['grupo'] ?? '');
$cantidad_inscritos = trim($_POST['cantidad_inscritos'] ?? '');
$anio = trim($_POST['anio'] ?? '');
$status = trim($_POST['status'] ?? '');
$comentarios = trim($_POST['comentarios'] ?? '');

 
$horarios_json = $_POST['horarios'] ?? '';
$horarios = json_decode($horarios_json, true);

if ($nombre_taller === '' || $grupo === '0') {
echo "Campos obligatorios vacíos";
exit;
}

if (!$horarios || count($horarios) == 0) {
echo "Debes seleccionar al menos un día con horario";
exit;
}

 
$buscar_fecha = $mysqli->query("
SELECT fecha_limite
FROM fecha_limite
WHERE status = '1'
LIMIT 1
");

if ($buscar_fecha->num_rows === 0) {
echo "No hay fecha límite activa";
exit;
}

$row_fecha = $buscar_fecha->fetch_assoc();
$fecha_limite = $row_fecha['fecha_limite'];

if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha_limite)) {
echo "Formato de fecha inválido en la Base de Datos";
exit;
}

 
$verificar = $mysqli->prepare("
SELECT id_taller
FROM talleres
WHERE grupo = ?
AND nombre_taller = ?
AND docente_id = ?
AND status = 1");
$verificar->bind_param("sss", $grupo, $nombre_taller, $docente_id);
$verificar->execute();
$verificar->store_result();

if ($verificar->num_rows > 0) {
echo "El grupo $grupo ya está registrado para este taller";
exit;
}
$insertar = $mysqli->prepare("
INSERT INTO talleres
(nombre_taller, docente_id, hora, dia, periodo, grupo, cantidad_inscritos, anio, status, fecha_limite, comentarios)
VALUES (?, ?, '', '', ?, ?, ?, ?, ?, ?, ?)
");

$insertar->bind_param(
"ssssiiiss",
$nombre_taller,
$docente_id,
$periodo,
$grupo,
$cantidad_inscritos,
$anio,
$status,
$fecha_limite,
$comentarios
);

if ($insertar->execute()) {

 
$id_taller = $insertar->insert_id;

 
foreach ($horarios as $h) {

$dia = $h['dia'];
$inicio = $h['inicio'];
$fin = $h['fin'];

$stmt = $mysqli->prepare("
INSERT INTO horarios (id_taller, dia, hora_inicio, hora_fin)
VALUES (?, ?, ?, ?)
");

$stmt->bind_param("isss", $id_taller, $dia, $inicio, $fin);
$stmt->execute();
$stmt->close();
}

echo "Taller registrado correctamente";

echo '<script>
setTimeout(function(){
location.href="panel_docente.php";
}, 1500);
</script>';

} else {
echo "Error al guardar el taller";
}

$insertar->close();
$verificar->close();
$mysqli->close();
?>