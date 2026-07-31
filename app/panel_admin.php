<?php
session_start();


if (!isset($_SESSION['correo']) || !in_array($_SESSION['rol'], [1, 3])) {
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
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG"  style="border-radius: 50%;">

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>


<style>
 
html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background: linear-gradient(135deg, #e3f2fd, #f8f9fa);
}
 
.container {
    flex: 1;
    padding: 30px;
    margin-left: 250px;
    width: 85%;
     background: rgb(219, 218, 207);
}
 
.dashboard-header {
    background: #ffffff;
    border-radius: 14px;
    padding: 25px;
    box-shadow: 0 6px 15px rgba(0,0,0,.1);
    margin-bottom: 35px;
}

.dashboard-header h1 {
    margin: 0;
    font-size: 26px;
    color: #333;
}

.dashboard-header h2 {
    margin-top: 8px;
    font-size: 18px;
    color: #555;
}
 
.separador {
    width: 100%;
    height: 6px;
     background: linear-gradient(135deg, #2d4d1f, #4f6f32, #1f3316);
    background-size: 300% 300%;
    animation: fondoMove 8s ease infinite;
    border-radius: 50px;
    margin-top: 20px;
}
 
.menu {
    display: grid;
    grid-template-columns: repeat(2, 1fr);  
    gap: 25px;
    max-width: 1000px;
    margin: 0 auto;
     margin-top: 80px;
}
 
.menu2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);  
    gap: 25px;
    max-width: 1000px;
    margin: 0 auto;
     margin-top: 150px;
}
.boton {
    background: #ffffff;
    border: none;
    border-radius: 20px;
    padding: 35px 20px;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(0,0,0,.12);
    transition: all .3s ease;
}

.boton a {
    text-decoration: none;
    color: #333;
    font-size: 18px;
    font-weight: 600;
    display: block;
}

.boton:hover {
    transform: translateY(-15px);
    background: linear-gradient(135deg, #3f82ff, #26c975);
}

.boton:hover a {
    color: #ffffff;
}
 
@media (max-width: 600px) {
    .menu {
        grid-template-columns: 1fr;
    }

    .menu {
   
     margin-top: 10px;
}
.container {
    flex: 1;
    padding: 30px;
    margin-left: auto;
     width: 100%;
}
}
    
    
</style>
</head>

<body>

<?php require('nav.php'); ?>

<div class="container">
 
    <div class="dashboard-header">
        <h1> Bienvenido(a), <?php echo $nombre; ?></h1>
        <h1>Periodo activo: <?php echo $nombre_p . " - " . $anio; ?></h1>
        <div class="separador"></div>
    </div>
 
    <?php
$consultarfecha = $mysqli->query("
    SELECT id_fecha 
    FROM fecha_limite 
    WHERE status = '1'
");

if (!$consultarfecha || $consultarfecha->num_rows == 0) {
    echo "<div class='alert alert-danger'>Actualizar fecha limite para poder registrar talleres.</div>";
    
}
?>
 <?php if ($_SESSION['rol'] == "1") { ?>
  
    <div class="menu">
        <button class="boton">
            <a href="viewtalleres.php">Talleres</a>
        </button>

        <button class="boton">
            <a href="viewdocentes.php">Docentes</a>
        </button>

        <button class="boton">
            <a href="viewalumnos.php">Estudiantes</a>
        </button>

        <button class="boton">
            <a href="viewliberados.php">Lista de Liberados</a>
        </button>
        <button class="boton">
            <center> <a href="Historial/importar_historial.php">Cargar Historial</a></center>
        </button>
            <button class="boton">
            <center> <a href="reporte_inscripciones.php">Listado general de Inscripciones</a></center>
        </button>
        
    </div>
   <?php } ?>

   <?php if ($_SESSION['rol'] == "3") { ?>
  
    <div class="menu2">
          <button class="boton">
            <a href="viewdocentes.php">Docentes</a>
        </button>
        <button class="boton">
           <center> <a href="Historial/importar_historial.php">Cargar Historial</a></center>
        </button>
         </button>
            <button class="boton">
            <center> <a href="reporte_inscripciones.php">Listado general de Inscripciones</a></center>
        </button>
    </div>
   <?php } ?>
</div>
 

</body>
</html>
