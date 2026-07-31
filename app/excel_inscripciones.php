<?php

require('conexion.php');

 

$carrera = $_GET['carrera'] ?? '';
$taller = $_GET['taller'] ?? '';
$periodo = $_GET['periodo'] ?? '';

$nombre_t = 'general';  

if ($taller !== '') {
    $taller = (int)$taller;  
    $consultaTaller = $mysqli->query("SELECT nombre_taller FROM talleres WHERE id_taller = $taller");
    if ($consultaTaller && $consultaTaller->num_rows > 0) {
        $datosTaller = $consultaTaller->fetch_assoc();
        $nombre_t = $datosTaller['nombre_taller'];
    }
}

$where = "WHERE 1";

if ($carrera != '') {
    $carrera = $mysqli->real_escape_string($carrera);
    $where .= " AND a.carrera = '$carrera'";
}

if ($taller != '') {
    $where .= " AND i.id_taller = $taller";
}

 

if($periodo != ''){

    $filtro = explode('-', $periodo);

    $id_periodo = $filtro[0];
    $id_anio = $filtro[1];

    $consultaPeriodo = $mysqli->query("
        SELECT p.nombre_p, a.anio
        FROM periodo p
        INNER JOIN anios a
            ON a.id_anio = '$id_anio'
        WHERE p.id_periodo = '$id_periodo'
    ");

    $datosPeriodo = $consultaPeriodo->fetch_assoc();

    $nombre_periodo = $datosPeriodo['nombre_p'];
    $anio = $datosPeriodo['anio'];

    $where .= " AND t.periodo = '$id_periodo'";
    $where .= " AND t.anio = '$id_anio'";
    $where .= " AND i.status = 2";

}else{

    $where .= " AND i.status = 1";

}

$sql = "SELECT 
            a.matricula,
            a.nombre_alumno,
            a.carrera,
            t.nombre_taller,
            t.grupo,
            p.nombre_p,
            an.anio,
            i.status

        FROM inscripciones i

        INNER JOIN alumno a 
            ON i.id_alumno = a.id_alumno

        INNER JOIN talleres t 
            ON i.id_taller = t.id_taller

        INNER JOIN periodo p
            ON t.periodo = p.id_periodo

        INNER JOIN anios an
            ON t.anio = an.id_anio

        $where

        ORDER BY 
            an.anio DESC,
            t.periodo ASC,
            t.nombre_taller ASC,
            a.nombre_alumno ASC";

$resultado = $mysqli->query($sql) or die($mysqli->error);

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Lista_Inscripciones_".$nombre_t."_".$nombre_periodo."_".$anio.".xls");

echo "\xEF\xBB\xBF";

echo "<table border='1'>";

echo "
<tr>
    <th>#</th>
    <th>Matrícula</th>
    <th>Alumno</th>
    <th>Carrera</th>
    <th>Taller</th>
    <th>Grupo</th>
    <th>Periodo</th>
    <th>Año</th>
</tr>
";

$contador = 1;

while($fila = $resultado->fetch_assoc()){

echo "
<tr>
    <td>".$contador++."</td>
    <td>".$fila['matricula']."</td>
    <td>".$fila['nombre_alumno']."</td>
    <td>".$fila['carrera']."</td>
    <td>".$fila['nombre_taller']."</td>
    <td>".$fila['grupo']."</td>
    <td>".$fila['nombre_p']."</td>
    <td>".$fila['anio']."</td>
</tr>
";

}

echo "</table>";

?>