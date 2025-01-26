<?php
/**
 * Página php que proporciona información sobre la aplicación
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre la aplicacion</title>

    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/all.min.css" rel="stylesheet">
    <link href="../../assets/css/adicionalStyle.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php require 'header.php'; ?>
    <div class="container py-3">
        <h2 class="text-center">Sobre la aplicación</h2>
        <p>Proyecto final del ciclo Desarrollo de Aplicaciones WEB</p>
        <p>Trabajo destinado a la implementación de una aplicación web cuyo objetivo es desarrollar un registro centralizado de las incidencias que son tratadas por un Centro de gestión para mejorar su resolución y supervisión.</p>
    </div>


    <?php require 'footer.php'; ?>
    <script src="../../assets/js/bootstrap.bundle.min.js" ></script>
</body>
</html>