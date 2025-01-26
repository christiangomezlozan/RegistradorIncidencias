<?php 

    /**
    * Proporciona la conexión con la base de datos. Intenta crear una nueva conexión con la base de datos. Si no lo consigue lanza un error 
    *
    * @package config
    * @author Christian Gómez Lozano
    */

    $conexion = new mysqli("localhost", "root", "", "registro_incidencias");

    if($conexion -> connect_error){
        die("Error de conexion" . $conexion->connect_error);
    }

?>