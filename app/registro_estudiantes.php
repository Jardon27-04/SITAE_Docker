<?php
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {

    $archivo = $_FILES['archivo']['tmp_name'];

    if (!$archivo) {
        die("No se recibió archivo");
    }

    $documento = IOFactory::load($archivo);
    $hoja = $documento->getActiveSheet();
    $filas = $hoja->toArray();

     
    $consulta_anio = $mysqli->query("SELECT anio FROM anios WHERE status = 1 LIMIT 1");
    $anio_activo = $consulta_anio->fetch_assoc()['anio'];

    $password_base = "UTSEM" . $anio_activo;
    $password_hash = password_hash($password_base, PASSWORD_DEFAULT);

    
    $cuatrimestres_validos = [];

    $res = $mysqli->query("SELECT id_cuatrimestre FROM cuatrimestre");

    while ($row = $res->fetch_assoc()) {
        $cuatrimestres_validos[] = (int)$row['id_cuatrimestre'];
    }

     
    $actualizados = 0;
    $insertados = 0;
    $duplicados = 0;
    $errores = 0;

    foreach ($filas as $index => $fila) {

        if ($index == 0) continue;

 
        $matricula = trim($fila[0] ?? '');
        $curp = trim($fila[1] ?? '');
        $carrera = trim($fila[6] ?? '');
        $grupo_completo = trim($fila[8] ?? '');
        $telefono = trim($fila[28] ?? '');
        $correo = trim($fila[34] ?? '');
        $nombre = trim($fila[41] ?? '');
        $grado_texto = trim($fila[50] ?? '');

        if (empty($nombre) || empty($correo)) {
            $errores++;
            continue;
        }

   
       $matricula = trim($fila[0] ?? '');

        if (empty($matricula)) {
        $errores++;
        continue;
        }
  
         
        preg_match('/\d+/', $grado_texto, $coincidencias);

        $cuatrimestre = isset($coincidencias[0]) ? (int)$coincidencias[0] : 0;

        if (!in_array($cuatrimestre, $cuatrimestres_validos)) {
            $errores++;
            continue;
        }

        
        $nivel = ($cuatrimestre >= 6) ? "ING/LIC" : "TSU";

    
        $grupo = 8;

        if (!empty($grupo_completo)) {
 
            if ($grupo_completo[0] != '1') {

                $letra_grupo = strtoupper(substr($grupo_completo, 1, 1));

                $mapa_grupos = [
                    "A"=>1,
                    "B"=>2,
                    "C"=>3,
                    "D"=>4,
                    "E"=>5,
                    "F"=>6,
                    "G"=>7
                ];

                if (isset($mapa_grupos[$letra_grupo])) {
                    $grupo = $mapa_grupos[$letra_grupo];
                }
            }
        }

        $status = 1;
        $codigo = "";
 
       
        $buscar = $mysqli->prepare("SELECT id_alumno FROM alumno WHERE correo = ?");
        $buscar->bind_param("s", $correo);
        $buscar->execute();
        $resultado = $buscar->get_result();

        if ($resultado->num_rows == 1) {

            $alumno = $resultado->fetch_assoc();
            $id_alumno = $alumno['id_alumno'];

           
            $update = $mysqli->prepare("UPDATE alumno SET
                nombre_alumno = ?,
                curp = ?,
                matricula = ?,
                cuatrimestre = ?,
                grupo = ?,
                carrera = ?,
                telefono = ?,
                nivel = ?
                WHERE id_alumno = ?");

            $update->bind_param(
                "sssissssi",
                $nombre,
                $curp,
                $matricula,
                $cuatrimestre,
                $grupo,
                $carrera,
                $telefono,
                $nivel,
                $id_alumno
            );

            if ($update->execute()) {
                $actualizados++;
            } else {
                $errores++;
            }

            $update->close();

        } elseif ($resultado->num_rows > 1) {

            $duplicados++;

        } else {
 
            $buscar_mat = $mysqli->prepare("SELECT id_alumno FROM alumno WHERE matricula = ?");
            $buscar_mat->bind_param("s", $matricula);
            $buscar_mat->execute();
            $res_mat = $buscar_mat->get_result();

            if ($res_mat->num_rows == 1) {

                $alumno = $res_mat->fetch_assoc();
                $id_alumno = $alumno['id_alumno'];

                $update = $mysqli->prepare("UPDATE alumno SET
                    nombre_alumno = ?,
                    curp = ?,
                    cuatrimestre = ?,
                    grupo = ?,
                    carrera = ?,
                    telefono = ?,
                    correo = ?,
                    nivel = ?
                    WHERE id_alumno = ?");

                $update->bind_param(
                    "ssisssssi",
                    $nombre,
                    $curp,
                    $cuatrimestre,
                    $grupo,
                    $carrera,
                    $telefono,
                    $correo,
                    $nivel,
                    $id_alumno
                );

                if ($update->execute()) {
                    $actualizados++;
                } else {
                    $errores++;
                }

                $update->close();

            } else {

               
                $insert = $mysqli->prepare("INSERT INTO alumno
                (nombre_alumno, curp, matricula, cuatrimestre, grupo, carrera, telefono, correo, password, nivel, codigo, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $insert->bind_param(
                    "sssisssssssi",
                    $nombre,
                    $curp,
                    $matricula,
                    $cuatrimestre,
                    $grupo,
                    $carrera,
                    $telefono,
                    $correo,
                    $password_base,
                    $nivel,
                    $codigo,
                    $status
                );

                if ($insert->execute()) {
                    $insertados++;
                } else {
                    $errores++;
                }

                $insert->close();
            }

            $buscar_mat->close();
        }

        $buscar->close();
    }

 
    echo "<h2>Importación finalizada</h2>";

    echo "Actualizados: $actualizados <br>";
    echo "Insertados: $insertados <br>";
    echo "Duplicados: $duplicados <br>";
    echo "Errores: $errores <br>";

        echo '<script>setTimeout(function(){ location.href="panel_admin.php"; }, 5000);</script>';

}
?>