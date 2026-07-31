<?php
session_start();
if (!isset($_SESSION['correo']) || !in_array($_SESSION['rol'], [1, 3])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nuevo Docente</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG"  style="border-radius: 50%;">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="funciones.js?v=1" defer></script>

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

#respuesta{
    margin-top:15px;
    text-align:center;
    font-weight:bold;
}

.cancelar {
    background-color: #e60f0f;
    color: white;
}

.cancelar:hover {
    background-color: #757575;
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

<h1>Nuevo Administrador</h1>

<form>

<label>Número de Empleado:</label>
<input type="text" id="num_empleado">

<label>Nombre:</label>
<input type="text" id="nombre">

<label>Apellido Paterno:</label>
<input type="text" id="apellidop">

<label>Apellido Materno:</label>
<input type="text" id="apellidom">

<label>Teléfono:</label>
<input type="text" id="telefono">

<label>Correo:</label>
<input type="text" id="correo">

<select name="rol" id="rol" style="display:none;">
<?php
require('conexion.php');
$consulta = $mysqli->query("SELECT * FROM rol");
while ($dato = mysqli_fetch_array($consulta)) {
    $selected = ($dato['id_rol'] == 1) ? 'selected' : '';
?>
<option value="<?php echo $dato['id_rol']; ?>" <?php echo $selected; ?>>
<?php echo $dato['nombre_rol']; ?>
</option>
<?php } ?>
</select>

<select name="status" id="status" style="display:none;">
<?php
$consulta = $mysqli->query("SELECT * FROM status");
while ($dato = mysqli_fetch_array($consulta)) {
    $selected = ($dato['id_status'] == 1) ? 'selected' : '';
?>
<option value="<?php echo $dato['id_status']; ?>" <?php echo $selected; ?>>
<?php echo $dato['nombre_status']; ?>
</option>
<?php } ?>
</select>

<button type="button" onclick="Insertar_U()">Guardar Docente</button>
  <button type="button" class="cancelar" onclick="window.location.href='panel_admin.php'">
            Cancelar
        </button>
<div id="respuesta"></div>

</form>

</div>

</body>
</html>
