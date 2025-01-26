<?php

/**
 * Borra las variables de sesión que se han utilizado para crear un filtro de las incidencias
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

session_start();

unset($_SESSION['sqlFiltro']);

unset($_SESSION['estado_gdia_filtro']);

unset($_SESSION['estado_vent_filtro']);

unset($_SESSION['tipologia_filtro']);


header('Location: index.php');

?>