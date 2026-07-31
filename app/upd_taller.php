<?php
require("conexion.php");

$id_taller = $_GET['id_taller'] ?? '';
$row = null;
$horarios = [];

if ($id_taller !== '') {

    $id_taller = $mysqli->real_escape_string($id_taller);

 
    $consulta = $mysqli->query("SELECT * FROM talleres WHERE id_taller = '$id_taller'");

    if ($consulta && $consulta->num_rows > 0) {
        $row = $consulta->fetch_assoc();
    }
 
    $res = $mysqli->query("
        SELECT dia, 
        TIME_FORMAT(hora_inicio, '%H:%i') as hora_inicio,
        TIME_FORMAT(hora_fin, '%H:%i') as hora_fin
        FROM horarios 
        WHERE id_taller = '$id_taller'
    ");

    if ($res) {
        while($h = $res->fetch_assoc()){
            $horarios[$h['dia']] = $h;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modificar Taller</title>
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
	margin-left: -12px;
}

@keyframes fadeIn {
	from { opacity: 0; transform: translateY(10px); }
	to { opacity: 1; transform: translateY(0); }
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

input[type="submit"] {
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
}

input[type="submit"]:hover {
	background-color: #1565c0;
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
</style>
</head>

<body>

<div>
<div class="container">

<h1>Modificar Taller</h1>

<?php if ($row) { ?>

<form method="POST" action="update_taller.php">

<input type="hidden" name="id_taller" value="<?php echo $row['id_taller']; ?>">

Nombre de Taller:
<input type="text" name="nombre_taller" value="<?php echo $row['nombre_taller']; ?>">

<label>Grupo:</label>
<select name="grupo">
<option value="<?php echo $row['grupo']; ?>"><?php echo $row['grupo']; ?></option>
<option value="">***********</option>
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

<p><b>Días:</b></p>

<?php
$dias = ["Lunes","Martes","Miercoles","Jueves","Viernes"];

foreach ($dias as $d){

    $checked = isset($horarios[$d]) ? "checked" : "";
    $display = isset($horarios[$d]) ? "block" : "none";

    $hi = $horarios[$d]['hora_inicio'] ?? "";
    $hf = $horarios[$d]['hora_fin'] ?? "";

    echo "
    <label>
        <input type='checkbox' name='dia[]' value='$d' $checked onchange='toggleHora(this,\"$d\")'> $d
    </label>

    <div id='hora_$d' style='display:$display; margin-left:20px;'>

        Hora inicio:
        <select name='horai[$d]'>
            <option value=''>SELECCIONA</option>
            <option value='12:00' ".($hi=='12:00'?'selected':'').">12:00PM</option>
            <option value='13:00' ".($hi=='13:00'?'selected':'').">13:00PM</option>
            <option value='14:00' ".($hi=='14:00'?'selected':'').">14:00PM</option>
            <option value='15:00' ".($hi=='15:00'?'selected':'').">15:00PM</option>
            <option value='16:00' ".($hi=='16:00'?'selected':'').">16:00PM</option>
            <option value='17:00' ".($hi=='17:00'?'selected':'').">17:00PM</option>
        </select>

        Hora fin:
        <select name='horaf[$d]'>
            <option value=''>SELECCIONA</option>
            <option value='13:00' ".($hf=='13:00'?'selected':'').">13:00PM</option>
            <option value='14:00' ".($hf=='14:00'?'selected':'').">14:00PM</option>
            <option value='15:00' ".($hf=='15:00'?'selected':'').">15:00PM</option>
            <option value='16:00' ".($hf=='16:00'?'selected':'').">16:00PM</option>
            <option value='17:00' ".($hf=='17:00'?'selected':'').">17:00PM</option>
            <option value='18:00' ".($hf=='18:00'?'selected':'').">18:00PM</option>
        </select>

    </div>
    ";
}
?>

<p>

Cupo:
<input type="text" name="cantidad_inscritos" value="<?php echo $row['cantidad_inscritos']; ?>">

<p>

Comentarios:
<input type="text" name="comentarios" value="<?php echo $row['comentarios']; ?>">

<input type="submit" value="Actualizar Datos">

<button type="button" class="cancelar" onclick="window.location.href='panel_docente.php'">
Cancelar
</button>

</form>

<?php } else { ?>
<p style="color:red;">Taller no encontrado</p>
<?php } ?>

</div>
</div>

<script>
function toggleHora(check, dia){
	document.getElementById("hora_"+dia).style.display = check.checked ? "block" : "none";
}
</script>

</body>
</html>