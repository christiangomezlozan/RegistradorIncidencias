<?php

/**
 * Crea una consulta para mostrar las incidencias en la página index.php filtradas por las condiciones que quiera el usuario
 * Los datos son obtenidos desde una solicitud POST al enviar el formulario de la página index.php
 * @var $sqlfiltro Consulta que se realiza a la base de datos tras componerla con las condiciones de los diferentes filtros que existen
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

require '../config/database.php';

session_start();


$condicion = [];
if (!empty($_POST['estado_gdia_filtro'])) {
    $condicion[] = "i.estado_gdia = '" . $conexion->real_escape_string($_POST['estado_gdia_filtro']) . "'";
    $_SESSION['estado_gdia_filtro'] = $_POST['estado_gdia_filtro'];
}
if (!empty($_POST['estado_vent_filtro'])) {
    $condicion[] = "i.estado_vent = '" . $conexion->real_escape_string($_POST['estado_vent_filtro']) . "'";
    $_SESSION['estado_vent_filtro'] = $_POST['estado_vent_filtro'];
}
if (!empty($_POST['tipologia_filtro'])) {
    $condicion[] = "i.tipologia = '" . $conexion->real_escape_string($_POST['tipologia_filtro']) . "'";
    $_SESSION['tipologia_filtro'] = $_POST['tipologia_filtro'];
}

if(!empty($condicion)){
    $condicionSQL = !empty($condicion) ? ' WHERE ' . implode(' AND ', $condicion) : '';
    $sqlfiltro = "SELECT i.*, e.empleado FROM incidencias AS i INNER JOIN empleados AS e ON i.id_empleado = e.id" . $condicionSQL;
    $_SESSION['sqlFiltro'] = $sqlfiltro;
}

header('Location: index.php');

?>