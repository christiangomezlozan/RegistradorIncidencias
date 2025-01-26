<?php 

/**
 * Elimina una incidencia de la base de datos
 * @var $sql Consulta que se realiza a la base de datos para eliminar la incidencia
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

require '../config/database.php';
require 'logger.php';

$logger = LogManager::getLogger();

$id  = $conexion->real_escape_string($_POST['id']); 

$sql = "DELETE FROM incidencias WHERE id = $id";
if($conexion->query($sql)){
    $logger->info("Incidencia eliminada", ['id' => $id]);
}

header('Location:index.php');

?>