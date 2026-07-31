
<?php

 $nivel = $_POST['actualiza_nivel'];

           $consulta_nivel = $mysqli->query("SELECT * FROM alumno WHERE cuatrimestre => 6");
          if ($consulta_nivel) {


        $actualiza_nivel = $mysqli->query("UPDATE alumno SET nivel = $nivel ");
            
          }
          
          
          ?>
