<?php 

    $conexion = new mysqli("localhost", "root", "", "registro_incidencias");

    if($conexion -> connect_error){
        die("Error de conexion" . $conexion->connect_error);
    }

?>