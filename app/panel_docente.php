<?php
session_start();

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== '2') {
    header("Location: login.php");
    exit;
}

$id_docente = $_SESSION['id_docente'];
$nombre = $_SESSION['nombre'];
$nombre_p = $_SESSION['nombre_p'];
require('conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Docente</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">
    

    <link rel="stylesheet" href="CSS/panell.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

<style>
 

    html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    margin-left: 250px;
    flex: 1;
      background: rgb(219, 218, 207);
}

footer {
    margin-top: auto;
}

.navv{
    background: #1bb285ff;
}

.separador{
    width: 100%; 
    height: 10px;
    background: linear-gradient(135deg, #2d4d1f, #4f6f32, #1f3316);
    background-size: 300% 300%;
    animation: fondoMove 8s ease infinite;
    margin-top: 20px;
    margin-bottom: 20px;
}
 
.grid-talleres{
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

.cont-taller{
    position: relative;  
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
 
.btn-modificar{
    position: absolute;
    top: 10px;
    right: 10px;
}

textarea{
    width: 100%;
    resize: none;
}


@media (max-width: 600px) {
    main { 
        margin-left: 0px;  
        flex: 1;
    }
}
</style>
</style>
</head>

<body>

<div class="navv">
    <?php require ('nav.php');?>
</div>

<main>
<div class="contenedor_">
<div class="container mt-4">

    <h1>Hola <?php echo $nombre ?></h1>
    <h1>Periodo <?php echo $nombre_p ?></h1>

    <div class="separador"></div>

    <h2>Lista de Talleres Activos</h2>

    <div class="grid-talleres">
    <?php
    $ver = $mysqli->query("
        SELECT i.id_taller, i.nombre_taller, i.hora, i.dia, 
               i.cantidad_inscritos, a.nombre_p, i.grupo, i.comentarios
        FROM talleres i 
        INNER JOIN periodo a ON i.periodo = a.id_periodo 
        WHERE i.docente_id = $id_docente AND i.status = '1'
    ");

    if ($ver && $ver->num_rows == 0) {
        echo "<div class='alert alert-warning'>Aún no tienes talleres registrados.</div>";
    } else {
        while ($dato = mysqli_fetch_array($ver)) {
    ?>
        <div class="cont-taller">
 
            <a href="upd_taller.php?id_taller=<?php echo $dato['id_taller'] ?>"
               class="btn btn-warning btn-sm btn-modificar">
               Editar
            </a>

            <p><strong>Taller:</strong> <?php echo $dato['nombre_taller'] ?></p>
            <p><strong>Grupo:</strong> <?php echo $dato['grupo'] ?></p>
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
            <p><strong>Periodo:</strong> <?php echo $dato['nombre_p'] ?></p>
            <p><strong>Cupo:</strong> <?php echo $dato['cantidad_inscritos'] ?></p>

            <p><strong>Comentarios:</strong></p>
            <textarea disabled><?php echo htmlspecialchars($dato['comentarios']); ?></textarea>

            <form method="POST" action="visualizar_taller.php" class="mt-2">
                <input type="hidden" name="id_taller" value="<?php echo $dato['id_taller'] ?>">
                <input type="hidden" name="nombre_taller" value="<?php echo $dato['nombre_taller'] ?>">
                <input type="submit" class="btn btn-success btn-sm" value="Ver Taller">
            </form>
        </div>
    <?php } } ?>
    </div>

</div>
</div>

<script>
document.querySelectorAll('.cont-taller').forEach(c => {
    c.addEventListener('touchstart', () => c.classList.add('activo'));
    c.addEventListener('touchend', () => c.classList.remove('activo'));
});
</script>

</main>

<footer>

</footer>

</body>
</html>