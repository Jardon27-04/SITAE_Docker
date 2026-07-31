<?php

session_start();


if (!isset($_SESSION['correo']) || !in_array($_SESSION['rol'], [1, 3])) {
    header("Location: login.php");
    exit;
}

require('conexion.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Inscripciones</title>

<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background: rgb(219, 218, 207);
    font-family: Arial, sans-serif;
    margin: 0;
}

main{
    margin-left: 280px;
    padding: 20px;
}

.tabla-responsive{
    width:100%;
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse: collapse;
}

th, td{
    text-align:center;
}

.separador{
    width:100%;
    height:10px;
    background: linear-gradient(135deg, #2d4d1f, #4f6f32, #1f3316);
    background-size:300% 300%;
    animation:fondoMove 8s ease infinite;
    margin-top:20px;
    margin-bottom:20px;
}

.botones{
    margin-top:20px;
    margin-bottom:20px;
}

@media (max-width: 768px){

    main{
        margin-left:0px;
    }

    .tabla-responsive{
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    table{
        min-width:800px;
    }
}

@keyframes fondoMove{
    0%{
        background-position:0% 50%;
    }
    50%{
        background-position:100% 50%;
    }
    100%{
        background-position:0% 50%;
    }
}

</style>
</head>

<body>

<?php require('nav.php'); ?>

<main>

<div class="container mt-4">

<h2>Listado General de Inscripciones</h2>

<div class="separador"></div>

<label><b>Filtrar por:</b></label>
 
<label>Carrera</label>

<select id="filtroCarrera">
    <option value="">Todos</option>
    <option value="Gastronomia">Gastronomía</option>
    <option value="Turismo">Turismo</option>
    <option value="Operaciones Comerciales">Operaciones Comerciales</option>
    <option value="Agricultura Sustentable y Protegida">Agricultura Sustentable y Protegida	</option>
    <option value="Tecnologias de la Informacion">Tecnologías de la Información</option>
</select>
    
    
    
<label>Talleres</label>

<select id="filtroTalleres"></select>
 
    
    
    
    <label>Periodo</label>

    <select id="filtroPeriodo">

    <option value="">Todos</option>

    <option value="">*******************</option>
  <?php
require('conexion.php');
$consultaP = $mysqli->query("
	SELECT DISTINCT
    p.id_periodo,
    p.nombre_p,
    a.id_anio,
    a.anio
FROM talleres t
INNER JOIN periodo p
    ON t.periodo = p.id_periodo
INNER JOIN anios a
    ON t.anio = a.id_anio
ORDER BY a.anio DESC, p.id_periodo ASC
");
while ($datoP = mysqli_fetch_array($consultaP)) {
?>
<option 
value="<?php echo $datoP['id_periodo'].'-'.$datoP['id_anio']; ?>">

<?php 
echo $datoP['nombre_p'].'-'.$datoP['anio']; 
?>

</option>
<?php } ?>
</select>
    
    
    
      

    
<div class="botones">


<a id="excelBtn" href="excel_inscripciones.php">

<button type="button" class="btn btn-success">
    Exportar Excel
</button>

</a>

</div>

<div id="tablaResultado"></div>

</div>

</main>
<script>

$(document).ready(function(){

   

    function cargarTalleres(){

        let periodo = $("#filtroPeriodo").val();

        $.ajax({

            url:"obtener_talleres.php",

            type:"POST",

            data:{
                periodo:periodo
            },

            success:function(data){

                $("#filtroTalleres").html(data);

            }

        });

    }

   

    function cargarTabla(){

        let carrera = $("#filtroCarrera").val();
        let taller = $("#filtroTalleres").val();
        let periodo = $("#filtroPeriodo").val();

        $.ajax({

            url:"tabla_inscripciones.php",

            type:"POST",

            data:{
                carrera:carrera,
                taller:taller,
                periodo:periodo
            },

            success:function(data){

                if ($.fn.DataTable.isDataTable('#tablaInscripciones')) {

                    $('#tablaInscripciones').DataTable().destroy();

                }

                $("#tablaResultado").html(data);

                $('#tablaInscripciones').DataTable({

                    language:{
                        url:"//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                    },

                    pageLength:10

                });

            }

        });

       

        $("#excelBtn").attr(

            "href",

            "excel_inscripciones.php?carrera="
            + encodeURIComponent(carrera)

            + "&taller="
            + encodeURIComponent(taller)

            + "&periodo="
            + encodeURIComponent(periodo)

        );

    }

    

    cargarTalleres();

    setTimeout(function(){

        cargarTabla();

    }, 200);
 

    $("#filtroCarrera").on("change", cargarTabla);

    $("#filtroTalleres").on("change", cargarTabla);

    $("#filtroPeriodo").on("change", function(){

        cargarTalleres();

        setTimeout(function(){

            cargarTabla();

        }, 200);

    });

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>