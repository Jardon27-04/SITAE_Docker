<style> body{
    background: rgb(219, 218, 207);
}
    </style><?php
require('conexion.php');

$cuatrimestre = $_POST['cuatrimestre'] ?? '';
$grupo = $_POST['grupo'] ?? '';
$carrera = $_POST['carrera'] ?? '';
$nivel = $_POST['nivel'] ?? '';

$query = "SELECT 
    a.id_alumno,
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

echo "<div class='tabla-responsive'>
<table id='tablaliberado' class='display'>
<thead>
<tr>
<th>Nombre</th>
<th>Matricula</th>
<th>Cuatrimestre</th>
<th>Grupo</th>
<th>Carrera</th>
<th>Nivel</th>
<th>Talleres Liberados</th>
</tr>
</thead>
<tbody>";

if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>
        <td>{$row['nombre_alumno']}</td>
        <td>{$row['matricula']}</td>
        <td>{$row['nombre_cuatrimestre']}</td>
        <td>{$row['nombre_grupo']}</td>
        <td>{$row['carrera']}</td>
        <td>{$row['nivel']}</td>
        <td>{$row['talleres_liberados']}</td>
        </tr>";
    }
} else {
     
}

echo "</tbody></table></div>";
?>
