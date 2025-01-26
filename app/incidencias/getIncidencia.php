<?php 

/**
 * Obtiene los datos de una incidencia y los devuelve en formato json
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

require '../config/database.php';

$id = $conexion->real_escape_string($_POST['id']); // Función real_escape_string para evitar las inyecciones de sql malicioso

$sql = "SELECT id, id_empleado, gdia, estado_gdia, ventanilla, estado_vent, tipologia, incidencia, info_adicional FROM incidencias WHERE id=$id LIMIT 1";

$resultado = $conexion->query($sql);

$lineas = $resultado->num_rows;

$incidencia = [];   // Es un array ya que como se va a generar un archivo json, éste hay que recogerlo en un array

if($lineas > 0){
    $incidencia = $resultado->fetch_array();
}

echo json_encode($incidencia, JSON_UNESCAPED_UNICODE);

?>