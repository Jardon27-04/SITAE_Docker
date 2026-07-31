<?php

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'Estudiante') {
    header("location:login.php");
}
$id_alumno = $_SESSION['id_alumno'];
$nombre_alumno = $_SESSION['nombre_alumno'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Estudiante</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable();
        });

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
            })
        }
    </script>

    <style>
 
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f6fa;
      margin: 0;
      padding: 0;
      color: #333;
    }

    h1, h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
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
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .cont-taller:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }

    .cont-taller p {
      margin: 5px 0;
      line-height: 1.4;
    }

    
    .btn {
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
    }

    .btn-success {
      background-color: #27ae60;
      color: #fff;
    }

    .btn-success:hover {
      background-color: #2ecc71;
      box-shadow: 0 0 10px rgba(46, 204, 113, 0.4);
    }

    
    .cont-taller.activo {
      background-color: #d6eaf8;
      transform: scale(0.98);
      transition: transform 0.1s ease;
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
    
    @media (max-width: 992px) {
      .grid-talleres {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      }
    }

    @media (max-width: 600px) {
      .grid-talleres {
        grid-template-columns: 1fr;
      }
    }
    </style>
</head>

<body>
  <h1>Bienvenido <?php echo $nombre_alumno ?></h1>
  <div class="container mt-4">

  <div class="separador"></div>
      <h2>Lista de Talleres</h2>
      <?php
 require('nav.php');
 ?>
      <div class="grid-talleres">
          <?php
          require('conexion.php');
          $ver = $mysqli->query("SELECT i.id_taller, i.nombre_taller, i.docente_id, p.nombre, i.hora, i.dia , i.cantidad_inscritos
              FROM talleres i 
              INNER JOIN docentes p ON i.docente_id = p.id_docente 
              WHERE i.status = '1'");

          while ($dato = mysqli_fetch_array($ver)) {
          ?>
              <div class="cont-taller">
                  <p><strong>Taller:</strong> <?php echo $dato['nombre_taller'] ?></p>
                  <p><strong>Docente:</strong> <?php echo $dato['nombre'] ?></p>
                  <p><strong>Hora:</strong> <?php echo $dato['hora'] ?></p>
                  <p><strong>Día:</strong> <?php echo $dato['dia'] ?></p>
                  <p><strong>Cupo disponible:</strong> <?php echo $dato['cantidad_inscritos'] ?></p>

                
                  <input type="hidden" id="id_taller_<?php echo $dato['id_taller']; ?>" value="<?php echo $dato['id_taller'] ?>">
                  <input type="hidden" id="id_alumno_<?php echo $dato['id_taller']; ?>" value="<?php echo $id_alumno; ?>">
                  <input type="hidden" id="docente_id_<?php echo $dato['id_taller']; ?>" value="<?php echo $dato['docente_id']; ?>">
                  <input type="hidden" id="status_<?php echo $dato['id_taller']; ?>" value="1">

                  <input type="button" class="btn btn-success btn-sm" value="Inscribirme" onclick="Inscripcion(<?php echo $dato['id_taller']; ?>)">
                  <div id="respuesta_<?php echo $dato['id_taller']; ?>"></div>
              </div>
          <?php } ?>
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

</body>
</html>
