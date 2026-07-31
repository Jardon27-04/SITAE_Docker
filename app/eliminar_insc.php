<?php

$id_inscripcion = $_POST['id_inscripcion']; 

require("conexion.php");
 
$consultar_taller = $mysqli->query("SELECT id_taller FROM inscripciones WHERE id_inscripcion = '$id_inscripcion'");

if ($consultar_taller && $consultar_taller->num_rows > 0) {

    $taller = $consultar_taller->fetch_assoc();
    $id_taller = $taller['id_taller'];

    $actualizar_espacio = $mysqli->query("UPDATE talleres SET cantidad_inscritos = cantidad_inscritos + 1 WHERE id_taller = '$id_taller'");

    if ($actualizar_espacio) {

   
        $eliminar_insc = $mysqli->query("DELETE FROM inscripciones WHERE id_inscripcion = '$id_inscripcion'");

        if ($eliminar_insc) {
            echo "Anulaste tu inscripción a este taller.";
            echo '<script>setTimeout(function(){ location.href="panel_admin.php"; }, 1500);</script>';
        } else {
            echo "Ocurrió un error al eliminar la inscripción.";
        }

    } else {
        echo "Ocurrió un error al actualizar el taller.";
    }

} else {
    echo "No se encontró la inscripción.";
}

?>
