<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'Estudiante') {
  header("location:login.php");
  exit;
}

$id_alumno     = $_SESSION['id_alumno'];
$nombre_alumno = $_SESSION['nombre_alumno'];
$nombre_p      = $_SESSION['nombre_p'];

require('conexion.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Estudiante</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
         background: rgb(219, 218, 207);
        margin: 0;
        padding: 0;
    }

    main {
        margin-left: 270px;
        padding: 20px;
          background: rgb(219, 218, 207);
    }

   
    .grid-talleres {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-top: 20px;
        align-items: stretch; 
    }

     
    .cont-taller {
        background-color: #ffffff;
        border-left: 6px solid #28a745;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        transition: all 0.2s ease;

        display: flex;
        flex-direction: column;
        justify-content: space-between;  
        min-height: 220px;  
    }

    .cont-taller:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    .cont-taller p {
        margin: 6px 0;
        font-size: 14px;
        color: #555;
    }

    .cont-taller strong {
        color: #222;
    }

    .separador {
        width: 100%;
        height: 6px;
        background: linear-gradient(135deg, #2d4d1f, #4f6f32, #1f3316);
    background-size: 300% 300%;
    animation: fondoMove 8s ease infinite;
        margin: 15px 0 25px 0;
        border-radius: 5px;
    }

    h3, h4 {
        color: #333;
    }

 
    @media (max-width: 992px) {
        .grid-talleres {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        main {
            margin-left: -1px;
            padding: 15px;
            width: 100%;
        }

        .container{
            width: 100%;
        }
        .grid-talleres {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <?php require('nav.php'); ?>

    <main>
        
        <div class="container mt-4">

            <h3>Periodo <?php echo $nombre_p ?></h3>
            <div class="separador"></div>
            
         <a href="exportar_excel.php" class="btn btn-success mb-3" target="_blank"> Descargar Mis Talleres</a>

            <h4 class="mt-4">Mis Talleres</h4>

            <div class="grid-talleres">

                <?php
       
        $insc = $mysqli->query("
SELECT i.nombre_taller, p.nombre AS docente, i.hora, i.dia,
       a.Comentarios, a.status_liberado, a.nivel
FROM talleres i
INNER JOIN docentes p ON i.docente_id = p.id_docente
INNER JOIN inscripciones a ON a.id_taller = i.id_taller
WHERE a.id_alumno = '$id_alumno' AND a.status = '2'
");

        if ($insc->num_rows > 0) {
          while ($dato = $insc->fetch_assoc()) {
        ?>
                <div class="cont-taller">
                    <div>
                        <p><strong>Taller:</strong> <?php echo $dato['nombre_taller']; ?></p>
                        <p><strong>Docente:</strong> <?php echo $dato['docente']; ?></p>
                        <p><strong>Nivel:</strong> <?php echo $dato['nivel']; ?></p>
                        <p><strong>Comentarios:</strong> <?php echo $dato['Comentarios']; ?></p>
                    </div>

                    <div>
                        <?php if ($dato['status_liberado'] == 1) { ?>
                        <span class="text-success">Liberado</span>
                        <?php } else { ?>
                        <span class="text-danger">Sin liberar</span>
                        <?php } ?>
                    </div>
                </div>
                <?php
          }
        }

        $hist = $mysqli->query("
SELECT h.nombre_taller, p.nombre_p, n.anio
FROM historial h
INNER JOIN periodo p ON h.id_periodo = p.id_periodo
INNER JOIN anios n ON h.id_anio = n.id_anio
WHERE h.id_alumno = '$id_alumno'
");

        if ($hist->num_rows > 0) {
          while ($dato = $hist->fetch_assoc()) {
          ?>
                <div class="cont-taller">
                    <div>
                        <p><strong>Taller:</strong> <?php echo $dato['nombre_taller']; ?></p>
                        <p><strong>Periodo:</strong> <?php echo $dato['nombre_p']; ?></p>
                        <p><strong>Año:</strong> <?php echo $dato['anio']; ?></p>
                    </div>

                    <div>
                        <span class="text-success">Liberado</span>
                    </div>
                </div>
                <?php
          }
        }

        if ($insc->num_rows == 0 && $hist->num_rows == 0) {
          echo "<div class='alert alert-warning'>No tienes talleres registrados.</div>";
        }
        ?>

            </div> 

        </div>
    </main>

</body>
</html>