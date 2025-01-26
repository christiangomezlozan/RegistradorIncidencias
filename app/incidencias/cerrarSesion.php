<?php 

/**
 * Elimina los datos de sesión del usuario que se logueo en la aplicación
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

require 'logger.php';

$logger = LogManager::getLogger();

session_start();

$logger->info("Sesión cerrada", ['usuario' => $_SESSION['identificador']]);
unset($_SESSION['usuarioLogueado']);
unset($_SESSION['identificador']);

if(isset($_SESSION['paginaAnterior'])) {
    $paginaRedireccion = $_SESSION['paginaAnterior'];
} else {
    $paginaRedireccion = 'index.php'; 
}

header("Location: $paginaRedireccion");

?>