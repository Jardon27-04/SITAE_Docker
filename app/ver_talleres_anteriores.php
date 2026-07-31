<?php
require('conexion.php');

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
            e.anio
          FROM talleres i 
          INNER JOIN docentes p ON i.docente_id = p.id_docente 
          INNER JOIN periodo a ON i.periodo = a.id_periodo 
          INNER JOIN anios e ON i.anio = e.id_anio
          WHERE i.status = '2'";

$resultado = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Talleres</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: center; }

        .tabla-responsive {
            width: 100%;
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            body { overflow-x: hidden; }
            .tabla-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border: 1px solid #ddd;
            }
            table { min-width: 800px; }
        }
    </style>
</head>
<body>

<h2>Listado de Talleres</h2>

<?php
if ($resultado && $resultado->num_rows > 0) {
    echo "<div class='tabla-responsive'>
        <table id='tablaTalleres' class='display'>
            <thead>
                <tr>
                    <th>Taller</th>
                    <th>Grupo</th>
                    <th>Periodo</th>
                    <th>Año</th>
                    <th>Hora</th>
                    <th>Día</th>
                    <th>Docente</th>
                    <th>Cupo</th>
                    <th>Ver Taller</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "<tr>"
            . "<td>" . $row['nombre_taller'] . "</td>"
            . "<td>" . $row['grupo'] . "</td>"
            . "<td>" . $row['nombre_periodo'] . "</td>"
            . "<td>" . $row['anio'] . "</td>"
            . "<td>" . $row['hora'] . "</td>"
            . "<td>" . $row['dia'] . "</td>"
            . "<td>" . $row['nombre_docente'] . "</td>"
            . "<td>" . $row['cantidad_inscritos'] . "</td>"
            . "<td>
                  <form method='POST' action='visualizar_taller.php'>
                      <input type='hidden' name='id_taller' value='" . $row['id_taller'] . "'>
                      <input type='hidden' name='nombre_taller' value='" . $row['nombre_taller'] . "'>
                      <input type='submit' class='btn btn-success btn-sm' value='Ver Taller'>
                  </form>
               </td>"
            . "</tr>";
    }

    echo "</tbody></table></div>";
} else {
    echo "<p>No se encontraron talleres con los filtros seleccionados.</p>";
}
?>



</body>
</html>
