<div class="modal fade" id="editaEmpleadoModal" tabindex="-1" aria-labelledby="editaEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editaEmpleadoModalLabel">Modificar incidencia</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div id="errorActualizaEmpleado" class="alert alert-danger d-none" role="alert"></div>

        <form action="actualizarEmpleado.php" method="POST" id="actualizaEmpleadoForm">

            <input type="hidden" id="idEmpleado" name="idEmpleado" >

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
                <input type="text" name="clave" id="clave" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo</label>
                <input type="text" name="cargo" id="cargo" class="form-control" required>
            </div>

            <div class="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar</button>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>