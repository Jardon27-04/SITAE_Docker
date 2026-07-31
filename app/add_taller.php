<?php

session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== '2') {
    header("Location: login.php");
    exit;
}
  $rol = $_SESSION['rol'];
    $id_docente = $_SESSION['id_docente'];
    $nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="funciones.js?v=1" defer></script>

    <link rel="stylesheet" href="CSS/panel.css">  
   
    	<title>Agregar Taller</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

	<style>
		body {
			font-family:  Tahoma, sans-serif;
			background: rgb(219, 218, 207);
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
		}

		.container {
		background-color: #ffffffb8;
			padding: 30px 40px;
			border-radius: 50px;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
			width: 100%;
			max-width: 500px;
			animation: fadeIn 0.5s ease-in-out;
			margin-left: -12px;
			
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
				transform: translateY(10px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		h1 {
			text-align: center;
			 color:#4f6f32;
			margin-bottom: 25px;
		}

		label {
			display: block;
			margin-top: 10px;
			font-weight: 600;
			color: #333;
		}

		input[type="text"],
		select {
			width: 95%;
			padding: 10px;
			margin-top: 5px;
			border: 1px solid #ccc;
			border-radius: 8px;
			outline: none;
			transition: all 0.3s ease;
		}

		input[type="text"]:focus,
		select:focus {
			border-color: #1976d2;
			box-shadow: 0 0 5px rgba(25, 118, 210, 0.4);
		}

		input[type="button"] {
			width: 100%;
			background-color: #17c88aff;
			color: white;
			padding: 12px;
			border: none;
			border-radius: 8px;
			cursor: pointer;
			margin-top: 20px;
			font-size: 16px;
			font-weight: bold;
			transition: background 0.3s;
		}

		input[type="button"]:hover {
			background-color: #1565c0;
		}

		
		#respuesta {
			margin-top: 15px;
			text-align: center;
			color: green;
			font-weight: bold;
		}

		.cancelar {
    width: 100%;
    background-color: #e60f0f;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 10px;
    font-size: 16px;
    font-weight: bold;
}

.cancelar:hover {
    background-color: #757575;
}


.horas{
display:none;
margin-left:10px;
}



		@media (max-width: 600px) {
			.container {
				padding: 20px;
                width: 95%;
			}
		}
	</style>
</head>

<body>
    

    <div> 
	 	<div class="container">
            
	<h1><div> Nuevo Taller</div></h1>
	<form>

Nombre de Taller: <input type="text" name="nombre_taller" id="nombre_taller"  placeholder="Futbool">
		<p>

          <input type="hidden" name="docente_id" id="docente_id" value="<?php echo $id_docente; ?>">
            <p>
<p>
	
<p>Días y horarios:</p>

<label>
<input type="checkbox" class="diaCheck" value="Lunes"> Lunes
</label>
<div class="horas" id="horas_Lunes">
Inicio:
<select class="horai">
<option value="12:00">12:00PM</option>
<option value="13:00">13:00PM</option>
<option value="14:00">14:00PM</option>
<option value="15:00">15:00PM</option>
<option value="16:00">16:00PM</option>
<option value="17:00">17:00PM</option>
<option value="18:00">18:00PM</option>
</select>
Fin:
<select class="horaf">
<option value="12:00">12:00PM</option>
<option value="13:00">13:00PM</option>
<option value="14:00">14:00PM</option>
<option value="15:00">15:00PM</option>
<option value="16:00">16:00PM</option>
<option value="17:00">17:00PM</option>
<option value="18:00">18:00PM</option>
</select>
</div>

<label>
<input type="checkbox" class="diaCheck" value="Martes"> Martes
</label>
<div class="horas" id="horas_Martes">
Inicio:
<select class="horai">
<option value="12:00">12:00PM</option>
<option value="13:00">13:00PM</option>
<option value="14:00">14:00PM</option>
<option value="15:00">15:00PM</option>
<option value="16:00">16:00PM</option>
<option value="17:00">17:00PM</option>
<option value="18:00">18:00PM</option>
</select>
Fin:
<select class="horaf">
<option value="12:00">12:00PM</option>
<option value="13:00">13:00PM</option>
<option value="14:00">14:00PM</option>
<option value="15:00">15:00PM</option>
<option value="16:00">16:00PM</option>
<option value="17:00">17:00PM</option>
<option value="18:00">18:00PM</option>
</select>
</div>

<label>
<input type="checkbox" class="diaCheck" value="Miercoles"> Miércoles
</label>
<div class="horas" id="horas_Miercoles">
Inicio:
<select class="horai">
<option value="12:00">12:00PM</option>
<option value="13:00">13:00PM</option>
<option value="14:00">14:00PM</option>
<option value="15:00">15:00PM</option>
<option value="16:00">16:00PM</option>
<option value="17:00">17:00PM</option>
<option value="18:00">18:00PM</option>
</select>
Fin:
<select class="horaf">
<option value="12:00">12:00PM</option>
<option value="13:00">13:00PM</option>
<option value="14:00">14:00PM</option>
<option value="15:00">15:00PM</option>
<option value="16:00">16:00PM</option>
<option value="17:00">17:00PM</option>
<option value="18:00">18:00PM</option>
</select>
</div>

<label>
<input type="checkbox" class="diaCheck" value="Jueves"> Jueves
</label>
<div class="horas" id="horas_Jueves">
Inicio:
<select class="horai">
<option value="12:00">12:00PM</option>
<option value="13:00">13:00PM</option>
<option value="14:00">14:00PM</option>
<option value="15:00">15:00PM</option>
<option value="16:00">16:00PM</option>
<option value="17:00">17:00PM</option>
<option value="18:00">18:00PM</option>
</select>
Fin:
<select class="horaf">
<option value="12:00">12:00PM</option>
<option value="13:00">13:00PM</option>
<option value="14:00">14:00PM</option>
<option value="15:00">15:00PM</option>
<option value="16:00">16:00PM</option>
<option value="17:00">17:00PM</option>
<option value="18:00">18:00PM</option>
</select>
</div>

<label>
<input type="checkbox" class="diaCheck" value="Viernes"> Viernes
</label>
<div class="horas" id="horas_Viernes">
Inicio:
<select class="horai">
<option value="12:00">12:00PM</option>
<option value="13:00">13:00PM</option>
<option value="14:00">14:00PM</option>
<option value="15:00">15:00PM</option>
<option value="16:00">16:00PM</option>
<option value="17:00">17:00PM</option>
<option value="18:00">18:00PM</option>
</select>
Fin:
<select class="horaf">
<option value="12:00">12:00PM</option>
<option value="13:00">13:00PM</option>
<option value="14:00">14:00PM</option>
<option value="15:00">15:00PM</option>
<option value="16:00">16:00PM</option>
<option value="17:00">17:00PM</option>
<option value="18:00">18:00PM</option>
</select>
</div>
       
<p>

<select name="periodo" id="periodo" style="display:none;">
    <option value="0">SELECCIONA:</option>
    <?php
    require('conexion.php');
    $consulta = $mysqli->query("SELECT * FROM periodo WHERE status = '1' ");
    while ($dato = mysqli_fetch_array($consulta)) {

        $selected = ($dato['status'] == 1) ? 'selected' : '';
        ?>
        <option value="<?php echo $dato['id_periodo']; ?>" <?php echo $selected; ?>>
            <?php echo $dato['nombre_p']; ?>
        </option>
    <?php } ?>
</select>
<p>


Grupo: <select name="grupo" id="grupo"  placeholder="A">
    <option value="0">SELECCIONA:</option>
    <option value="0">***********</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
	<option value="E">E</option>
	<option value="F">F</option>
	<option value="G">G</option>
	<option value="H">H</option>
	<option value="I">I</option>
	<option value="J">J</option>
	<option value="K">K</option>
	

</select>
<p>

Cupo: <input type="text" name="cantidad_inscritos" id="cantidad_inscritos"  placeholder="50">
<p>

<?php
$anio_activo = $mysqli->query("SELECT id_anio FROM anios WHERE status = '1' LIMIT 1");
$anio_id = ($anio_activo->num_rows > 0) ? $anio_activo->fetch_assoc()['id_anio'] : 0;
?>
<input type="hidden" name="anio" id="anio" value="<?php echo $anio_id; ?>">

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

		Comentarios: <input type="text" name="comentarios" id="comentarios"  placeholder="Agrega un Comentario">
<p>
	<input type="button" name="enviar" value="Guardar" onclick="Insertar_T()">

<button type="button" class="cancelar" onclick="window.location.href='panel_docente.php'">
            Cancelar
        </button>

        <div id="respuesta"></div>

	</form>
    </div>    
</div>
 
<script>
document.querySelectorAll('.diaCheck').forEach(check=>{
check.addEventListener('change',function(){
document.getElementById('horas_'+this.value).style.display = this.checked?'block':'none';
});
});
</script>
</body>

</html>