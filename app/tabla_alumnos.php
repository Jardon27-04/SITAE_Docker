<style> body{
    background: rgb(219, 218, 207);
}
    </style><?php
require('conexion.php');

$cuatrimestre = $_POST['cuatrimestre'] ?? '';
$grupo = $_POST['grupo'] ?? '';
$carrera = $_POST['carrera'] ?? '';
$status = $_POST['status'] ?? '';

$query = "SELECT 
            a.id_alumno,
            a.nombre_alumno,
            a.curp,
            a.matricula,
            a.cuatrimestre,
            c.nombre_cuatrimestre,
            a.grupo,
            g.nombre_grupo,
            a.carrera,
            a.correo,
            a.nivel,
            a.telefono,
            a.status
          FROM alumno a
          INNER JOIN cuatrimestre c ON a.cuatrimestre = c.id_cuatrimestre
          INNER JOIN grupo g ON a.grupo = g.id_grupo
          WHERE 1";

if ($cuatrimestre !== '') {
    $query .= " AND a.cuatrimestre = '$cuatrimestre'";
}

if ($grupo !== '') {
    $query .= " AND a.grupo = '$grupo'";
}

if ($carrera !== '') {
    $query .= " AND a.carrera = '$carrera'";
}

if ($status !== '') {
    $query .= " AND a.status = '$status'";
}
$resultado = $mysqli->query($query);

echo "<div class='tabla-responsive'>
        <table id='tablaalumno' class='display'>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Matricula</th>
                    <th>Cuatrimestre</th>
                    <th>Grupo</th>
                    <th>Carrera</th>
                    <th>Correo</th>
                    <th>Nivel</th>

                      <th>Status</th>
                    
                </tr>
            </thead>
            <tbody>";

while ($row = $resultado->fetch_assoc()) {

    echo "<tr>
            <td>{$row['nombre_alumno']}</td>
            <td>{$row['telefono']}</td>
            <td>{$row['matricula']}</td>
            <td>{$row['nombre_cuatrimestre']}</td>
            <td>{$row['nombre_grupo']}</td>
            <td>{$row['carrera']}</td>
            <td>{$row['correo']}</td>
            <td>{$row['nivel']}</td>

             <td>"
?>

<form action="modificar_stud.php" method="POST">
    <input type="hidden" name="id_alumno" value="<?php echo $row['id_alumno']; ?>">

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


           
          </tr>";
}

echo "</tbody></table></div>";
?>
