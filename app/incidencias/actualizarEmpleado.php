<?php 

require '../config/database.php';
require 'logger.php';
require 'cifrado.php';

$logger = LogManager::getLogger();

function validarTexto($texto) {
    return preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $texto);
}

function existeEmpleado($conexion, $empleado){
    $sql = "SELECT COUNT(*) AS count FROM empleados WHERE empleado = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $empleado);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

$idEmpleado  = $conexion->real_escape_string(trim($_POST['idEmpleado'])); 
$empleado  = $conexion->real_escape_string(trim($_POST['empleado'])); // Función real_escape_string para evitar las inyecciones de sql malicioso
$nombre  = $conexion->real_escape_string(trim($_POST['nombre']));
$apellidos  = $conexion->real_escape_string(trim($_POST['apellidos']));
$clave  = $conexion->real_escape_string(trim($_POST['clave']));
$cargo  = $conexion->real_escape_string(trim($_POST['cargo']));

$erroresActualizarEmpleado = [];

if (empty($empleado)){
    $erroresActualizarEmpleado[] = "El campo 'Empleado' es obligatorio.";
} elseif (existeEmpleado($conexion, $empleado)){
   $erroresActualizarEmpleado[] = "Identificador de empleado ya utilizado. Introduzca otro.";
}
if (empty($nombre)) $erroresActualizarEmpleado[] = "El campo 'Nombre' es obligatorio.";
elseif (!validarTexto($nombre)) $erroresActualizarEmpleado[] = "El nombre solo debe contener letras.";

if (empty($apellidos)) $erroresActualizarEmpleado[] = "El campo 'Apellidos' es obligatorio.";
elseif (!validarTexto($apellidos)) $erroresActualizarEmpleado[] = "Los apellidos solo deben contener letras.";

if (empty($clave)) $erroresActualizarEmpleado[] = "El campo 'Contraseña' es obligatorio.";
if (empty($cargo)) $erroresActualizarEmpleado[] = "El campo 'Cargo' es obligatorio.";


if (!empty($erroresActualizarEmpleado)) {
    echo json_encode(['success' => false, 'erroresActualizarEmpleado' => $erroresActualizarEmpleado]);
    exit;
} else {
    $claveActCif = cifrar($clave);
    $sql = "UPDATE empleados SET empleado = '$empleado', nombre = '$nombre', apellidos = '$apellidos', clave = '$claveActCif', cargo = '$cargo' WHERE id = $idEmpleado";
    if($conexion->query($sql)){
        $logger->info("Empleado actualizado", ['id' => $idEmpleado]);
        echo json_encode(['success' => true]);
    } else {
        $logger->error("Error al actualizar empleado.", ['error' => $conexion->error]);
        echo json_encode(['success' => false, 'erroresActualizarEmpleado' => ["Error al actualizar el empleado."]]);
    }
}

?>