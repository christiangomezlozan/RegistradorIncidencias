<?php 

/**
 * Eliminar los datos de un empleado de la base de datos
 * @var $sql Consulta que se realiza a la base para eliminar al empleado de la base de datos
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

require '../config/database.php';
require 'logger.php';

$logger = LogManager::getLogger();

$idEmpleado  = $conexion->real_escape_string($_POST['idEmpleado']); 

$sql = "DELETE FROM empleados WHERE id = $idEmpleado";
if($conexion->query($sql)){
    $logger->info("Empleado eliminado", ['id' => $idEmpleado]);
}

header('Location:mostrarEmpleados.php');

?>