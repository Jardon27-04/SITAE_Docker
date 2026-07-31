<?php
/*
session_start();
if (@!$_SESSION['correo']) {
    header("location:../Usuarios/login.php");
    $rol = $_SESSION['rol'];
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="funciones.js"></script>
    <link rel="stylesheet" href="../Rentas/styles.css">
    	<title>Restablecer Correo</title>
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
		    color:#1e3c72;
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

		@media (max-width: 600px) {
			.container {
				 
				margin: auto;
                width: 60%;
				height: 60vh;
				
			}
			
			 h1 {
			 
			margin-top: 75px;
			margin-bottom: 60px;

		}


		}
	</style>
</head>

<body>
    <div>
	<?php
//	require("nav.php")
		?>
	<div class="container">
	<h1><div> Restablecer Cuenta</div></h1>
<form name="form" method="GET" action="upd_pass.php">
		 
     Introduce tu correo, matricula o numero de empleado<p><input type="text" name="dato">
	 <p>
		<input type="submit" name="enviar" value="Eviar Codigo">
        <div id="respuesta"></div>

	</form>
</div>
 </div>
</body>

</html>