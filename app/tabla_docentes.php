<?php

session_start();

require('conexion.php');

$rol = $_SESSION['rol'] ?? null;

if (!$rol) {
    die("Sesión no iniciada");
}

$status = $_POST['status'] ?? '';

$query = "";


// Administrador
if ($rol == 1) {

    $query = "SELECT 
                id_docente,
                nombre,
                telefono,
                correo,
                status,
                num_empleado
              FROM docentes
              WHERE rol = 2";

}


// Otro tipo de usuario con permisos
elseif ($rol == 3) {

    $query = "SELECT 
                id_docente,
                nombre,
                telefono,
                correo,
                status,
                num_empleado
              FROM docentes
              WHERE 1";

}


else {

    die("No tienes permisos para ver docentes");

}


// Filtro por estado
if ($status !== '') {

    $status = $mysqli->real_escape_string($status);

    $query .= " AND status = '$status'";

}


// Ejecutar consulta
$resultado = $mysqli->query($query);


if (!$resultado) {

    die("Error en la consulta: " . $mysqli->error);

}


// Encabezado tabla

echo "

<table class='table table-striped'>

<thead>

<tr>
<th>Nombre</th>
<th>Telefono</th>
<th>Correo</th>
<th>Num. Empleado</th>
<th>Status</th>
<th>Modificar</th>
</tr>

</thead>

<tbody>

";


// Mostrar datos

while ($row = $resultado->fetch_assoc()) {


    echo "

    <tr>

    <td>{$row['nombre']}</td>

    <td>{$row['telefono']}</td>
 
    <td>{$row['correo']}</td>

    <td>{$row['num_empleado']}</td>

    <td>";


    if ($row['status'] == 1) {

        echo "

        <span class='badge bg-success'>
        Activo
        </span>

        ";

    } 
    
    elseif ($row['status'] == 2) {

        echo "

        <span class='badge bg-danger'>
        Inactivo
        </span>

        ";

    }


    echo "

    </td>


    <td>

    <form action='modificar_docente.php' method='POST'>

    <input type='hidden' 
           name='id_docente' 
           value='{$row['id_docente']}'>

    <input type='submit' 
           value='Modificar' 
           class='btn btn-success btn-sm'>

    </form>

    </td>


    </tr>

    ";

}


echo "

</tbody>

</table>

";

?>