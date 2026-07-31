<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Modificar Estudiante</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">
    
		<style>
	*{
		box-sizing: border-box;
	}

	body {
		font-family: Tahoma, sans-serif;
		  background: rgb(219, 218, 207);
		margin: 0;
		padding: 15px;
		display: flex;
		justify-content: center;
		align-items: center;
		min-height: 100vh;
	}

	.container {
		background-color: #ffffffb8;
		padding: 25px;
		border-radius: 25px;
		box-shadow: 0 4px 15px rgba(0,0,0,0.15);
		width: 100%;
		max-width: 500px;
	}

	h1 {
		text-align: center;
		color: #29df69ff;
		margin-bottom: 20px;
		font-size: 1.8rem;
	}

	label {
		display: block;
		margin-top: 15px;
		font-weight: 600;
	}

	input[type="text"],
	select {
		width: 100%;
		padding: 12px;
		margin-top: 5px;
		border: 1px solid #ccc;
		border-radius: 8px;
		font-size: 1rem;
	}

	select {
		background-color: #fff;
	}

	input[type="submit"] {
		width: 100%;
		padding: 14px;
		margin-top: 25px;
		background: #17c88aff;
		color: #fff;
		border: none;
		border-radius: 10px;
		cursor: pointer;
		font-weight: bold;
		font-size: 1rem;
	}

	input[type="submit"]:active {
		transform: scale(0.98);
	}

	#respuesta {
		margin-top: 10px;
		text-align: center;
		color: green;
		font-weight: bold;
	}

	@media (max-width: 480px) {
		h1 {
			font-size: 1.5rem;
		}

		.container {
			padding: 20px;
			border-radius: 20px;
		}
	}
	</style>
</head>
<body>
	<div class="container">
		<h1>Modificar Estudiante</h1>

		<form method="POST" action="update_datos.php">
		<?php
		require("conexion.php");
		$id_alumno = $_GET['id_alumno'] ?? '';
		if ($id_alumno === '') {
		    echo "<p>ID de alumno no proporcionado.</p>";
		} else {
		    $consulta = $mysqli->query("SELECT * FROM alumno WHERE id_alumno = '". $mysqli->real_escape_string($id_alumno) ."'");
		    if ($consulta && $consulta->num_rows > 0) {
		        $row = $consulta->fetch_assoc();
		?>

			<input type="hidden" name="id_alumno" value="<?php echo htmlspecialchars($row['id_alumno']); ?>">

			<label>Nombre:</label>
			<input type="text" name="nombre_alumno" value="<?php echo htmlspecialchars($row['nombre_alumno']); ?>" required>

			<label>CURP:</label>
			<input type="text" name="curp" value="<?php echo htmlspecialchars($row['curp']); ?>" required>

			<label>Correo:</label>
			<input type="text" name="correo" value="<?php echo htmlspecialchars($row['correo']); ?>" required>
			
			<label>Telefono:</label>
			<input type="text" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>" required>

			<input type="submit" value="Actualizar Datos" >

			<div id="respuesta"></div>

		<?php
		    } else {
		        echo "<p>Alumno no encontrado.</p>";
		    }
		}
		?>
		</form>
	</div>
</body>
</html>
