<?php



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