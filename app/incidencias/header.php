<?php
/**
 * Página php que proporciona un encabezado para las páginas que conforman la aplicación
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */
?>

<header class="p-3 text-bg-dark">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href='mostrarEmpleados.php' class="nav-link px-2 text-secondary">Empleados</a></li>
          <li><a href='index.php' class="nav-link px-2 text-secondary">Incidencias</a></li>
        </ul>

        <div class="text-end">
          <?php if(isset($_SESSION['usuarioLogueado']) && ($_SESSION['usuarioLogueado'] == 'admin' || $_SESSION['usuarioLogueado'] == 'empleado') ){ ?>
            <a href="#" class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#" style="pointer-events: none; color: gray;">Iniciar sesion</a> <!-- Se evita que se pueda pulsar el enlace iniciar sesion si ya hay un empleado logueado -->
          <?php } else { ?> 
            <a href="#" class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar sesion</a>
          <?php } ?>
          <?php if(isset($_SESSION['usuarioLogueado']) && ($_SESSION['usuarioLogueado'] == 'admin' || $_SESSION['usuarioLogueado'] == 'empleado') ){ ?>
            <a class="btn btn-warning" href="cerrarSesion.php">Cerrar sesion</a>
          <?php } ?>  
        </div>
      </div>
    </div>
</header>