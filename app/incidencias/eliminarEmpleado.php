<?php 

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