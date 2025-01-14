<div class="modal fade" id="eliminaEmpleadoModal" tabindex="-1" aria-labelledby="eliminaEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="eliminaEmpleadoModalLabel">Eliminar empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Desea eliminar a este empleado de la base de datos?
      </div>
      <div class="modal-footer" >
        <form action="eliminarEmpleado.php" method="POST" >
            <input type="hidden" name="idEmpleado" id="idEmpleado" >
            
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>