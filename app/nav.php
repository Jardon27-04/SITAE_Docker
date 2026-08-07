<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menú Hamburguesa Responsive</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Times New Roman', Times, serif;
}

body{
    display:flex;
    min-height:100vh;
    background:#f4f6f9;
}

 
.menu-toggle{
    position:fixed;
    top:15px;
    right:15px;
    font-size:24px;
    background:#0a3511;
    color:white;
    padding:10px 12px;
    border-radius:8px;
    cursor:pointer;
    display:none;
    z-index:1100;
}

 
.sidebar{
    width:260px;
    height:100vh;
    background: linear-gradient(135deg, #2d4d1f, #4f6f32, #1f3316);
    background-size: 300% 300%;
    animation: fondoMove 8s ease infinite;
    position:fixed;
    left:0;
    top:0;
    padding-top:20px;
    transition:0.3s ease;
    box-shadow:3px 0 15px rgba(0,0,0,0.1);
    overflow-y:auto;
    z-index:1050;
}

 
.close-btn{
    position:absolute;
    top:15px;
    right:15px;
    font-size:22px;
    color:white;
    cursor:pointer;
    display:none;
}

.sidebar h2{
    color:white;
    text-align:center;
    margin-bottom:30px;
}

.sidebar ul{
    list-style:none;
    padding:0;
}

.sidebar ul li{
    margin:5px 0;
}

.sidebar ul li a,
.sidebar ul li button{
    display:flex;
    align-items:center;
    width:100%;
    text-decoration:none;
    color:white;
    padding:12px 20px;
    transition:0.3s;
    background:none;
    border:none;
    cursor:pointer;
    font-size:15px;
}

.sidebar ul li a i,
.sidebar ul li button i{
    margin-right:15px;
}

.sidebar ul li a:hover,
.sidebar ul li button:hover{
    background:rgba(255,255,255,0.15);
    padding-left:25px;
}

 
.content{
    margin-left:260px;
    padding:40px;
    width:100%;
}

 
.overlay{
    position:fixed;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
    top:0;
    left:0;
    opacity:0;
    visibility:hidden;
    transition:0.3s;
    z-index:1000;
}

.overlay.active{
    opacity:1;
    visibility:visible;
}

.logo-menu{
    width:70px;
    border-radius:50%;
}
 
@media(max-width:600px){

    
    body{
        
    }
.menu-toggle{
    display:block;
}

.sidebar{
    left:auto;
    right:-260px;  
}

.sidebar.active{
    right:0;  
}

.close-btn{
    display:block;
}

.content{
    margin-left:0;
    padding-top:80px;
}

}

</style>
</head>

<body>

<div class="menu-toggle" onclick="toggleMenu()">
    <i class="fas fa-bars"></i>
</div>

<div class="sidebar" id="sidebar">

    <div class="close-btn" onclick="closeMenu()">
        <i class="fas fa-times"></i>
    </div>

    <h2></h2>

    <ul>

        <?php if ($_SESSION['rol'] == "1") { ?>
           <h2>
   <a href="panel_admin.php">
      <img src="img/Logo_UTSEM.JPG" class="logo-menu">
   </a>
</h2>
        <?php } ?>

        <?php if ($_SESSION['rol'] == "2") { ?>
       <h2>
   <a href="panel_docente.php">
      <img src="img/Logo_UTSEM.JPG" class="logo-menu">
   </a>
</h2>
        <?php } ?>
           <?php if ($_SESSION['rol'] == "3") { ?>
           <h2>
   <a href="panel_admin.php">
      <img src="img/Logo_UTSEM.JPG" class="logo-menu">
   </a>
</h2>
        <?php } ?>

        <?php if ($_SESSION['rol'] == "Estudiante") { ?>
           <h2>
   <a href="panel_alumno.php">
      <img src="img/Logo_UTSEM.JPG" class="logo-menu">
   </a>
</h2>
        <?php } ?>

        <?php if ($_SESSION['rol'] == "2") { ?>
            <li><a href="historial_talleres.php"><i class="fas fa-book"></i>Mis talleres</a></li>
            <li><a href="add_taller.php"><i class="fas fa-plus-circle"></i>Registrar Taller</a></li>
             <li>
            <a href="exportar_bd.php"><i class="fas fa-user-shield"></i>Corregir Datos</a>
        </li>
        <?php } ?>

        <?php if ($_SESSION['rol'] == "1") { ?>
            <li><a href="add_docente.php"><i class="fas fa-user-plus"></i>Registrar Docente</a></li>
            
             <?php 
                
                
            $consultar = $mysqli->query("
                SELECT id_docente 
                FROM docentes 
                WHERE rol = '3'
            ");

            if (!$consultar || $consultar->num_rows == 0) {  ?>
         <li>
            <a href="add_superroot.php"><i class="fas fa-user-shield"></i>Agregar Super Administrador</a>
        </li>
        

                
          <?php } ?>
            <li><a href="add_fecha.php"><i class="fas fa-calendar-alt"></i>Fecha Límite de Insc.</a></li>
   <li><a href="add_limite.php"><i class="fas fa-calendar-alt"></i>Fecha Límite de Liberacion</a></li>

           
            

 <li>
                <button onclick="cambiarPeriodo()">
                    <i class="fas fa-sync-alt"></i> Cambiar Periodo
                </button>
            </li>
            
<script>
function cambiarPeriodo() { 
  if (confirm("¿Seguro que deseas cambiar al siguiente periodo?. Toma en cuenta que todos los talleres y sus respectivas inscripciones se inactivaran, ya no podran visulizarse como datos activos, asi como los alumnos aumentaran automaticamente de cuatrimestre.")) {

    fetch('modificar.php', { method: 'POST' })
      .then(response => response.json())
      .then(async data => {

        if (data.status === 'ok') {

          const h1 = document.querySelector('h1:nth-of-type(2)');
          if (h1) h1.textContent = 'Periodo ' + data.nombre_p + ' - ' + data.anio;

          alert('Periodo actualizado correctamente a: ' + data.nombre_p);

          if (data.reiniciado === true) {
 
            const nuevoAnio = new Date().getFullYear();

            const resp = await fetch('registrar_anio.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: 'anio=' + encodeURIComponent(nuevoAnio)
            });

            const result = await resp.json();

            if (result.status === 'ok') {

              alert('Nuevo año registrado automáticamente: ' + result.anio);

              if (h1) h1.textContent = 'Periodo ' + data.nombre_p + ' - ' + result.anio;

              setTimeout(() => {
                location.reload();
              }, 1000);

            } else {
              alert('Error al registrar el año.');
            }

          } else {
            setTimeout(() => {
              location.reload();
            }, 1000);
          }

        } else {
          alert('Error al actualizar el periodo.');
        }

      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error);
      });
  }
}
</script>




        <?php } ?>


        <?php if ($_SESSION['rol'] == "3") { ?>
            <li><a href="add_docente.php"><i class="fas fa-user-plus"></i>Registrar Docente</a></li>
            <li><a href="add_admin.php"><i class="fas fa-user-shield"></i>Agregar Administrador</a></li>
 			<li><a href="exportar_bd.php"><i class="fas fa-user-shield"></i>Restablecer</a></li>
            <li><a href="add_superroot.php"><i class="fas fa-user-shield"></i>Agregar Super Administrador</a></li>
             <li><a href="add_fecha.php"><i class="fas fa-calendar-alt"></i>Fecha Límite de Insc.</a></li>
   <li><a href="add_limite.php"><i class="fas fa-calendar-alt"></i>Fecha Límite de Liberacion</a></li>

            <li>
                <button onclick="cambiarPeriodo()">
                    <i class="fas fa-sync-alt"></i> Cambiar Periodo
                </button>
            </li>
            
<script>
function cambiarPeriodo() { 
  if (confirm("¿Seguro que deseas cambiar al siguiente periodo?. Toma en cuenta que todos los talleres y sus respectivas inscripciones se inactivaran, ya no podran visulizarse como datos activos, asi como los alumnos aumentaran automaticamente de cuatrimestre.")) {

    fetch('modificar.php', { method: 'POST' })
      .then(response => response.json())
      .then(async data => {

        if (data.status === 'ok') {

          const h1 = document.querySelector('h1:nth-of-type(2)');
          if (h1) h1.textContent = 'Periodo ' + data.nombre_p + ' - ' + data.anio;

          alert('Periodo actualizado correctamente a: ' + data.nombre_p);

          if (data.reiniciado === true) {
 
            const nuevoAnio = new Date().getFullYear();

            const resp = await fetch('registrar_anio.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: 'anio=' + encodeURIComponent(nuevoAnio)
            });

            const result = await resp.json();

            if (result.status === 'ok') {

              alert('Nuevo año registrado automáticamente: ' + result.anio);

              if (h1) h1.textContent = 'Periodo ' + data.nombre_p + ' - ' + result.anio;

              setTimeout(() => {
                location.reload();
              }, 1000);

            } else {
              alert('Error al registrar el año.');
            }

          } else {
            setTimeout(() => {
              location.reload();
            }, 1000);
          }

        } else {
          alert('Error al actualizar el periodo.');
        }

      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error);
      });
  }
}
</script>

        <?php } ?>


        <?php if ($_SESSION['rol'] == "Estudiante") { ?>
            <li><a href="historial_insc.php"><i class="fas fa-book-open"></i>Mis talleres</a></li>
            <li><a href="update_datos_alumno.php"><i class="fas fa-edit"></i>Actualizar Mis Datos</a></li>
        <?php } ?>

        <li><a href="desconectar_.php"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a></li>

    </ul>
</div>

<div class="overlay" id="overlay" onclick="closeMenu()"></div>

<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("overlay").classList.toggle("active");
}

function closeMenu(){
    document.getElementById("sidebar").classList.remove("active");
    document.getElementById("overlay").classList.remove("active");
}

document.querySelectorAll("#sidebar a, #sidebar button").forEach(item => {
    item.addEventListener("click", () => {
        if (window.innerWidth <= 768) {
            closeMenu();
        }
    });
});
</script>

</body>
</html>
