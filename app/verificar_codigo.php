<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="funciones.js"></script>
    <link rel="stylesheet" href="../Rentas/styles.css">
    <title>Restablecer Contraseña</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
	<style>
		body {
			font-family: Tahoma, sans-serif;
		   background: rgb(219, 218, 207);
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
h1 {
			text-align: center;
			color:#1e3c72;
            margin-bottom: 25px;
		}
 
        .footer-note{
    font-size:12px;
    color:#777;
    margin-top:5px;
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
<div class="container">
	<?php
require("conexion.php");

$codigo = $_GET['codigo'];
$id = $_GET['id'];
$tipo = $_GET['tipo'];

$valido = false;

if ($tipo == "alumno") {

    $consultaAlumno = $mysqli->query("SELECT codigo FROM alumno WHERE id_alumno = '$id'");

    if ($consultaAlumno->num_rows > 0) {
        $fila = $consultaAlumno->fetch_assoc();
        if ($fila['codigo'] == $codigo) {
            $valido = true;
        }
    }

}

if ($tipo == "docente") {

    $consultaDocente = $mysqli->query("SELECT codigo FROM docentes WHERE id_docente = '$id'");

    if ($consultaDocente->num_rows > 0) {
        $fila = $consultaDocente->fetch_assoc();
        if ($fila['codigo'] == $codigo) {
            $valido = true;
        }
    }

}

if ($valido) {
?>
<form method="POST" action="update_p.php">
    <h1> Introduce tu nueva Contraseña</h1>
   <label>Contraseña:</label>

<div style="position:relative;">
 <input type="password" name="password" id="password" minlength="8" maxlength="10" style="padding-right:40px;"required>  
    <i class="fa-solid fa-eye" id="togglePassword"
       style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; color:#666;">
    </i>
</div>

<div id="msgPassword" style="font-size:12px; color:red;"></div>
<div class="footer-note">Máximo 10 caracteres</div>

<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="tipo" value="<?php echo $tipo; ?>">

<input type="submit" name="enviar" value="Guardar">
</form>
<?php
} else {
    echo "<p style='color:red; text-align:center;'>Código incorrecto o no válido.</p>";
         echo '<script>setTimeout(function(){ location.href="login.php"; }, 1500);</script>';

}
?>

</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("togglePassword");
    const input = document.getElementById("password");

    toggle.addEventListener("click", function () {
        const type = input.getAttribute("type") === "password" ? "text" : "password";
        input.setAttribute("type", type);

        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
});
    
    
const password = document.getElementById("password");
const msg = document.getElementById("msgPassword");

password.addEventListener("input", function () {
    if (password.value.length < 8) {
        msg.textContent = "La contraseña debe tener al menos 8 caracteres";
    } else {
        msg.textContent = "";
    }
});
</script>
</body>
</html>