<?php
session_start();

if (!isset($_SESSION['correo']) || ($_SESSION['rol'] !== '1' && $_SESSION['rol'] !== '2')) {
    header("Location: login.php");
    exit;
}

require('conexion.php');

if (isset($_POST['id_taller'])) {
    $_SESSION['id_taller'] = (int) $_POST['id_taller'];
    $_SESSION['nombre_taller'] = $_POST['nombre_taller'] ?? 'Taller';
}

$tallersession = (int) ($_SESSION['id_taller'] ?? 0);
$nombre_taller = $_SESSION['nombre_taller'] ?? 'Taller';
$rol = $_SESSION['rol'] ?? '';

if ($tallersession === 0) {
    die("<h3>No se ha seleccionado ningún taller.</h3>");
}

$anio_registro = '';

$sql_anio_taller = "SELECT a.anio
                    FROM talleres t
                    LEFT JOIN anios a ON t.anio = a.id_anio
                    WHERE t.id_taller = $tallersession
                    LIMIT 1";

$res_anio_taller = $mysqli->query($sql_anio_taller);

if ($res_anio_taller && $res_anio_taller->num_rows > 0) {
    $fila_anio = $res_anio_taller->fetch_assoc();
    $anio_registro = $fila_anio['anio'];
}

$anio_registro = htmlspecialchars((string)$anio_registro);

$sql = "SELECT 
            i.id_inscripcion, 
            i.id_alumno, 
            p.nombre_alumno, 
            i.id_docente,
            m.nombre AS nombre_docente, 
            p.matricula, 
            i.status_liberado,
            i.id_taller, 
            p.grupo, 
            g.nombre_grupo, 
            p.carrera, 
            c.nombre_cuatrimestre,
            a.anio,
            i.Comentarios,
            p.telefono,
            p.correo,
            t.grupo AS grupo_taller,
            t.status
        FROM inscripciones i
        INNER JOIN alumno p ON i.id_alumno = p.id_alumno
        INNER JOIN docentes m ON i.id_docente = m.id_docente
        INNER JOIN grupo g ON p.grupo = g.id_grupo
        INNER JOIN cuatrimestre c ON p.cuatrimestre = c.id_cuatrimestre
        INNER JOIN anios a ON i.anio = a.id_anio
       INNER JOIN talleres t ON i.id_taller = t.id_taller
        WHERE i.id_taller = $tallersession";

$ver = $mysqli->query($sql);

if (!$ver) {
    die("<b>Error en la consulta:</b> " . $mysqli->error);
}



$taller_grupo = '';

$sql_grupo = "SELECT grupo 
              FROM talleres 
              WHERE id_taller = $tallersession 
              LIMIT 1";

$res_grupo = $mysqli->query($sql_grupo);

if ($res_grupo && $res_grupo->num_rows > 0) {

    $fila_grupo = $res_grupo->fetch_assoc();

    $taller_grupo = $fila_grupo['grupo'];

}



$status_t = '';

$sql_taller = "SELECT status 
              FROM talleres 
              WHERE id_taller = $tallersession 
              LIMIT 1";

$res_t = $mysqli->query($sql_taller);

if ($res_t && $res_t->num_rows > 0) {

    $fila_t = $res_t->fetch_assoc();

    $status_t = $fila_t['status'];

}

?>



<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($nombre_taller) ?> - Lista de Alumnos</title>

<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<style>

main{
    background: rgb(219, 218, 207);
}

body {
    font-family: Arial, sans-serif;
    margin: 15px;
    background: #f7f7f7;
}

h1, h2 {
    text-align: center;
}

.tabla-responsive {
    width: 100%;
    overflow-x: auto;
    background: rgb(219, 218, 207);
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
    min-width: 600px;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    white-space: nowrap;
}

th {
    background: rgb(219, 218, 207);
    color: #000;
}

/* FORZAR NEGRITAS en los encabezados de Matrícula y Nombre */
#tablaAlumnos thead th:nth-child(1),
#tablaAlumnos thead th:nth-child(2) {
    font-weight: bold !important;
    font-size: 1.05em;
}

.btn {
    padding: 6px 10px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn:hover {
    opacity: .9;
}

.separador {
    width: 90%;
    height: 10px;
    background: linear-gradient(135deg, #2d4d1f, #4f6f32, #1f3316);
    background-size: 300% 300%;
    animation: fondoMove 8s ease infinite;
    margin: 20px auto;
    border-radius: 20px;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    margin-left: 263px;
    flex: 1;
}

@media (max-width: 600px) {

    main {
        margin-left: 0px;
        flex: 1;
    }

}

</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php require('nav.php'); ?>

<main>

<h1><?= htmlspecialchars($nombre_taller) ?></h1>
<h2>Lista de Estudiante</h2>

<div class="separador"></div>

<div class="tabla-responsive">

<table id="tablaAlumnos" class="display">

<thead>

<tr>

<th>Matrícula</th>
<th>Nombre del Estudiante</th>
<th>Teléfono</th>
<th>Correo</th>
<th>Carrera</th>
<th>Grupo</th>
<th>Cuatrimestre</th>

<?php if ($rol == "1"): ?>
<th>Profesor</th>
<?php endif; ?>

<th>Status</th>
<th>Eliminar</th>

<?php if ($rol == "2"): ?>
<th>Comentario</th>
<?php endif; ?>

</tr>

</thead>

<tbody>

<?php while ($dato = $ver->fetch_assoc()): ?>

<tr>

<td><?= htmlspecialchars($dato['matricula']) ?></td>
<td><?= htmlspecialchars($dato['nombre_alumno']) ?></td>
<td><?= htmlspecialchars($dato['telefono']) ?></td>
<td><?= htmlspecialchars($dato['correo']) ?></td>
<td><?= htmlspecialchars($dato['carrera']) ?></td>
<td><?= htmlspecialchars($dato['nombre_grupo']) ?></td>
<td><?= htmlspecialchars($dato['nombre_cuatrimestre']) ?></td>

<?php if ($rol == "1"): ?>
<td><?= htmlspecialchars($dato['nombre_docente']) ?></td>
<?php endif; ?>

<td data-status="<?= (int)$dato['status_liberado'] ?>">

<?php if ($dato['status_liberado'] != 1): ?>

<?php if ($rol === '2'): ?>

<button class='btn btn-success btn-sm' onclick="Liberacion(<?= (int)$dato['id_inscripcion']; ?>)">
Liberar
</button>

<?php else: ?>

<span style="color:red">Sin Liberar</span>

<?php endif; ?>

<?php else: ?>

<span style="color:green">Liberado</span>

<?php endif; ?>

</td>

<td>

<button type='button'
class='btn btn-success btn-sm'
onclick='anularInscripcion(<?= (int)$dato["id_inscripcion"] ?>)'>

Anular Inscripción

</button>

</td>

<?php if ($rol == "2"): ?>

<td>

<form method='POST' action='add_comentario.php'>

<input type='hidden' name='id_inscripcion' value="<?php echo $dato['id_inscripcion']; ?>">

<textarea disabled><?= htmlspecialchars($dato['Comentarios']) ?></textarea>

<br>

<input type='text'
name='comentario'
maxlength="500"
placeholder="Agrega un comentario">

<input type='submit'
class='btn btn-success btn-sm'
value='Enviar comentario'>

</form>

</td>

<?php endif; ?>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>

$(document).ready(function() {

    const opciones = {

        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },

        paging: true,

        dom: 'Bfrtip',

        buttons: [

            {
                extend: 'excelHtml5',

                text: 'Exportar documento',

                title: 'Lista de alumnos - <?= addslashes($nombre_taller . " (Año " . $anio_registro . ")" . "Grupo " . $taller_grupo) ?>',

                exportOptions: {

                    columns: [0,1,2,3,4,5,6,7],

                    format: {

                        body: function (data, row, column, node) {

                            if ($(node).attr('data-status') !== undefined) {

                                return $(node).attr('data-status') == 1
                                    ? 'Liberado'
                                    : 'Sin liberar';
                            }

                            return data;
                        }
                    }
                }
            },

      {
    extend: 'excelHtml5',

    text: 'Lista de asistencia',

    title: 'Lista de asistencia - <?= addslashes($nombre_taller . " (Año " . $anio_registro . ")" . "Grupo " . $taller_grupo) ?>',
    exportOptions: {
        columns: [0,1]
    },

    customize: function (xlsx) {

        var sheet = xlsx.xl.worksheets['sheet1.xml'];
        var styles = xlsx.xl['styles.xml'];

        
        $('row:first c', sheet).remove();

      
        var lastXfIndex = $('cellXfs xf', styles).length - 1;

        $('cellXfs', styles).append(
            '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1"/>'
        );

        var borderStyle = lastXfIndex + 1;

        

        
       $('row:eq(0)', sheet).append(
    '<c t="inlineStr" r="A1" s="'+borderStyle+'">' +
    '<is><t><?= addslashes("Lista de Asistencia - " . $nombre_taller . " Grupo " . $taller_grupo . " " . $anio_registro) ?></t></is></c>'
);

        $('row:eq(0)', sheet).append(
            '<c t="inlineStr" r="B1" s="'+borderStyle+'">' +
            '<is><t>Nombre del Estudiante</t></is></c>'
        );

        
        const letras = [
            'C','D','E','F','G','H','I','J',
            'K','L','M','N','O','P','Q','R'
        ];

        
        letras.forEach(function(letra){

            $('row:eq(0)', sheet).append(
                '<c t="inlineStr" r="'+letra+'1" s="'+borderStyle+'">' +
                '<is><t></t></is></c>'
            );

        });

        
        $('sheetData row', sheet).each(function(index){

            var fila = index + 1;

            
            $('c[r="A'+fila+'"]', sheet).attr('s', borderStyle);
            $('c[r="B'+fila+'"]', sheet).attr('s', borderStyle);

             
            if(index > 0){

                letras.forEach(function(letra){

                    $('row:eq(' + index + ')', sheet).append(
                        '<c t="inlineStr" r="'+letra+fila+'" s="'+borderStyle+'">' +
                        '<is><t></t></is></c>'
                    );

                });

            }

        });

        $('cols', sheet).remove();

        var cols =
            '<cols>' +
                '<col min="1" max="1" width="18" customWidth="1"/>' +
                '<col min="2" max="2" width="40" customWidth="1"/>' +
                '<col min="3" max="18" width="4" customWidth="1"/>' +
            '</cols>';

        sheet.childNodes[0].insertBefore(
            $.parseXML(cols).documentElement,
            sheet.childNodes[0].childNodes[0]
        );

    }

}

        ]

    };

    $('#tablaAlumnos').DataTable(opciones);

});

function Liberacion(id_inscripcion) {
		if (<?= (int)$status_t ?> === 1){
            if (confirm("¿Seguro que deseas liberar a este estudiante?")) {
    $.ajax({

        url: 'liberacion.php',

        type: 'POST',

        data: {
            id_inscripcion: id_inscripcion
        },

        dataType: 'json',

        success: function(data) {

            if (data.noliberado === true) {

                alert('El periodo de liberación ha finalizado.');

            } else {

                alert('Liberado correctamente.');

            }

            location.reload();

        },

        error: function() {

            alert('Ocurrió un error');

        }

    });

}
       }   else{
          alert('Ya no puedes liberar a los estudiantes de este taller.');
      }

     }

function anularInscripcion(id_inscripcion) {
  if (confirm("¿Seguro que deseas anular la inscripcion?")) {
    
    $.ajax({

        url: 'eliminar_insc.php',

        type: 'POST',

        data: {
            id_inscripcion
        },

        success: function() {

            alert('Se anuló tu inscripción');

            location.reload();

        }

    });

}
    }

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>