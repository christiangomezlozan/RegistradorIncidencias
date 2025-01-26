<?php
/**
 * Página modal que proporciona un formulario de reafirmación para eliminar una incidencia de la base de datos
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */
?>

<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="eliminaModalLabel">Eliminar Incidencia</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Desea eliminar la incidencia?
      </div>
      <div class="modal-footer" >
        <form action="eliminar.php" method="POST" >
            <input type="hidden" name="id" id="id" >
            <button type="submit" class="btn btn-primary">Eliminar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </form>
      </div>
    </div>
  </div>
</div>