<?php

session_start();

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== '1') {
    header("Location: login.php");
    exit;
}

$id_docente = $_SESSION['id_docente'];
$nombre = $_SESSION['nombre'];

$nombre_p = $_SESSION['nombre_p'];
$anio = $_SESSION['anio'];

require('conexion.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
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

.separador{
           width: 100%; 
           height: 10px;
           background: linear-gradient(135deg, #2d4d1f, #4f6f32, #1f3316);
    background-size: 300% 300%;
    animation: fondoMove 8s ease infinite;
           margin-top: 20px;
           margin-bottom: 20px;

        }
.separadoor{
           width: 100%; 
           height: 10px;
           background: linear-gradient(135deg, #2d4d1f, #4f6f32, #1f3316);
    background-size: 300% 300%;
    animation: fondoMove 8s ease infinite;
           margin-top: 20px;
           margin-bottom: 50px;

        }

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
    margin-left: 280px;
    flex: 1;
}

 
@media (max-width: 600px) {
    main { 
        margin-left: 0px;  
        flex: 1;
    }
 
            body { overflow-x: hidden;
            margin-left: 10px;
        }
            .tabla-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border: 1px solid #ddd;
            }
            table { min-width: 800px; }
        }
    </style>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<body>
 
<?php require ('nav.php'); ?>
 
<main>
<div class="container mt-4">
<h2>Listado de Estudiante</h2>
 


<div class="separador"></div>
<h1>Periodo: <?php echo $nombre_p . " - " . $anio; ?></h1>
 
<label><b>Filtrar por:</b></label>

<label for="">Cuatrimestre</label>
<select id="filtroCuatrimestre">
    <option value="">Todos</option>
    <option value="1">1RO</option>
    <option value="2">2DO</option>
    <option value="3">3RO</option>
    <option value="4">4TO</option>
    <option value="5">5TO</option>
    <option value="6">6TO</option>
    <option value="7">7MO</option>
    <option value="8">8VO</option>
    <option value="9">9NO</option>
    <option value="10">10MO</option>
    <option value="11">11VO</option>
</select>

<label for="">Grupo</label>
<select id="filtroGrupoAlumno">
    <option value="">Todos</option>
    <option value="1">A</option>
    <option value="2">B</option>
    <option value="3">C</option>
    <option value="4">D</option>
    <option value="5">E</option>
    <option value="6">F</option>
    <option value="7">G</option>
</select>

<label for="">Carrera</label>
<select id="filtroCarrera">
    <option value="">Todos</option>
    <option value="Gastronomia">Gastronomía</option>
    <option value="Turismo">Turismo</option>
    <option value="Operaciones Comerciales">Operaciones Comerciales</option>
    <option value="Agricultura">Agricultura</option>
    <option value="Tecnologias de la Informacion">Tecnologías de la Información</option>
</select>

    <label><b>Filtrar por:</b></label>
<label for="">Status</label>
<select id="filtroStatus">
    <option value="">Todos</option>
    <option value="1">Activos</option>
    <option value="2">Inactivos</option>
</select>

<br><br>
 
<div id="tablaAlumnoss"></div>




<script>
$(document).ready(function() {

   

 
    function cargarAlumno() {

        let cuatrimestre = $("#filtroCuatrimestre").val();
        let grupo = $("#filtroGrupoAlumno").val();
        let carrera = $("#filtroCarrera").val();
          let status = $("#filtroStatus").val();

        $.ajax({
            url: "tabla_alumnos.php",
            type: "POST",
            data: { cuatrimestre: cuatrimestre, grupo: grupo, carrera: carrera, status: status},
            success: function(data) {

                $("#tablaAlumnoss").html(data);

                $('#tablaalumno').DataTable({
                    language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" },
                    pageLength: 10
                });
            }
        });
    }

    cargarAlumno();

    $("#filtroCuatrimestre").on("change", cargarAlumno);
    $("#filtroGrupoAlumno").on("change", cargarAlumno);
    $("#filtroCarrera").on("change", cargarAlumno);
     $("#filtroStatus").on("change", cargarAlumno);

       
});
</script>
</main>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
