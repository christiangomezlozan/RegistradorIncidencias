<?php 

require '../config/database.php';
require 'cifrado.php';
require 'logger.php';

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



$empleado  = trim($_POST['empleado']);
$nombre  = trim($_POST['nombre']);
$apellidos  = trim($_POST['apellidos']);
$clave  = trim($_POST['clave']);
$cargo  = trim($_POST['cargo']);

$erroresInsertarUsuario = [];

if (empty($empleado)){
     $erroresInsertarUsuario[] = "El campo 'Empleado' es obligatorio.";
} elseif (existeEmpleado($conexion, $empleado)){
    $erroresInsertarUsuario[] = "Identificador de empleado ya utilizado. Introduzca otro.";
}


if (empty($nombre)) $erroresInsertarUsuario[] = "El campo 'Nombre' es obligatorio.";
elseif (!validarTexto($nombre)) $erroresInsertarUsuario[] = "El nombre solo debe contener letras.";

if (empty($apellidos)) $erroresInsertarUsuario[] = "El campo 'Apellidos' es obligatorio.";
elseif (!validarTexto($apellidos)) $erroresInsertarUsuario[] = "Los apellidos solo deben contener letras.";

if (empty($clave)) $erroresInsertarUsuario[] = "El campo 'Contraseña' es obligatorio.";
if (empty($cargo)) $erroresInsertarUsuario[] = "El campo 'Cargo' es obligatorio.";

if (!empty($erroresInsertarUsuario)) {
    echo json_encode(['success' => false, 'erroresInsertarUsuario' => $erroresInsertarUsuario]);
    exit;
} else {
    $claveCif = cifrar($clave);
    $sql = "INSERT INTO empleados (empleado, nombre, apellidos, clave, cargo) VALUES ('$empleado', '$nombre', '$apellidos', '$claveCif', '$cargo')";
    if($conexion->query($sql)){
        $logger->info("Empleado insertado", ['empleado' => $empleado, 'nombre' => $nombre, 'apellidos' => $apellidos]);
        echo json_encode(['success' => true]);
    } else {
        $logger->error("Error al insertar empleado.", ['error' => $conexion->error]);
        echo json_encode(['success' => false, 'erroresInsertarUsuario' => ["Error al insertar el empleado."]]);
    }
}

?>