<?php 

/**
 * Obtiene los datos de un empleado y los devuelve en formato json
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

require '../config/database.php';
require 'cifrado.php';

$idEmpleado = $conexion->real_escape_string($_POST['idEmpleado']); // Función real_escape_string para evitar las inyecciones de sql malicioso

$sql = "SELECT id, empleado, nombre, apellidos, clave, cargo FROM empleados WHERE id=$idEmpleado LIMIT 1";

$resultado = $conexion->query($sql);

$lineas = $resultado->num_rows;

$empleado = [];   // Es un array ya que como se va a generar un archivo json, éste hay que recogerlo en un array

if($lineas > 0){
    $empleado = $resultado->fetch_array();
    $empleado['clave'] = descifrar($empleado['clave']);
}

echo json_encode($empleado, JSON_UNESCAPED_UNICODE);

?>