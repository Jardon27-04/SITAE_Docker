<?php

session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'Estudiante') {
    header("location:login_alumno.php");
  
}
 $id_alumno = $_SESSION['id_alumno'];
    $nombre_alumno = $_SESSION['nombre_alumno'];

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="funciones.js"></script>
    <link rel="stylesheet" href="../Rentas/styles.css">
    	<title>Agregar Talle</title>

	 
</head>

<body>
    <div>
	<?php
//	require("nav.php")
		?>

	<h1><div> Nuevo Taller</div></h1>
	<form >
	  <input type="hidden" name="id_alumno" id="id_alumno" value="<?php echo $id_alumno; ?>">
            <p>


        <input type="hidden" name="nombre_alumno" id="nombre_alumno" value="<?php echo $nombre_alumno; ?>">
            <p>
<select name="status" id="status" style="display:none;">
    <option value="0">SELECCIONA:</option>
    <?php
    require('conexion.php');
    $consulta = $mysqli->query("SELECT * FROM status");
    while ($dato = mysqli_fetch_array($consulta)) {

        $selected = ($dato['id_status'] == 1) ? 'selected' : '';
        ?>
        <option value="<?php echo $dato['id_status']; ?>" <?php echo $selected; ?>>
            <?php echo $dato['nombre_status']; ?>
        </option>
    <?php } ?>
</select>
<p>

		<input type="button" name="enviar" value="Guardar" onclick="Insertar_A()">
        <div id="respuesta"></div>

	</form>
</div>
</body>

</html>