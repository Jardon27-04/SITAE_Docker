<?php

require('conexion.php');

$periodo = $_POST['periodo'] ?? '';

echo '<option value="">Todos</option>';
echo '<option value="">*******************</option>';

if($periodo != ''){

    $filtro = explode('-', $periodo);

    $id_periodo = $filtro[0];
    $id_anio = $filtro[1];

    $sql = "
    SELECT *
    FROM talleres
    WHERE periodo = '$id_periodo'
    AND anio = '$id_anio'
    AND status = 2
    ORDER BY nombre_taller
    ";

}else{

    $sql = "
    SELECT *
    FROM talleres
    WHERE status = 1
    ORDER BY nombre_taller
    ";
}

$consulta = $mysqli->query($sql);

while($dato = mysqli_fetch_array($consulta)){

?>

<option value="<?php echo $dato['id_taller']; ?>">

<?php echo $dato['nombre_taller'].' - '.$dato['grupo']; ?>

</option>

<?php } ?>