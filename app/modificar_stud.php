
<?php
$id_alumno = $_POST ['id_alumno'];
 $status = $_POST['status'];

          require("conexion.php");

        $actualiza_docente = $mysqli->query("UPDATE alumno SET status = $status WHERE id_alumno = $id_alumno");
            
        if ($actualiza_docente) {
           echo '<script>setTimeout(function(){ location.href="viewalumnos.php"; }, 150);</script>';
        
        }
           
          
          
          ?>
