<?php
session_start();
require('conexion.php');

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== '1') {
    header("Location: login.php");
    exit;
}

$cuatrimestre = $_GET['cuatrimestre'] ?? '';
$grupo = $_GET['grupo'] ?? '';
$carrera = $_GET['carrera'] ?? '';
$nivel = $_GET['nivel'] ?? '';

$query = "SELECT 
    a.nombre_alumno,
    a.matricula,
    c.nombre_cuatrimestre,
    g.nombre_grupo,
    a.carrera,
    i.nivel,
    COUNT(i.id_taller) AS talleres_liberados
FROM alumno a
INNER JOIN cuatrimestre c ON a.cuatrimestre = c.id_cuatrimestre
INNER JOIN grupo g ON a.grupo = g.id_grupo
INNER JOIN inscripciones i ON a.id_alumno = i.id_alumno
WHERE i.status_liberado = 1";

if ($cuatrimestre !== '') {
    $query .= " AND a.cuatrimestre = '$cuatrimestre'";
}

if ($grupo !== '') {
    $query .= " AND a.grupo = '$grupo'";
}

if ($carrera !== '') {
    $query .= " AND a.carrera = '$carrera'";
}

if ($nivel !== '') {
    $query .= " AND i.nivel = '$nivel'";
}

$query .= " GROUP BY 
    a.id_alumno,
    a.nombre_alumno,
    a.matricula,
    c.nombre_cuatrimestre,
    g.nombre_grupo,
    a.carrera,
    i.nivel";

if ($nivel == 'TSU') {
    $query .= " HAVING COUNT(i.id_taller) = 3";
}

if ($nivel == 'ING/LIC') {
    $query .= " HAVING COUNT(i.id_taller) >= 1";
}

$resultado = $mysqli->query($query);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista de Estudiantes Liberados.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "Nombre\tMatricula\tCuatrimestre\tGrupo\tCarrera\tNivel\n";

if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        echo $row['nombre_alumno'] . "\t";
        echo $row['matricula'] . "\t";
        echo $row['nombre_cuatrimestre'] . "\t";
        echo $row['nombre_grupo'] . "\t";
        echo $row['carrera'] . "\t";
        echo $row['nivel'] . "\t";
    }
}

exit;
?>
