<?php
session_start();


if (!isset($_SESSION['correo']) || !in_array($_SESSION['rol'], [1, 3])) {
    header("Location: login.php");
    exit;
}

require('conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modificar Fecha</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">
    

<style>
body {
    font-family: Tahoma, sans-serif;
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
    margin-top: 15px;
    margin-bottom: 15px;
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
    margin-bottom: -5px;

}

label {
    display: block;
    margin-top: 10px;
    font-weight: 600;
    color: #333;
}

input[type="date"] {
    width: 95%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: all 0.3s ease;
}

input[type="date"]:focus {
    border-color: #1976d2;
    box-shadow: 0 0 5px rgba(25, 118, 210, 0.4);
}

input[type="submit"], .cancelar {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 10px;
    font-size: 16px;
    font-weight: bold;
    transition: background 0.3s;
}

input[type="submit"] {
    background-color: #1e3c72;
    color: white;
}

input[type="submit"]:hover {
    background-color: #1565c0;
}

.cancelar {
    background-color: #e60f0f;
    color: white;
}

.cancelar:hover {
    background-color: #757575;
}

#respuesta {
    margin-top: 15px;
    text-align: center;
    color: green;
    font-weight: bold;
}

.container p{
    text-align:center;
    color:#777;
    font-size:14px;
    margin-bottom:15px;
}
 

@media (max-width: 600px) {
    .container {
        padding: 20px;
        width: 85%;
    }
}
</style>

</head>
<body>

<div class="container">
    <h1>Modificar Fecha</h1>
 <p>Actualiza la fecha limite para liberar</p>
    <form method="POST" action="add_limites.php">

        <label>Fecha Límite de Liberacion</label>
        <input type="date" id="fecha_limite" name="fecha_limite" required>

        <input type="submit" value="Actualizar Fecha">

        <button type="button" class="cancelar" onclick="window.location.href='panel_admin.php'">
            Cancelar
        </button>

        <div id="respuesta"></div>

    </form>
</div>

</body>
</html>