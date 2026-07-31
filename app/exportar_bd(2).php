<?php 

set_time_limit(0);
 
$mysqliold = new mysqli(
    "sql202.infinityfree.com",
    "if0_40463029",
    "talleresUTSEM",
    "if0_40463029_tllrs"
);

$mysqliold->set_charset("utf8");

if ($mysqliold->connect_errno) {
    die("Error al conectar con la BD vieja: " . $mysqliold->connect_error);
}
 
require('conexion.php');

$ok = 0;
$error = 0;
$no_encontrado = 0;
$curp_diferente = 0;

echo "<h2>ACTUALIZANDO MATRÍCULAS</h2>";
 
$get_alumno = $mysqliold->query("
    SELECT id_alumno, curp, matricula 
    FROM alumno
");

while ($a = $get_alumno->fetch_assoc()) {

    $id_alumno = $mysqli->real_escape_string($a['id_alumno']);
    $curp_old  = trim($a['curp']);
    $matricula = trim($a['matricula']);
 
    $buscar = $mysqli->query("
        SELECT id_alumno, curp, matricula
        FROM alumno
        WHERE id_alumno = '$id_alumno'
    ");

    if ($buscar->num_rows == 0) {

        echo " No encontrado ID: $id_alumno <br><hr>";
        $no_encontrado++;
        continue;
    }

    $nuevo = $buscar->fetch_assoc();

    $curp_new = trim($nuevo['curp']);

   
    if ($curp_old != $curp_new) {

        echo "CURP diferente en ID: $id_alumno <br>";
        echo "BD vieja: $curp_old <br>";
        echo "BD nueva: $curp_new <br><hr>";

        $curp_diferente++;
        continue;
    }

    
    $update = $mysqli->query("
        UPDATE alumno
        SET matricula = '$matricula'
        WHERE id_alumno = '$id_alumno'
    ");

    if ($update) {

        echo "Matrícula actualizada ID: $id_alumno → $matricula <br><hr>";
        $ok++;

    } else {

        echo "Error ID: $id_alumno <br>";
        echo $mysqli->error . "<br><hr>";

        $error++;
    }
} 
echo "<h2>RESULTADOS</h2>";

echo "Actualizados: $ok <br>";
echo "Errores SQL: $error <br>";
echo "CURP diferente: $curp_diferente <br>";
echo "No encontrados: $no_encontrado <br>";

echo '<script>
setTimeout(function(){
    location.href="panel_admin.php";
}, 4000);
</script>';

$act_c = $mysqli->query("
    UPDATE alumno a
    JOIN cuatrimestre c_new 
        ON c_new.id_cuatrimestre = a.cuatrimestre - 1
    SET a.cuatrimestre = a.cuatrimestre - 1
    WHERE a.status = 1
");


?>