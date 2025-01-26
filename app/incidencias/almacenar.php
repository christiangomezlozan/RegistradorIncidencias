<?php 

/**
 * Introduce una nueva incidencia en la base de datos
 * Los datos son obtenidos desde una solicitud POST al enviar el formulario de la página nuevoModal.php
 * @var $sql Consulta que se realiza a la base de datos tras validar los datos para añadir la nueva incidencia
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

require '../config/database.php';
require 'logger.php';

session_start();
$logger = LogManager::getLogger();

/**
 * Devuelve el id del empleado que se pasa como parámetro
 * 
 * @param $conexion Conexion activa a la base de datos
 * @param $empleado Identificador del empleado del que se quiere sacar el id
 * @return string `el id del empleado` si lo encuentra en la base de datos, `null` en caso contrario 
 */
function obtenerIdEmpleado($conexion, $empleado) {
    $sqlEmpleado = "SELECT id FROM empleados WHERE empleado = '$empleado' LIMIT 1"; 
    $resultado = $conexion->query($sqlEmpleado);

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        return $fila['id'];
    } else {
        return null; 
    }
}

$id_empleado = obtenerIdEmpleado($conexion, $_SESSION['identificador']); //$conexion->real_escape_string(trim($_POST['id_empleado']))
$gdia  = $conexion->real_escape_string(trim($_POST['gdia']));
$estado_gdia  = $conexion->real_escape_string(trim($_POST['estado_gdia']));
$ventanilla  = $conexion->real_escape_string(trim($_POST['ventanilla']));
$estado_vent  = $conexion->real_escape_string(trim($_POST['estado_vent']));
$tipologia  = $conexion->real_escape_string(trim($_POST['tipologia']));
$incidencia  = $conexion->real_escape_string(trim($_POST['incidencia']));
$info_adicional  = $conexion->real_escape_string(trim($_POST['info_adicional']));


/**
 * Comprueba si existe una incidencia con el mismo gdia que se quiere introducir
 * 
 * @param $conexion Conexion activa a la base de datos
 * @param $gdia número de gdia que se quiere comprobar
 * @return bool `true` si en la base de datos ya hay una incidencia con el mismo gdia, `false` en caso contrario 
 */
function verificarGdiaDuplicado($conexion, $gdia) {
    $sql = "SELECT id FROM incidencias WHERE gdia = '$gdia' LIMIT 1";
    $resultado = $conexion->query($sql);

    return $resultado && $resultado->num_rows > 0;
}

/**
 * Comprueba si existe una incidencia con la misma ventanilla que se quiere introducir
 * 
 * @param $conexion Conexion activa a la base de datos
 * @param $gdia número de ventanilla que se quiere comprobar
 * @return bool `true` si en la base de datos ya hay una incidencia con la misma ventanilla, `false` en caso contrario 
 */
function verificarVentanillaDuplicada($conexion, $ventanilla) {
    $sql = "SELECT id FROM incidencias WHERE ventanilla = '$ventanilla' LIMIT 1";
    $resultado = $conexion->query($sql);

    return $resultado && $resultado->num_rows > 0;
}


$erroresNuevaIncidencia = [];


if (empty($id_empleado)) $erroresNuevaIncidencia[] = "El campo ID Empleado es obligatorio.";
if (empty($gdia)) $erroresNuevaIncidencia[] = "El campo Gdia es obligatorio.";
if (empty($estado_gdia)) $erroresNuevaIncidencia[] = "El campo Estado Gdia es obligatorio.";
if (empty($ventanilla)) $erroresNuevaIncidencia[] = "El campo Ventanilla es obligatorio.";
if (empty($estado_vent)) $erroresNuevaIncidencia[] = "El campo Estado Ventanilla es obligatorio.";
if (empty($tipologia)) $erroresNuevaIncidencia[] = "El campo Tipología es obligatorio.";
if (empty($incidencia)) $erroresNuevaIncidencia[] = "El campo Incidencia es obligatorio.";


if (!preg_match('/^\d{7}$/', $gdia)) {
    $erroresNuevaIncidencia[] = "El campo Gdia debe tener exactamente 7 dígitos.";
}


if (!preg_match('/^INC\d{4}$/', $ventanilla)) {
    $erroresNuevaIncidencia[] = "El campo Ventanilla debe comenzar con 'INC' seguido de 4 dígitos.";
}

if (verificarGdiaDuplicado($conexion, $gdia)) {
    $erroresNuevaIncidencia[] = "El campo Gdia ya existe.";
}

if (verificarVentanillaDuplicada($conexion, $ventanilla)) {
    $erroresNuevaIncidencia[] = "El campo Ventanilla ya existe.";
}


if (!empty($erroresNuevaIncidencia)) {
    echo json_encode(["success" => false, "erroresNuevaIncidencia" => $erroresNuevaIncidencia]);
    exit;
} else {
   
    $sql = "INSERT INTO incidencias (id_empleado, gdia, estado_gdia, ventanilla, estado_vent, tipologia, incidencia, info_adicional) 
            VALUES ('$id_empleado', '$gdia', '$estado_gdia', '$ventanilla', '$estado_vent', '$tipologia', '$incidencia', '$info_adicional')";
    if($conexion->query($sql)){
        $logger->info("Incidencia añadida", ['gdia' => $gdia, 'ventanilla' => $ventanilla]);
        echo json_encode(["success" => true]);
    } else {
        $logger->error("Error al insertar incidencia.", ['error' => $conexion->error]);
        echo json_encode(["success" => false, "mensaje" => ["Error al incluir una nueva incidencia."]]);
    }
}
?>