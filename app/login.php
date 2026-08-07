<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión</title>

<link rel="icon" type="image/png" href="img/Logo_UTSEM.JPG">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI', Arial, sans-serif;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
 
    background: rgb(219, 218, 207);
    background-size: 300% 300%;
    animation: fondoMove 8s ease infinite;
}
 
@keyframes fondoMove{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}
 
.contenedor{
    width:380px;
    background: rgba(255,255,255,0.96);
    padding:40px 35px;
    border-radius:22px;
    box-shadow:0 20px 50px rgba(0,0,0,.25);
    text-align:center;
    backdrop-filter: blur(8px);
    transition:.3s;
}

.contenedor:hover{
    transform:translateY(-5px);
}

.titulo1{
    font-size:24px;
    font-weight:bold;
    color:#2d4d1f;
    display:block;
    margin-bottom:18px;
}

img{
    width:95px;
    height:95px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #6d8f3a;
    margin-bottom:18px;
    box-shadow:0 0 15px rgba(79,111,50,.4);
}

.titulo{
    color:#4f6f32;
    margin-bottom:20px;
    font-size:22px;
}
 
input[type="text"],
input[type="password"]{
    width:100%;
    padding:13px;
    margin-bottom:16px;
    border:none;
    border-radius:12px;
    background:#f1f3f5;
    font-size:15px;
    outline:none;
    transition:.3s;
}

input:focus{
    background:white;
    box-shadow:0 0 0 2px #6d8f3a;
}
 
input[type="submit"]{
    width:100%;
    padding:13px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#4f6f32,#2d4d1f);
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

input[type="submit"]:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(0,0,0,.18);
}
 
.extra{
    margin-top:18px;
    font-size:14px;
    color:#555;
}

.extra a{
    color:#4f6f32;
    font-weight:bold;
    text-decoration:none;
}

.extra a:hover{
    text-decoration:underline;
}

                               
 .footer-note{
    font-size:12px;
    color:#777;
    margin-bottom:20px;
}
                               
@media(max-width:430px){
    .contenedor{
        width:92%;
        padding:30px 25px;
    }
}
</style>
</head>

<body>

<div class="contenedor">

    <span class="titulo1">SITAE</span>

<img src="img/i.jpg" alt="Logo">

<form method="POST" action="login_verify.php">

    <h2 class="titulo">Inicia Sesión</h2>

    <input type="text" name="correo" placeholder="Correo">

    <!-- Contraseña -->
    <div style="position:relative;">
        <input type="password"
               name="password"
               id="password"
               placeholder="Contraseña">

        <i class="fa-solid fa-eye"
           id="togglePassword"
           style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; color:#666;">
        </i>
    </div>

    <input type="submit" value="Iniciar Sesión">

</form>

<div class="extra">
    ¿No estás registrado? <a href="add_alumno.php">Registrarme</a>
</div>

<div class="extra">
    ¿Eres docente nuevo u olvidaste tu contraseña?
    <a href="update_pass.php">Restablecer contraseña</a>
</div>


<script>

const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");
const form = password.closest("form");


// Mostrar / ocultar contraseña
togglePassword.addEventListener("click", function () {

    if (password.type === "password") {

        password.type = "text";

        this.classList.remove("fa-eye");
        this.classList.add("fa-eye-slash");

    } else {

        password.type = "password";

        this.classList.remove("fa-eye-slash");
        this.classList.add("fa-eye");

    }

});


// Validar contraseña
form.addEventListener("submit", function(event) {

    if (password.value.length < 8) {

        event.preventDefault();

        alert("La contraseña debe tener al menos 8 caracteres");

        password.focus();
    }

});

</script>