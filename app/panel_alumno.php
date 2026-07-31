<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'Estudiante') {
    header("location:login.php");
    exit;
}

$id_alumno      = $_SESSION['id_alumno'];
$nombre_alumno  = $_SESSION['nombre_alumno'];
$nombre_p       = $_SESSION['nombre_p'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel Estudiante</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script>
function Inscripcion(id_taller){
    var id_alumno  = document.getElementById('id_alumno_' + id_taller).value;    
    var docente_id = document.getElementById('docente_id_' + id_taller).value;  
    var status     = document.getElementById('status_' + id_taller).value;    

    var datos4 = "id_taller="+id_taller+"&id_alumno="+id_alumno+"&docente_id="+docente_id+"&status="+status;

    $.ajax({
        url: 'inscripcion.php',
        type: 'POST',
        data: datos4,
    })
    .done(function(res){
        $('#respuesta_' + id_taller).html(res);
    });
}
</script>

<style>
html, body {
    height: 100%;
    margin: 0;
}

body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f6fa;
    color: #333;
    display: flex;
    flex-direction: column;
}

main { 
    margin-left: 250px;  
    flex: 1;
      background: rgb(219, 218, 207);
    
}

h1, h2, h3 {
    text-align: center;
    color: #2c3e50;
}

.grid-talleres {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    max-width: 1100px;
    margin: 30px auto;
    padding: 10px;
}

.cont-taller {
    background-color: #ecf0f1;
    border-left: 6px solid #34db74ff;
    padding: 15px 20px;
    border-radius: 10px;
}

.btn-success {
    background-color: #27ae60;
    border-radius: 8px;
    font-weight: bold;
}

.separador {
    width: 100%;
    height: 10px;
   background: linear-gradient(135deg, #2d4d1f, #4f6f32, #1f3316);
    background-size: 300% 300%;
    animation: fondoMove 8s ease infinite;
    margin: 20px 0;
}

textarea {
    width: 100%;
    resize: none;
}

@media (max-width: 600px) {
    main { 
        margin-left: 10px;  
        flex: 1;
    }
}
</style>
</head>

<body>

<?php require('nav.php'); ?>

<main>
<div class="container mt-4">

<h1>Hola <?= $nombre_alumno ?></h1>
<h3>Periodo <?= $nombre_p ?></h3>

<div class="separador"></div>

<?php
require('conexion.php');

$consulta_total = $mysqli->query("
    SELECT COUNT(*) AS total
    FROM inscripciones
    WHERE id_alumno = '$id_alumno' AND status = '1'
");

$total_talleres = $consulta_total->fetch_assoc()['total'];
?>

<?php
if ($total_talleres > 0) {

    echo "<h3>Mi taller y horario</h3>";
    echo "<div class='grid-talleres'>";

    $mis_talleres = $mysqli->query("
        SELECT i.id_taller, i.nombre_taller, p.nombre AS nombre_docente, 
               a.Comentarios, a.status_liberado,
               i.comentarios AS comentarios_taller, i.grupo
        FROM inscripciones a
        INNER JOIN talleres i ON a.id_taller = i.id_taller
        INNER JOIN docentes p ON i.docente_id = p.id_docente
        WHERE a.id_alumno = '$id_alumno' AND a.status = '1'
    ");

    while ($dato = mysqli_fetch_array($mis_talleres)) {
?>
        <div class="cont-taller">
            <p><strong>Taller:</strong> <?= $dato['nombre_taller'] ?></p>
            <p><strong>Docente:</strong> <?= $dato['nombre_docente'] ?></p>

           <?php 
$id_taller = $dato['id_taller'];

$horario = $mysqli->query("
    SELECT dia, hora_inicio, hora_fin 
    FROM horarios 
    WHERE id_taller = $id_taller
    ORDER BY FIELD(dia, 'Lunes','Martes','Miercoles','Jueves','Viernes')
");

echo "<p><strong>Horarios:</strong></p><ul>";

if ($horario && $horario->num_rows > 0) {
    while ($datos = mysqli_fetch_array($horario)) {
        echo "<li>{$datos['dia']} (" . substr($datos['hora_inicio'],0,5) . " - " . substr($datos['hora_fin'],0,5) . ")</li>";
    }
} else {
    echo "<li>No hay horarios registrados</li>";
}

echo "</ul>";
?>

            <p><strong>Grupo:</strong> <?= $dato['grupo'] ?></p>
            <p><strong>Notas:</strong> <?= $dato['comentarios_taller'] ?></p>
            <p><strong>Comentarios:</strong> <?= $dato['Comentarios'] ?></p>

            <?= ($dato['status_liberado'] == 1)
                ? "<span class='text-success'>Liberado</span>"
                : "<span class='text-danger'>Sin liberar</span>"; ?>
        </div>
<?php
    }

    echo "</div>";  
}

if ($total_talleres < 3) {

    echo "<h2>Lista de Talleres Disponibles</h2>";
    echo "<div class='grid-talleres'>";

    $ver = $mysqli->query("
        SELECT i.id_taller, i.nombre_taller, i.docente_id, p.nombre,
               i.cantidad_inscritos, i.comentarios
        FROM talleres i
        INNER JOIN docentes p ON i.docente_id = p.id_docente
        WHERE i.status = '1'
    ");

    if ($ver->num_rows == 0) {
        echo "<div class='alert alert-warning'>
                No hay talleres activos en este periodo.
              </div>";
    }

    while ($dato = mysqli_fetch_array($ver)) {
?>
        <div class="cont-taller">
            <p><strong>Taller:</strong> <?= $dato['nombre_taller'] ?></p>
            <p><strong>Docente:</strong> <?= $dato['nombre'] ?></p>

              <?php 
$id_taller = $dato['id_taller'];

$horario = $mysqli->query("
    SELECT dia, hora_inicio, hora_fin 
    FROM horarios 
    WHERE id_taller = $id_taller
    ORDER BY FIELD(dia, 'Lunes','Martes','Miercoles','Jueves','Viernes')
");

echo "<p><strong>Horarios:</strong></p><ul>";

if ($horario && $horario->num_rows > 0) {
    while ($datos = mysqli_fetch_array($horario)) {
        echo "<li>{$datos['dia']} (" . substr($datos['hora_inicio'],0,5) . " - " . substr($datos['hora_fin'],0,5) . ")</li>";
    }
} else {
    echo "<li>No hay horarios registrados</li>";
}

echo "</ul>";
?>

            <p><strong>Cupo disponible:</strong> <?= $dato['cantidad_inscritos'] ?></p>

            <textarea disabled><?= htmlspecialchars($dato['comentarios']) ?></textarea>

            <input type="hidden" id="id_taller_<?= $dato['id_taller'] ?>" value="<?= $dato['id_taller'] ?>">
            <input type="hidden" id="id_alumno_<?= $dato['id_taller'] ?>" value="<?= $id_alumno ?>">
            <input type="hidden" id="docente_id_<?= $dato['id_taller'] ?>" value="<?= $dato['docente_id'] ?>">
            <input type="hidden" id="status_<?= $dato['id_taller'] ?>" value="1">

            <button class="btn btn-success btn-sm mt-2"
                onclick="Inscripcion(<?= $dato['id_taller'] ?>)">
                Inscribirme
            </button>

            <div id="respuesta_<?= $dato['id_taller'] ?>"></div>
        </div>
<?php
    }

    echo "</div>";  

} else {
    echo "
        <div class='alert alert-warning'>
            Consulta con tu docente el Aula asignada para tomar las clases.
        </div>
        <div class='alert alert-info'>
            Ya estás inscrito en el máximo de talleres permitidos.
        </div>";
}
?>

</div>
</main>
 
</body>
</html>