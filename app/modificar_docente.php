
<?php
$id_docente = $_POST ['id_docente'];
 $status = $_POST['status'];

          require("conexion.php");

        $actualiza_docente = $mysqli->query("UPDATE docentes SET status = $status WHERE id_docente = $id_docente");
            
        if ($actualiza_docente) {
           echo '<script>setTimeout(function(){ location.href="panel_admin.php"; }, 1500);</script>';
        
        }
           
          
          
          ?>
