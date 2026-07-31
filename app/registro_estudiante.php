<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Importar Estudiante</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;    
    background: linear-gradient(135deg,  #0b4614, #0a3511a1);

}

.card{
    background:white;
    width:100%;
    max-width:480px;
    padding:35px;
    border-radius:20px;
    box-shadow:0 20px 50px rgba(0,0,0,0.2);
    animation:fadeIn .5s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

.card h2{
    text-align:center;
    margin-bottom:10px;
    color:#333;
}

.card p{
    text-align:center;
    color:#777;
    font-size:14px;
    margin-bottom:25px;
}

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    margin-bottom:6px;
    font-weight:600;
    color:#444;
}

input[type="file"]{
    width:100%;
    padding:10px 12px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
    transition:.3s;
}

input[type="file"]:focus{
    border-color:#2a5298;
    outline:none;
    box-shadow:0 0 0 2px rgba(42,82,152,.2);
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:30px;
    background:#2a5298;
    color:white;
    font-weight:bold;
    font-size:15px;
    cursor:pointer;
    transition:.3s;
}

button:hover{
    background:#1e3c72;
    transform:translateY(-2px);
}

.cancelar{
    background-color:#e60f0f;
    margin-top:10px;
}

.cancelar:hover{
    background-color:#757575;
}

.footer-note{
    text-align:center;
    font-size:12px;
    color:#888;
    margin-top:15px;
}

@media(max-width:600px){
    .card{
        width:90%;
        padding:25px;
    }
}

</style>
</head>

<body>

<div class="card">

    <h2>Importar Estudiante</h2>
    <p>Sube el archivo Excel oficial de estudiantes</p>

    <form action="registro_estudiantes.php" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Seleccionar archivo Excel</label>
            <input type="file" name="archivo" accept=".xlsx,.xls" required>
        </div>

        <button type="submit">Importar Estudiante</button>

        <button type="button" class="cancelar" onclick="window.location.href='panel_admin.php'">
            Cancelar
        </button>

    </form>

    <div class="footer-note">
        Solo archivos .xlsx o .xls
    </div>

</div>

</body>
</html>