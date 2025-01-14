<?php 

require '../config/database.php';
require 'cifrado.php';

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
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'mensajeErrorLogin' => 'Usuario o contraseña incorrectos']);
} 

?>



