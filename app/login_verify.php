<?php
session_start();
require("conexion.php");

$dato = $_POST['correo'];
$password = $_POST['password'];

$buscadocente = $mysqli->query("SELECT * FROM docentes WHERE correo = '$dato' OR num_empleado = '$dato'");
$buscaalumno = $mysqli->query("SELECT * FROM alumno WHERE correo = '$dato' OR matricula = '$dato'");

 
if ($f2 = $buscadocente->fetch_array()) {

    if ($password == $f2['password']) {

        $consulta_status = $mysqli->query("SELECT status FROM docentes WHERE correo = '$dato' OR num_empleado = '$dato'");
        $row4 = $consulta_status->fetch_assoc();

        if ($row4['status'] == 1) {

            $_SESSION['rol'] = $f2['rol'];
            $_SESSION['correo'] = $f2['correo'];
            $_SESSION['id_docente'] = $f2['id_docente'];
            $_SESSION['nombre'] = $f2['nombre'];
 
            $periodo = $mysqli->query("SELECT * FROM periodo WHERE status = 1");
            if ($f3 = $periodo->fetch_array()) {
                $_SESSION['nombre_p'] = $f3['nombre_p'];
            }

            
            $nuevo_año = $mysqli->query("SELECT * FROM anios WHERE status = 1");
            if ($f5 = $nuevo_año->fetch_array()) {
                $_SESSION['anio'] = $f5['anio'];
            }

            echo "<script>location.href='Validar_Rol.php'</script>";
            exit;

        } else {
            echo '<script>alert("No tienes Acceso al sistema")</script>';
            echo "<script>location.href='login.php'</script>";
            exit;
        }

    } else {
        echo '<script>alert("Contraseña incorrecta")</script>';
        echo "<script>location.href='login.php'</script>";
        exit;
    }
}

 
if ($f1 = $buscaalumno->fetch_array()) {

    if ($password == $f1['password']) {

        
        $consulta_statuss = $mysqli->query("SELECT status FROM alumno WHERE correo = '$dato' OR matricula = '$dato'");
        $row8 = $consulta_statuss->fetch_assoc();

        if ($row8['status'] == 1) {

         
            $_SESSION['correo'] = $f1['correo'];
            $_SESSION['id_alumno'] = $f1['id_alumno'];
            $_SESSION['nombre_alumno'] = $f1['nombre_alumno'];
            $_SESSION['rol'] = 'Estudiante';

       
            $periodoo = $mysqli->query("SELECT * FROM periodo WHERE status = 1");
            if ($f4 = $periodoo->fetch_array()) {
                $_SESSION['nombre_p'] = $f4['nombre_p'];
            }

    
            $nuevo_año = $mysqli->query("SELECT * FROM anios WHERE status = 1");
            if ($f6 = $nuevo_año->fetch_array()) {
                $_SESSION['anio'] = $f6['anio'];
            }

            echo "<script>location.href='panel_alumno.php'</script>";
            exit;

        } else {
            echo '<script>alert("No tienes Acceso al sistema")</script>';
            echo "<script>location.href='login.php'</script>";
            exit;
        }

    } else {
        echo '<script>alert("Contraseña incorrecta")</script>';
        echo "<script>location.href='login.php'</script>";
        exit;
    }
}

 
echo '<script>alert("Correo incorrecto")</script>';
echo "<script>location.href='login.php'</script>";
exit;

?>
