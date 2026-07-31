<style> body{
    background: rgb(219, 218, 207);
}
    </style>

<?php
require('conexion.php');

$status = $_POST['status'] ?? '';
$grupo = $_POST['grupo'] ?? '';
$query = "SELECT 
            i.id_taller, 
            i.nombre_taller, 
            i.docente_id, 
            p.nombre AS nombre_docente, 
            i.hora, 
            i.dia, 
            i.cantidad_inscritos, 
            i.periodo, 
            a.nombre_p AS nombre_periodo, 
            i.grupo,
            e.anio,
            i.status
          FROM talleres i 
          INNER JOIN docentes p ON i.docente_id = p.id_docente 
          INNER JOIN periodo a ON i.periodo = a.id_periodo 
          INNER JOIN anios e ON i.anio = e.id_anio
          WHERE 1";

if ($status !== '') {
    $query .= " AND i.status = '$status'";
}

if ($grupo !== '') {
    $query .= " AND i.grupo = '$grupo'";
}

$resultado = $mysqli->query($query);

echo "<div class='tabla-responsive'>
        <table id='tablaTalleres' class='display'>
            <thead>
                <tr>
                    <th>Taller</th>
                    <th>Grupo</th>
                    <th>Periodo</th>
                    <th>Año</th>
                    
                    <th>Docente</th>
                    <th>Cupo</th>
                    
                    <th>Ver Taller</th>
                </tr>
            </thead>
            <tbody>";

while ($row = $resultado->fetch_assoc()) {

   // $estado = ($row['status'] == 1) ? "Activo" : "Inactivo";

    echo "<tr>
            <td>{$row['nombre_taller']}</td>
            <td>{$row['grupo']}</td>
            <td>{$row['nombre_periodo']}</td>
            <td>{$row['anio']}</td>
           
            <td>{$row['nombre_docente']}</td>
            <td>{$row['cantidad_inscritos']}</td>
          
            <td>
                <form method='POST' action='visualizar_taller.php'>
                    <input type='hidden' name='id_taller' value='{$row['id_taller']}'>
                    <input type='hidden' name='nombre_taller' value='{$row['nombre_taller']}'>
                    <input type='submit' class='btn btn-success btn-sm' value='Ver Taller'>
                </form>
            </td>
          </tr>";
}

echo "</tbody></table></div>";
