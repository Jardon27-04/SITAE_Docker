<?php
session_start();
require('conexion.php');

$id_alumno = $_SESSION['id_alumno'];

$alumno = $mysqli->query("SELECT nombre_alumno FROM alumno WHERE id_alumno = '$id_alumno'");
$nombre_alumno = $alumno->fetch_assoc()['nombre_alumno'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Talleres Liberados</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

<style>
body {
font-family: Arial, sans-serif;
}

table {
width: 100%;
border-collapse: collapse;
}

th, td {
border: 1px solid black;
padding: 5px;
text-align: center;
}

 
@media print {
body {
margin: 20px;
}
}
</style>
</head>

<body>

<table border='1' style='font-family: Arial, sans-serif; width:100%; border-collapse:collapse;'>

<tr>
    <td style="border:none; width:15%; text-align:left; vertical-align:middle;">
        <img src="img/IMG_2020.PNG" style="width:80px; height:auto;">
    </td>

    <td colspan="5" style="border:none; text-align:center; vertical-align:middle;">
        <h2 style="margin:0;">Talleres Liberados</h2>
    </td>

    <td style="border:none; width:15%;"></td>
</tr>
<tr>
<td colspan='7' align='center' style='font-size:14px;'>
Estudiante: <?php echo $nombre_alumno; ?>
</td>
</tr>

<tr><td colspan='7' style='height:20px;'></td></tr>

<tr>
<th>Taller</th>
<th>Docente</th>
<th>Nivel</th>
<th>Periodo</th>
<th>Estado</th>
</tr>

<?php
$insc = $mysqli->query("
SELECT i.nombre_taller, p.nombre AS docente, i.hora, i.dia,
a.status_liberado, a.nivel, e.nombre_p, n.anio
FROM talleres i
INNER JOIN docentes p ON i.docente_id = p.id_docente
INNER JOIN inscripciones a ON a.id_taller = i.id_taller
INNER JOIN periodo e ON e.id_periodo = i.periodo
INNER JOIN anios n ON i.anio = n.id_anio
WHERE a.id_alumno = '$id_alumno' AND a.status = '2'
");

while ($dato = $insc->fetch_assoc()) {
$estado = ($dato['status_liberado'] == 1) ? 'Liberado' : 'Sin liberar';

echo "<tr>
<td>{$dato['nombre_taller']}</td>
<td>{$dato['docente']}</td>
<td>{$dato['nivel']}</td>
<td>{$dato['nombre_p']}-{$dato['anio']}</td>
<td>{$estado}</td>
</tr>";
}

$hist = $mysqli->query("
SELECT h.nombre_taller, p.nombre_p
FROM historial h
INNER JOIN periodo p ON h.id_periodo = p.id_periodo
WHERE h.id_alumno = '$id_alumno'
");

while ($dato = $hist->fetch_assoc()) {
echo "<tr>
<td>{$dato['nombre_taller']}</td>
<td>-</td>
<td>-</td>
<td>{$dato['nombre_p']}{$dato['anio']}</td>
<td>Liberado</td>
</tr>";
}
?>

<tr><td colspan='7' style='height:80px;'></td></tr>

<tr>
<td colspan='7' align='center'>
___________________________<br>
Departamento de Servicios Estudiantiles.
</td>
</tr>


<tr><td colspan='8' style='height:80px;'></td></tr>

<tr>
<td colspan='8' align='center'>
<br>
<?php 
$meses = [
1 => 'enero', 2 => 'febrero', 3 => 'marzo',
4 => 'abril', 5 => 'mayo', 6 => 'junio',
7 => 'julio', 8 => 'agosto', 9 => 'septiembre',
10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
];

$dia = date("d");
$mes = $meses[date("n")];
$anio = date("Y");

$hoy = $dia . " de " . $mes . " de " . $anio;
 ?><span style="font-size:10px;">
<?php echo "Puente De Ixtla - $hoy"; ?>
</span>
</td>
</tr>

</table>

<script>
window.onload = function() {
window.print();  
}
</script>

</body>
</html>