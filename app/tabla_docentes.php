<?php
session_start();

require('conexion.php');
?>

<style>
body{
    background: rgb(219,218,207);
}
</style>
<?php

$rol = $_SESSION['rol'] ?? null;

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

echo "<div class='tabla-responsive'>
        <table id='tablaalumnoo' class='display'>
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
            <tbody>";

while ($row = $resultado->fetch_assoc()) {

 echo "<tr>
        <td>{$row['nombre']}</td>
        <td>{$row['telefono']}</td>
        <td>{$row['correo']}</td>
         <td>{$row['num_empleado']}</td>
        <td>";
?>

<form action="modificar_docente.php" method="POST">
    <input type="hidden" name="id_docente" value="<?php echo $row['id_docente']; ?>">

<?php
if ($row['status'] == 1) {
   
    $textoBtn = "Activo";
     $claseBtn = "btn-success"; 
    
    ?>
    <input type="hidden" name="status" value="2">
    <?php
} elseif ($row['status'] == 2) {
    
   $textoBtn = "Inactivo";
        $claseBtn = "btn-danger";
    ?>
    <input type="hidden" name="status" value="1">
    <?php
}
?>

  <input type="submit" value="<?php echo $textoBtn; ?>" class="btn <?php echo $claseBtn; ?> btn-sm">
</form>



<?php
echo "</td>




 <td>";
?>

<form action="upd_docente.php" method="POST">
    <input type="hidden" name="id_docente" value="<?php echo $row['id_docente']; ?>">

    <input type="submit" value="Actualizar" class="btn btn-success btn-sm">
</form></tr>
<?php
}

echo "</tbody></table></div>";
?>
