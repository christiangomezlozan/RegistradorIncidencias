<?php 

/**
 * Permite el logueo de un empleado tras introducir sus credenciales correctamente
 * Los datos son obtenidos desde una solicitud POST al enviar el formulario de la página loginModal.php
 * Los datos del usuario logueado se guardan en la sesión del navegador
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

require '../config/database.php';
require 'cifrado.php';
require 'logger.php';

$logger = LogManager::getLogger();

session_start();

$usuario  = $conexion->real_escape_string($_POST['usuario']); 
$clave  = $conexion->real_escape_string($_POST['clave']); 

$sqlUsuariosLog = "SELECT empleado, clave, cargo FROM empleados";
$usuariosLog = $conexion->query($sqlUsuariosLog);

$loginCorrecto = false;

while ($usuarioLog = $usuariosLog->fetch_assoc()) {
    if ($usuario == $usuarioLog['empleado'] && $clave == descifrar($usuarioLog['clave'])) {
        if($usuarioLog['cargo'] == 'empleado'){
        $_SESSION['usuarioLogueado'] = 'empleado';
        $_SESSION['identificador'] = $usuario;
        $loginCorrecto = true;
        break;
        } else if($usuarioLog['cargo'] == 'admin'){
            $_SESSION['usuarioLogueado'] = 'admin';
            $_SESSION['identificador'] = $usuario;
            $loginCorrecto = true;
            break;
            }
    }
}

if ($loginCorrecto) {
    $logger->info("Empleado logueado", ['usuario' => $usuario]);
    echo json_encode(['success' => true]);
} else {
    $logger->error("Error al iniciar sesión", ['usuario' => $usuario]);
    echo json_encode(['success' => false, 'mensajeErrorLogin' => 'Usuario o contraseña incorrectos']);
} 

?>



