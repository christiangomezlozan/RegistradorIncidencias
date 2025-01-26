<?php
/**
 * Página modal que proporciona un formulario para introducir un nuevo empleado en la base de datos
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */
?>
<div class="modal fade" id="nuevoEmpleadoModal" tabindex="-1" aria-labelledby="nuevoEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="nuevoEmpleadoModalLabel">Nuevo empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="errorNuevoEmpleado" class="alert alert-danger d-none" role="alert"></div><!-- Los mensajes de error aparecerán aquí -->
        
        <form action="insertarUsuario.php" method="POST" id="nuevoEmpleadoForm">
            
            <div class="mb-3">
                <label for="empleado" class="form-label">Empleado</label>
                <input type="text" name="empleado" id="empleado" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" name="clave" id="clave" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo</label>
                <input type="text" name="cargo" id="cargo" class="form-control" placeholder="empleado" required>
            </div>

            <div class="">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>