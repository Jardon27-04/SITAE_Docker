<style> body{
    background: rgb(219, 218, 207);
}
    </style><?php
session_start();

require('conexion.php');

$rol = $_SESSION['rol'];

$status = $_POST['status'] ?? '';

$query = '';

if($rol == 1){
$query = "SELECT
id_docente, nombre, telefono, correo, status, num_empleado FROM docentes
WHERE rol = 2 AND 1";

}

if($rol == 3){
$query = "SELECT
id_docente, nombre, telefono, correo, status, num_empleado FROM docentes";

}
if ($status !== '') {
$query .= " AND status = '$status'";
}

$resultado = $mysqli->query($query);

echo "



Nombre
Telefono
Correo
Num. Empleado
Status
Modificar


";

while ($row = $resultado->fetch_assoc()) {

echo "
{$row['nombre']}
{$row['telefono']}
{$row['correo']}
{$row['num_empleado']}
";
?>

<input type="hidden" name="status" value="2">
<?php

} elseif ($row['status'] == 2) {

$textoBtn = "Inactivo";
$claseBtn = "btn-danger";
?>





<input type="submit" value="Actualizar" class="btn btn-success btn-sm">

<?php

echo "";
?>