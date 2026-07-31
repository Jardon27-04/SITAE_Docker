<?php

$dato = $_GET['dato'] ?? '';
$codigo = rand(100000, 999999);

require("conexion.php");

$stmtDoc = $mysqli->prepare("SELECT id_docente, correo FROM docentes WHERE correo = ? OR num_empleado = ?");
$stmtDoc->bind_param("ss", $dato, $dato);
$stmtDoc->execute();
$resultDoc = $stmtDoc->get_result();

if ($resultDoc->num_rows > 0) {

    $fila = $resultDoc->fetch_assoc();
    $id = $fila['id_docente'];
    $correo = $fila['correo'];

    $stmtUpdate = $mysqli->prepare("UPDATE docentes SET codigo = ? WHERE id_docente = ?");
    $stmtUpdate->bind_param("si", $codigo, $id);
    $stmtUpdate->execute();

    if ($stmtUpdate->affected_rows > 0) {

        $asunto = "Codigo de recuperacion";
        $carta = "Este es un Codigo de verificacion para restablecer tu cuenta\n";
        $carta .= $codigo;

        mail($correo, $asunto, $carta);

        echo '<script>
            setTimeout(function(){
                location.href="validar.php?dato=' . urlencode($correo) . '&codigo=' . $codigo . '&id=' . $id . '&tipo=docente";
            },50);
        </script>';
    }

} else {

    $stmtAlu = $mysqli->prepare("SELECT id_alumno, correo FROM alumno WHERE correo = ? OR matricula = ?");
    $stmtAlu->bind_param("ss", $dato, $dato);
    $stmtAlu->execute();
    $resultAlu = $stmtAlu->get_result();

    if ($resultAlu->num_rows > 0) {

        $fila = $resultAlu->fetch_assoc();
        $id = $fila['id_alumno'];
        $correo = $fila['correo'];

        $stmtUpdate = $mysqli->prepare("UPDATE alumno SET codigo = ? WHERE id_alumno = ?");
        $stmtUpdate->bind_param("si", $codigo, $id);
        $stmtUpdate->execute();

        if ($stmtUpdate->affected_rows > 0) {

            $asunto = "Codigo de recuperacion";
            $carta = "Este es un Codigo de verificacion para restablecer tu cuenta\n";
            $carta .= $codigo;

            mail($correo, $asunto, $carta);

            echo '<script>
                setTimeout(function(){
                    location.href="validar.php?dato=' . urlencode($correo) . '&codigo=' . $codigo . '&id=' . $id . '&tipo=alumno";
                },50);
            </script>';
        }

    } else {

        echo "Usuario no encontrado.";
        echo '<script>
            setTimeout(function(){
                location.href="login.php";
            },1500);
        </script>';
    }
}
?>