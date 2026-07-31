<?php
require '../vendor/autoload.php';
require '../conexion.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {

    $archivo = $_FILES['archivo']['tmp_name'];

    $spreadsheet = IOFactory::load($archivo);
    $hojas = $spreadsheet->getAllSheets();

    $mysqli->begin_transaction();

    $totalAlumnos = 0;
    $totalActualizados = 0;

    try {

        foreach ($hojas as $sheet) {

            $filas = $sheet->toArray();

            for ($i = 4; $i < count($filas); $i++) {

                $matricula = trim($filas[$i][1] ?? '');
                $nombre = trim($filas[$i][2] ?? '');

                if ($matricula == '') continue;

                $totalAlumnos++;

                $stmt = $mysqli->prepare("SELECT id_alumno FROM alumno WHERE matricula = ?");
                $stmt->bind_param("s", $matricula);
                $stmt->execute();
                $res = $stmt->get_result();
                $alumno = $res->fetch_assoc();

                if ($alumno) {
                    $id_alumno = $alumno['id_alumno'];
                } else {

                    $stmt = $mysqli->prepare("
                        INSERT INTO alumno
                        (nombre_alumno, matricula, curp, cuatrimestre, grupo, carrera, telefono, correo, password, nivel, codigo, status)
                        VALUES (?, ?, '', '12', '8', '', '', '', '', '', '', 1)
                    ");

                    $stmt->bind_param("ss", $nombre, $matricula);
                    $stmt->execute();
                    $id_alumno = $mysqli->insert_id;
                }

                $stmt = $mysqli->prepare("
                    UPDATE inscripciones 
                    SET status_liberado = 1 
                    WHERE id_alumno = ?
                    AND status_liberado = 0
                ");

                $stmt->bind_param("i", $id_alumno);
                $stmt->execute();

               
                $totalActualizados += $stmt->affected_rows;
            }
        }

        $mysqli->commit();

        echo "Liberación aplicada correctamente.<br>";
        echo "Alumnos procesados: $totalAlumnos<br>";
        echo "Registros liberados: $totalActualizados<br>";

        echo '<script>setTimeout(function(){ location.href="../panel_admin.php"; }, 3000);</script>';

    } catch (Exception $e) {
        $mysqli->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>