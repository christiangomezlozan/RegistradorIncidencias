<?php 

require '../config/database.php';
require 'logger.php';

$logger = LogManager::getLogger();

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

$id_empleado = obtenerIdEmpleado($conexion, $conexion->real_escape_string(trim($_POST['id_empleado'])));
$gdia  = $conexion->real_escape_string(trim($_POST['gdia']));
$estado_gdia  = $conexion->real_escape_string(trim($_POST['estado_gdia']));
$ventanilla  = $conexion->real_escape_string(trim($_POST['ventanilla']));
$estado_vent  = $conexion->real_escape_string(trim($_POST['estado_vent']));
$tipologia  = $conexion->real_escape_string(trim($_POST['tipologia']));
$incidencia  = $conexion->real_escape_string(trim($_POST['incidencia']));
$info_adicional  = $conexion->real_escape_string(trim($_POST['info_adicional']));


$erroresNuevaIncidencia = [];


if (empty($id_empleado)) $erroresNuevaIncidencia[] = "El campo ID Empleado es obligatorio.";
if (empty($gdia)) $erroresNuevaIncidencia[] = "El campo Gdia es obligatorio.";
if (empty($estado_gdia)) $erroresNuevaIncidencia[] = "El campo Estado Gdia es obligatorio.";
if (empty($ventanilla)) $erroresNuevaIncidencia[] = "El campo Ventanilla es obligatorio.";
if (empty($estado_vent)) $erroresNuevaIncidencia[] = "El campo Estado Ventanilla es obligatorio.";
if (empty($tipologia)) $erroresNuevaIncidencia[] = "El campo Tipología es obligatorio.";
if (empty($incidencia)) $erroresNuevaIncidencia[] = "El campo Incidencia es obligatorio.";
if (empty($info_adicional)) $erroresNuevaIncidencia[] = "El campo Información Adicional es obligatorio.";


if (!preg_match('/^\d{7}$/', $gdia)) {
    $erroresNuevaIncidencia[] = "El campo Gdia debe tener exactamente 7 dígitos.";
}

if (existeGdia($conexion, $gdia)){
    $erroresInsertarIncidencia[] = "Gdia ya incluido.";
}

if (!preg_match('/^INC\d{4}$/', $ventanilla)) {
    $erroresNuevaIncidencia[] = "El campo Ventanilla debe comenzar con 'INC' seguido de 4 dígitos.";
}

if (existeVentanilla($conexion, $ventanilla)){
    $erroresInsertarIncidencia[] = "Ventanilla ya incluida.";
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