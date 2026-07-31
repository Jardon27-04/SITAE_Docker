<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'Estudiante') {
    header("location:login.php");
    exit;
}

$id_alumno = $_SESSION['id_alumno'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modificar Estudiante</title>
<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG"  style="border-radius: 50%;">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background: rgb(219, 218, 207);
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
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:6px;
    font-weight:600;
    color:#444;
}

input[type="text"]{
    width:100%;
    padding:10px 12px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
    transition:.3s;
}

input[type="text"]:focus{
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
    background:#e60f0f;
    margin-top:10px;
}

.cancelar:hover{
    background:#757575;
}

#respuesta{
    margin-top:10px;
    text-align:center;
    color:green;
    font-weight:bold;
}

.footer-note{
    font-size:12px;
    color:#777;
    margin-top:-1px;
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

<h2>Modificar Estudiante</h2>
<p>Actualiza tu información personal</p>

<form method="POST" action="actualiza_estudiante.php">

<?php
require("conexion.php");

if ($id_alumno === '') {
    echo "<p>ID de alumno no proporcionado.</p>";
} else {

$consulta = $mysqli->query("SELECT * FROM alumno WHERE id_alumno='". $mysqli->real_escape_string($id_alumno) ."'");

if ($consulta && $consulta->num_rows > 0) {
$row = $consulta->fetch_assoc();
?>

<input type="hidden" name="id_alumno" value="<?php echo htmlspecialchars($row['id_alumno']); ?>">

<div class="form-group">
<label>Nombre</label>
<input type="text" name="nombre_alumno" value="<?php echo htmlspecialchars($row['nombre_alumno']); ?>" required>
</div>

<div class="form-group">
<label>CURP</label>
<input type="text" name="curp" value="<?php echo htmlspecialchars($row['curp']); ?>" required>
</div>

<div class="form-group">
<label>Correo</label>
<input type="text" name="correo" value="<?php echo htmlspecialchars($row['correo']); ?>" required>
</div>

<div class="form-group">
<label>Teléfono</label>
<input type="text" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>" required>
</div>

<div class="form-group">
<label>Matrícula</label>
<input type="text" name="matricula" value="<?php echo htmlspecialchars($row['matricula']); ?>" required>
</div>
    
<div class="footer-note">Para evitar posibles errores en el sistema, debes colocar tu matricula correcta. </br>
  <ul>
    <li>Si es necesario compárala con tu credencial universitaria.</li>
    <li>Es importante para identificarte correctamente dentro del sistema.</li>
</ul>
    </div>
    </p>
 
    
   <?php

$consulta_nv = $mysqli->query("SELECT nivel FROM alumno WHERE id_alumno='$id_alumno'");

    $row2 = $consulta_nv->fetch_assoc();
    $nivelvacioo = $row2 ['nivel'];
    
    if($nivelvacioo == ''){
 ?>
      

<div class="form-group">
<label>Nivel Educativo:</label>
<select name="nivel">
<option value="<?php echo htmlspecialchars($row['nivel']); ?>"><?php echo htmlspecialchars($row['nivel']); ?></option>
<option value="TSU">Tecnico Superior Universitario</option>
<option value="ING/LIC">Ingenieria/Licenciatura</option>
</select>
</div>



        <?php
}

$consulta_cuatri = $mysqli->query("SELECT cuatrimestre FROM alumno WHERE id_alumno='$id_alumno'");

    $row1 = $consulta_cuatri->fetch_assoc();
    $cuatri12 = $row1['cuatrimestre'];
    
    if($cuatri12 == '12'){
 ?>
        <label>Cuatrimestre:</label>
<select name="cuatrimestre">
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
        <?php
}
?>
    
    
    
   
    
    
   <?php 
    
$consulta_g = $mysqli->query("SELECT grupo FROM alumno WHERE id_alumno='$id_alumno'");

    $rowg = $consulta_g->fetch_assoc();
    $gvacio = $rowg['grupo'];
    
    if($gvacio == ''){
 ?>
        
<label>Grupo:</label>
<select name="grupo">
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
    
<?php } ?>
    
    
    
    
    
     <?php 
    
$carrera_vacia = $mysqli->query("SELECT carrera FROM alumno WHERE id_alumno='$id_alumno'");

    $rowc = $carrera_vacia->fetch_assoc();
    $cvacia = $rowc['carrera'];
    
    if($cvacia == ''){
 ?>
    
     
<label>Carrera:</label>
<select name="carrera">
<option value="">SELECCIONA</option>
<option value="Gastronomia">Gastronomía</option>
<option value="Turismo">Turismo</option>
<option value="Operaciones Comerciales Internacionales">Operaciones Comerciales Internacionales</option>
<option value="Agricultura Sustentable y Protegida">Agricultura Sustentable y Protegida</option>
<option value="Tecnologias de la Informacion">Tecnologías de la Información</option>
</select>
    
    
 <?php } ?>
    </p>
    
    
    
<button type="submit">Actualizar Datos</button>

<button type="button" class="cancelar" onclick="window.location.href='panel_alumno.php'">
Cancelar
</button>

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