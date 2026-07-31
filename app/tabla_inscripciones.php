<?php

require('conexion.php');

$carrera = $_POST['carrera'] ?? '';
$taller = $_POST['taller'] ?? '';
$periodo = $_POST['periodo'] ?? '';

$where = "WHERE 1";

 

if($carrera != ''){
    $where .= " AND a.carrera = '$carrera'";
}

 

if($taller != ''){
    $where .= " AND i.id_taller = '$taller'";
}

 

if($periodo != ''){

    $filtro = explode('-', $periodo);

    $id_periodo = $filtro[0];
    $id_anio = $filtro[1];

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

            t.id_taller,
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
            t.grupo ASC,
            a.nombre_alumno ASC";

 
$resultado = $mysqli->query($sql);

 

echo "

<div class='tabla-responsive'>

<p>
Total de alumnos inscritos:
<strong>".$resultado->num_rows."</strong>
</p>

<table id='tablaInscripciones' class='display'>

<thead>

<tr>
    <th>#</th>
    <th>Matrícula</th>
    <th>Alumno</th>
    <th>Carrera</th>
    <th>Taller</th>
    <th>Grupo</th>
    <th>Periodo</th>
    <th>Año</th>
    <th>Status</th>
</tr>

</thead>

<tbody>

";

$contador = 1;



while($fila = $resultado->fetch_assoc()){

 

    if($fila['status'] == 1){

        $estado = "Activo";

    }else{

        $estado = "Histórico";

    }

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

<td>".$estado."</td>

</tr>

";

}

 
echo "

</tbody>

</table>

</div>

";

?>