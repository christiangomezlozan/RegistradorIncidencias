<?php 

require '../config/database.php';
require 'logger.php';

$logger = LogManager::getLogger();

$id  = $conexion->real_escape_string($_POST['id']); 
$id_empleado  = $conexion->real_escape_string(trim($_POST['id_empleado'])); // Función real_escape_string para evitar las inyecciones de sql malicioso
$gdia  = $conexion->real_escape_string(trim($_POST['gdia']));
$estado_gdia  = $conexion->real_escape_string(trim($_POST['estado_gdia']));
$ventanilla  = $conexion->real_escape_string(trim($_POST['ventanilla']));
$estado_vent  = $conexion->real_escape_string(trim($_POST['estado_vent']));
$tipologia  = $conexion->real_escape_string(trim($_POST['tipologia']));
$incidencia  = $conexion->real_escape_string(trim($_POST['incidencia']));
$info_adicional  = $conexion->real_escape_string($_POST['info_adicional']);

$erroresActualizarIncidencia = [];

if (empty($id_empleado)) {
    $erroresActualizarIncidencia[] = "El empleado es obligatorio.";
}
if (empty($gdia)) {
    $erroresActualizarIncidencia[] = "El campo Gdia es obligatorio.";
} elseif (!preg_match('/^\d{7}$/', $gdia)) {
    $erroresActualizarIncidencia[] = "El campo Gdia debe tener exactamente 7 dígitos.";
}
if (empty($ventanilla)) {
    $erroresActualizarIncidencia[] = "El campo Ventanilla es obligatorio.";
} elseif (!preg_match('/^INC\d{4}$/', $ventanilla)) {
    $erroresActualizarIncidencia[] = "El campo Ventanilla debe comenzar con 'INC' seguido de 4 dígitos.";
}
if (empty($tipologia)) {
    $erroresActualizarIncidencia[] = "El campo Tipología es obligatorio.";
}
if (empty($incidencia)) {
    $erroresActualizarIncidencia[] = "El campo Incidencia es obligatorio.";
}

if (!empty($erroresActualizarIncidencia)) {
    echo json_encode(["success" => false, "erroresActualizarIncidencia" => $erroresActualizarIncidencia]);
    exit;
} else {

    $sql = "UPDATE incidencias SET id_empleado = '$id_empleado', gdia = '$gdia', estado_gdia = '$estado_gdia', ventanilla = '$ventanilla', estado_vent = '$estado_vent', tipologia = '$tipologia', incidencia = '$incidencia', info_adicional = '$info_adicional' WHERE id = $id";
    if($conexion->query($sql)){
        $logger->info("Incidencia actualizada", ['id' => $id]);
        echo json_encode(["success" => true]);
    } else {
        $logger->error("Error al actualizar incidencia.", ['error' => $conexion->error]);
        echo json_encode(["success" => false, "erroresActualizarIncidencia" => ["Error al actualizar la incidencia. Inténtalo de nuevo."]]);
    }

}

?>