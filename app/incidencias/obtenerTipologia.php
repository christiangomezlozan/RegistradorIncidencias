<?php

/**
 * Proporciona una función para obtener la tipología dado un id
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */


    /**
     * Obtiene la tipología asociada a un id en la base de datos
     * 
     * @param $tipo id del tipo de tipologia
     * @return string la tipologia correspondiente al id pasado, `Sin tipología` en caso contrario
     */
    function obtenerTipologia($tipo){

        require '../config/database.php';

        $sqlTipologia = "SELECT tipologia FROM tipologia_inc WHERE  id=$tipo";
        $tipologia = $conexion->query($sqlTipologia);

        if ($tipologia && $tipologia->num_rows > 0) {
            $fila = $tipologia->fetch_assoc(); // Obtener la fila de resultados
            return $fila['tipologia']; // Retornar solo el valor del campo 'estado'
        }
    
        return "Sin tipología";

    }

?>