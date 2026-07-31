<?php
require("conexion.php");

$id_taller = $_POST['id_taller'];
$nombre_taller = $_POST['nombre_taller'];
$grupo = $_POST['grupo'];
$cantidad_inscritos = $_POST['cantidad_inscritos'];
$comentarios = $_POST['comentarios'];

$dias = $_POST['dia'] ?? [];
$horai = $_POST['horai'] ?? [];
$horaf = $_POST['horaf'] ?? [];
 
$update = $mysqli->query("
UPDATE talleres SET 
nombre_taller = '$nombre_taller',
grupo = '$grupo',
hora = '',         
dia = '',         
cantidad_inscritos = '$cantidad_inscritos',
comentarios = '$comentarios'
WHERE id_taller = '$id_taller'
");

if (!$update) {
    echo "Error al actualizar datos";
    exit;
}
 
$mysqli->query("DELETE FROM horarios WHERE id_taller = '$id_taller'");
 
foreach($dias as $d){

    $hi = $horai[$d] ?? '';
    $hf = $horaf[$d] ?? '';

    if ($hi == '' || $hf == '') continue;

    if ($hi == $hf) {
        echo "Error: $d tiene misma hora inicio y fin";
       echo '<script>
setTimeout(function(){
location.href="panel_docente.php";
}, 1500);
</script>';
        exit;
    }

    if ($hi >= $hf) {
        echo "Error: $d tiene horario inválido";
        echo '<script>
setTimeout(function(){
location.href="panel_docente.php";
}, 1500);
</script>';
        exit;
    }

    $mysqli->query("
    INSERT INTO horarios (id_taller, dia, hora_inicio, hora_fin)
    VALUES ('$id_taller', '$d', '$hi', '$hf')
    ");
}

echo "Actualización exitosa";
echo '<script>
setTimeout(function(){
    location.href="panel_docente.php";
},1000);
</script>';
?>