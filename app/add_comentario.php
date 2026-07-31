<?php 
$id_inscripcion = $_POST ['id_inscripcion'];
$comentario = $_POST ['comentario'];

require("conexion.php");

$add_comentario = $mysqli->query("UPDATE inscripciones SET Comentarios  = '$comentario' WHERE id_inscripcion = '$id_inscripcion'");

if ($add_comentario) {
    echo '<script>setTimeout(function(){ location.href="visualizar_taller.php"; }, 1500);</script>';

}

?>