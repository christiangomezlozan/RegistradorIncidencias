<?php



    function obtenerEstadoInc($indice){

        require '../config/database.php';

        $sqlEstadoInc = "SELECT estado FROM estado_inc WHERE  id=$indice";
        $estado = $conexion->query($sqlEstadoInc);

        if ($estado && $estado->num_rows > 0) {
            $fila = $estado->fetch_assoc(); // Obtener la fila de resultados
            return $fila['estado']; // Retornar solo el valor del campo 'estado'
        }
    
        // Manejar el caso en el que no se encuentre un estado
        return "Estado desconocido";

    }

?>