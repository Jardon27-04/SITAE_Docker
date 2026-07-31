<?php
$id_taller   = $_POST['id_taller'];
$id_alumno   = $_POST['id_alumno'];
$docente_id  = $_POST['docente_id'];
$status      = $_POST['status'];
$status_liberado = 0;

require("conexion.php");

 
$anio_activo = $mysqli->query("SELECT id_anio FROM anios WHERE status = '1'");
$anio_id = ($anio_activo->num_rows > 0) 
    ? $anio_activo->fetch_assoc()['id_anio'] 
    : 0;

 
$verificar_repetido = $mysqli->query("
    SELECT id_inscripcion 
    FROM inscripciones 
    WHERE id_alumno = '$id_alumno' 
      AND id_taller = '$id_taller'
      AND status = '1'
");

if ($verificar_repetido && $verificar_repetido->num_rows > 0) {
    echo "<div class='alert alert-warning'>
            Ya estás inscrito en este taller.
          </div>";
    exit;
}

 
$consultarcupo = $mysqli->query("
    SELECT cantidad_inscritos, fecha_limite 
    FROM talleres 
    WHERE id_taller = '$id_taller'
");

if (!$consultarcupo || $consultarcupo->num_rows == 0) {
    echo "<div class='alert alert-danger'>El taller no existe.</div>";
    exit;
}

$row = $consultarcupo->fetch_assoc();
$cupo_actual = $row['cantidad_inscritos'];
$fecha_limite = $row['fecha_limite'];

if ($cupo_actual <= 0) {
    echo "<div class='alert alert-danger'>No hay cupo disponible.</div>";
    exit;
}
 
$ahora = date("Y-m-d H:i:s");
if ($ahora > $fecha_limite) {
    echo "<div class='alert alert-danger'>
            Las inscripciones a este taller están cerradas.
          </div>";
    exit;
}



$consultanivel = $mysqli->query("
    SELECT nivel 
    FROM alumno 
    WHERE id_alumno = '$id_alumno'
");


$row8 = $consultanivel->fetch_assoc();
$nivel_vacio = $row8['nivel'];

if ($nivel_vacio == "") {
    echo "<div class='alert alert-danger'>Actualiza tu nivel educativo</div>";
    exit;
}


$consultacuatri = $mysqli->query("
    SELECT cuatrimestre
    FROM alumno 
    WHERE id_alumno = '$id_alumno'
");
$row9 = $consultacuatri->fetch_assoc();
$cuatri_vacio = $row9['cuatrimestre'];

if ($cuatri_vacio == "12") {
    echo "<div class='alert alert-danger'>Actualiza tu cuatrimestre</div>";
    exit;
}



$consultamatricula = $mysqli->query("
    SELECT matricula
    FROM alumno 
    WHERE id_alumno = '$id_alumno'
");
$row11 = $consultamatricula->fetch_assoc();
$matriculavacia = $row11['matricula'];

if ($matriculavacia == "") {
    echo "<div class='alert alert-danger'>Debes actualizar tu matricula en panel 'Actualizar mis Datos'</div>";
    exit;
}




$consultaDatoo = $mysqli->query("
    SELECT *
    FROM alumno 
    WHERE id_alumno = '$id_alumno'
");

$rowvacio = $consultaDatoo->fetch_assoc();

foreach ($rowvacio as $campo => $valor) {

   
    if ($campo == 'codigo') {
        continue;
    }

    
    if ($valor == "" || is_null($valor)) {
        echo "<div class='alert alert-danger'>
                Debes actualizar tus datos faltantes en 'Actualizar mis Datos'
              </div>";
        exit;
    }
}




$consultarnivel = $mysqli->query("
    SELECT nivel 
    FROM alumno 
    WHERE id_alumno = '$id_alumno'
");

$row7 = $consultarnivel->fetch_assoc();
$nivel_actual = $row7['nivel'];

 
$insertar = $mysqli->query("
    INSERT INTO inscripciones 
    (id_alumno, id_docente, id_taller, anio, status_liberado, status, nivel) 
    VALUES 
    ('$id_alumno', '$docente_id', '$id_taller', '$anio_id', '$status_liberado', '$status', '$nivel_actual')
");

if ($insertar) {

     
    $cupo_actualizado = $cupo_actual - 1;
    $mysqli->query("
        UPDATE talleres 
        SET cantidad_inscritos = '$cupo_actualizado' 
        WHERE id_taller = '$id_taller'
    ");

    echo "<div class='alert alert-success'>Registro exitoso.</div>";
    echo '<script>
            setTimeout(function(){
                location.href="panel_alumno.php";
            }, 1500);
          </script>';

} else {
    echo "<div class='alert alert-danger'>
            Ocurrió un error al registrarse.
          </div>";
}
?>
