<?php 

/*require '../config/database.php';
require 'logger.php';

$logger = LogManager::getLogger();

function existeGdia($conexion, $gdia){
    $sql = "SELECT COUNT(*) AS count FROM incidencias WHERE gdia = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $gdia);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

function existeVentanilla($conexion, $ventanilla){
    $sql = "SELECT COUNT(*) AS count FROM incidencias WHERE ventanilla = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $ventanilla);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}


$id_empleado  = $conexion->real_escape_string(trim($_POST['id_empleado'])); // Función real_escape_string para evitar las inyecciones de sql malicioso
$gdia  = $conexion->real_escape_string(trim($_POST['gdia']));
$estado_gdia  = $conexion->real_escape_string(trim($_POST['estado_gdia']));
$ventanilla  = $conexion->real_escape_string(trim($_POST['ventanilla']));
$estado_vent  = $conexion->real_escape_string(trim($_POST['estado_vent']));
$tipologia  = $conexion->real_escape_string(trim($_POST['tipologia']));
$incidencia  = $conexion->real_escape_string(trim($_POST['incidencia']));
$info_adicional  = $conexion->real_escape_string(trim($_POST['info_adicional']));

$erroresInsertarIncidencia = [];

if (empty($id_empleado)) {
    $erroresInsertarIncidencia[] = "El empleado es obligatorio.";
}

if (empty($gdia) && empty($ventanilla)) {
    $erroresInsertarIncidencia[] = "El campo Gdia o el campo ventanilla no deben estar vacíos.";
} elseif (empty($gdia)) {
    if (!preg_match('/^INC\d{4}$/', $ventanilla)) {
        $erroresInsertarIncidencia[] = "El campo Ventanilla debe comenzar con 'INC' seguido de 4 dígitos.";
    }

    if (existeVentanilla($conexion, $ventanilla)){
        $erroresInsertarIncidencia[] = "Ventanilla ya incluida.";
    }

} elseif (empty($ventanilla)) {
    if (!preg_match('/^\d{7}$/', $gdia)) {
        $erroresInsertarIncidencia[] = "El campo Gdia debe tener exactamente 7 dígitos.";
    }

    if (existeGdia($conexion, $gdia)){
        $erroresInsertarIncidencia[] = "Gdia ya incluido.";
    }

} else {
    if (!preg_match('/^INC\d{4}$/', $ventanilla)) {
        $erroresInsertarIncidencia[] = "El campo Ventanilla debe comenzar con 'INC' seguido de 4 dígitos.";
    }

    if (!preg_match('/^\d{7}$/', $gdia)) {
        $erroresInsertarIncidencia[] = "El campo Gdia debe tener exactamente 7 dígitos.";
    }
}

if (empty($tipologia)) {
    $erroresInsertarIncidencia[] = "El campo Tipología es obligatorio.";
}
if (empty($incidencia)) {
    $erroresInsertarIncidencia[] = "El campo Incidencia es obligatorio.";
}

if (!empty($erroresInsertarIncidencia)) {
    echo json_encode(["success" => false, "erroresInsertarIncidencia" => $erroresInsertarIncidencia]);
    exit;
} else {
    $sql = "INSERT INTO incidencias (id_empleado, gdia, estado_gdia, ventanilla, estado_vent, tipologia, incidencia, info_adicional) VALUES ($id_empleado, '$gdia', '$estado_gdia', '$ventanilla', '$estado_vent', '$tipologia', '$incidencia', '$info_adicional')";
    if($conexion->query($sql)){
        $id = $conexion->insert_id;
        $logger->info("Incidencia añadida", ['gdia' => $gdia, 'ventanilla' => $ventanilla]);
        echo json_encode(['success' => true]);
    } else {
        $logger->error("Error al insertar inccidencia.", ['error' => $conexion->error]);
        echo json_encode(["success" => false, "erroresInsertarIncidencia" => ["Error al guardar la incidencia. Inténtalo de nuevo."]]);
    }
}*/


?>