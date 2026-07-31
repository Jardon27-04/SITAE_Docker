<?php
session_start();

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== '2') {
    header("Location: login.php");
    exit;
}

$id_docente = $_SESSION['id_docente'];
$nombre = $_SESSION['nombre'];
require('conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiante</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">
    
    <link rel="stylesheet" href="CSS/panell.css">
 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

<style>

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
@media (max-width: 600px) {
    main { 
        margin-left: 0px;  
        flex: 1;
    }
}

    </style>

  
</head>

<body>
           
<div class="navv">

<?php require ('nav.php');?>
</div>
<main>
<div class="container mt-4">


  <h2>Historial de Talleres Anteriores</h2>
 <div class="separador"></div>

  <div class="grid-talleres">
  <?php
  $ver = $mysqli->query("SELECT i.id_taller, i.nombre_taller, i.docente_id, p.nombre, i.hora, i.dia , i.cantidad_inscritos, i.periodo, a.nombre_p, i.grupo, i.anio, e.anio AS nombre_anio
      FROM talleres i 
      INNER JOIN docentes p ON i.docente_id = p.id_docente 
      INNER JOIN periodo a ON i.periodo = a.id_periodo
      INNER JOIN anios e ON i.anio = e.id_anio 
      WHERE i.docente_id = $id_docente AND i.status = '2'");

  if ($ver && $ver->num_rows == 0) {
      echo "<div class='alert alert-warning'>Aún no tienes talleres registrados en cuatrimestres anteriores.</div>";
  } else {
      while ($dato = mysqli_fetch_array($ver)) {
  ?>
      <div class="cont-taller">
          <p><strong>Taller:</strong> <?php echo $dato['nombre_taller'] ?></p>
          <p><strong>Grupo:</strong> <?php echo $dato['grupo'] ?></p>
          <p><strong>Periodo:</strong> <?php echo $dato['nombre_p'] ?></p>
            <p><strong>Año:</strong> <?php echo $dato['nombre_anio'] ?></p>
          <p><strong>Cupo:</strong> <?php echo $dato['cantidad_inscritos'] ?></p>

          <form method="POST" action="visualizar_taller.php">
              <input type="hidden" name="id_taller" value="<?php echo $dato['id_taller'] ?>">
              <input type="hidden" name="nombre_taller" value="<?php echo $dato['nombre_taller'] ?>">
              <input type="submit" class="btn btn-success btn-sm" value="Ver Taller">
          </form>
      </div>
  <?php }} ?>
  </div>
</div>

<script type="text/javascript">
 
const contenedores = document.querySelectorAll('.cont-taller');
contenedores.forEach(contenedor => {
    contenedor.addEventListener('touchstart', () => contenedor.classList.add('activo'));
    contenedor.addEventListener('touchend', () => contenedor.classList.remove('activo'));
    contenedor.addEventListener('touchcancel', () => contenedor.classList.remove('activo'));
});
</script>
</main>
</body>
</html>
