<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modificar Docente</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

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
    padding:20px;
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
    margin-top:14px;
    font-weight:600;
    color:#444;
}

input[type="text"]{
    width:100%;
    padding:10px 12px;
    margin-top:5px;
    border:1px solid #ccc;
    border-radius:10px;
    font-size:14px;
    transition:.3s;
}

input:focus{
    border-color:#2a5298;
    outline:none;
    box-shadow:0 0 0 3px rgba(42,82,152,.2);
}

input[type="submit"]{
    width:100%;
    margin-top:22px;
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

input[type="submit"]:hover{
    background:#1e3c72;
    transform:translateY(-2px);
}

.cancelar{
    width:100%;
    margin-top:12px;
    padding:12px;
    border:none;
    border-radius:30px;
    background:#e60f0f;
    color:white;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.cancelar:hover{
    background:#757575;
}

#respuesta{
    margin-top:15px;
    text-align:center;
    font-weight:bold;
}

p{
    margin-top:10px;
    text-align:center;
    font-weight:bold;
    color:#c00;
}

@media(max-width:600px){
    .container{
        width:95%;
        padding:25px;
    }
}

</style>
</head>

<body>

<div class="container">

<h1>Modificar Docente</h1>

<form method="POST" action="update_docente.php">

<?php
require("conexion.php");

$id_docente = $_POST['id_docente'] ?? '';

if ($id_docente == '') {

    echo "<p>ID de docente no encontrado.</p>";

} else {

    $consulta = $mysqli->query(
        "SELECT * FROM docentes WHERE id_docente='".$mysqli->real_escape_string($id_docente)."'"
    );

    if ($consulta && $consulta->num_rows > 0) {

        $row = $consulta->fetch_assoc();
?>

<input type="hidden" name="id_docente"
value="<?php echo htmlspecialchars($row['id_docente']); ?>">

<label>Número de Empleado:</label>
<input type="text" name="num_empleado"
value="<?php echo htmlspecialchars($row['num_empleado']); ?>" required>

<label>Nombre:</label>
<input type="text" name="nombre"
value="<?php echo htmlspecialchars($row['nombre']); ?>" required>

<label>Teléfono:</label>
<input type="text" name="telefono"
value="<?php echo htmlspecialchars($row['telefono']); ?>" required>

<label>Correo:</label>
<input type="text" name="correo"
value="<?php echo htmlspecialchars($row['correo']); ?>" required>

<input type="submit" value="Actualizar Datos">

<button type="button" class="cancelar"
onclick="window.location.href='panel_admin.php'">
Cancelar
</button>

<div id="respuesta"></div>

<?php

    } else {

        echo "<p>Docente no encontrado.</p>";

    }
}
?>

</form>

</div>

</body>
</html>