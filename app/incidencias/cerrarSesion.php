<?php 

session_start();

unset($_SESSION['usuarioLogueado']);
unset($_SESSION['identificador']);

if(isset($_SESSION['paginaAnterior'])) {
    $paginaRedireccion = $_SESSION['paginaAnterior'];
} else {
    $paginaRedireccion = 'index.php'; // Ruta predeterminada
}

header("Location: $paginaRedireccion");

?>