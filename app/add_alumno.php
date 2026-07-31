<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nuevo Estudiante</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG"  style="border-radius: 50%;">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="funciones.js?v=1" defer></script>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', Tahoma, sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
      background: rgb(219, 218, 207);

}

.container{
    width:100%;
    max-width:550px;
    background:white;
    padding:35px 40px;
    border-radius:20px;
    box-shadow:0 20px 50px rgba(0,0,0,0.25);
    animation:fadeIn .5s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

h1{
    text-align:center;
    margin-bottom:25px;
     color:#4f6f32;
}

label{
    display:block;
    margin-top:12px;
    font-weight:600;
    color:#444;
}

input[type="text"],
input[type="password"],
select{
    width:100%;
    padding:10px 12px;
    margin-top:5px;
    border:1px solid #ccc;
    border-radius:10px;
    font-size:14px;
    transition:.3s;
}

input:focus,
select:focus{
    border-color:#2a5298;
    outline:none;
    box-shadow:0 0 0 3px rgba(42,82,152,.2);
}

button{
    width:100%;
    margin-top:20px;
    padding:12px;
    border:none;
    border-radius:30px;
    background:#2a5298;
    color:white;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

button:hover{
    background:#1e3c72;
    transform:translateY(-2px);
}

.footer-note{
    font-size:12px;
    color:#777;
    margin-top:5px;
}

#respuesta{
    margin-top:15px;
    text-align:center;
    font-weight:bold;
}

.login-link{
    text-align:center;
    margin-top:15px;
    font-size:14px;
}

.login-link a{
   color:#4f6f32;
    text-decoration:none;
    font-weight:600;
}

.login-link a:hover{
    text-decoration:underline;
}

@media(max-width:600px){
    .container{
        width:90%;
        padding:25px;
    }
}

</style>
</head>

<body>

<div class="container">

<h1>Nuevo Estudiante</h1>

<form>

<label>Nombre:</label>
<input type="text" id="nombre_alumno" required>

<label>Apellido Paterno:</label>
<input type="text" id="apellidop" required>

<label>Apellido Materno:</label>
<input type="text" id="apellidom" required>

<label>CURP:</label>
<input type="text" id="curp">

<label>Matrícula:</label>
<input type="text" id="matricula">   
    <div class="footer-note">Para evitar posibles errores en el sistema, debes colocar tu matricula correcta. </br>
  <ul>
    <li>Si es necesario compárala con tu credencial universitaria.</li>
    <li>Es importante para identificarte correctamente dentro del sistema.</li>
</ul>
<label>Cuatrimestre:</label>
<select id="cuatrimestre">
<option value="0">SELECCIONA:</option>
<?php
require('conexion.php');
$consulta = $mysqli->query("SELECT c.id_cuatrimestre,c.nombre_cuatrimestre 
FROM cuatrimestre c
INNER JOIN periodo p ON c.periodo = p.id_periodo 
WHERE p.status = '1'");
while ($dato = mysqli_fetch_array($consulta)) {
?>
<option value="<?php echo $dato['id_cuatrimestre']; ?>">
<?php echo $dato['nombre_cuatrimestre']; ?>
</option>
<?php } ?>
</select>

<label>Grupo:</label>
<select id="grupo">
<option value="0">SELECCIONA:</option>
<?php
$consulta = $mysqli->query("SELECT * FROM grupo");
while ($dato = mysqli_fetch_array($consulta)) {
?>
<option value="<?php echo $dato['id_grupo']; ?>">
<?php echo $dato['nombre_grupo']; ?>
</option>
<?php } ?>
</select>

<label>Carrera:</label>
<select id="carrera">
<option value="">SELECCIONA</option>
<option value="Gastronomia">Gastronomía</option>
<option value="Turismo">Turismo</option>
<option value="Operaciones Comerciales Internacionales">Operaciones Comerciales Internacionales</option>
<option value="Agricultura Sustentable y Protegida">Agricultura Sustentable y Protegida</option>
<option value="Tecnologias de la Informacion">Tecnologías de la Información</option>
</select>

<label>Telefono:</label>
<input type="text" id="telefono">

<label>Correo:</label>
<input type="text" id="correo">
<label>Contraseña:</label>

<div style="position:relative;">
    <input type="password" id="password" minlength="8" maxlength="10" style="padding-right:40px;">
    
    <i class="fa-solid fa-eye" id="togglePassword"
       style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; color:#666;">
    </i>
</div>
<div id="msgPassword" style="font-size:12px; color:red;"></div>

<div class="footer-note">Máximo 10 caracteres</div>

<button type="button" onclick="Insertar_A()">Guardar Alumno</button>

<div id="respuesta"></div>

</form>

<div class="login-link">
¿Ya estás registrado? <a href="login.php">Iniciar Sesión</a>
</div>

</div>

<script>
const toggle = document.getElementById("togglePassword");
const input = document.getElementById("password");

toggle.addEventListener("click", function () {
    const type = input.getAttribute("type") === "password" ? "text" : "password";
    input.setAttribute("type", type);

    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");
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
