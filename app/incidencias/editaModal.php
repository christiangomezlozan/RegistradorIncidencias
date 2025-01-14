<div class="modal fade" id="editaModal" tabindex="-1" aria-labelledby="editaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editaModalLabel">Modificar incidencia</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div id="errorActualizaIncidencia" class="alert alert-danger d-none" role="alert"></div>
        <form action="actualizar.php" method="POST" id="actualizaIncidenciaForm" >

            <input type="hidden" id="id" name="id" >

            <div class="mb-3">
                <label for="id_empleado" class="form-label">Empleado</label>
                <select name="id_empleado" id="id_empleado" class="form-select" required>
                    <option value="">Selecciona empleado ... </option>
                    <?php while($empleado = $empleados->fetch_assoc()){ ?>
                        <option value="<?php echo $empleado["id"]; ?>">
                           <?php echo $empleado["empleado"] ?> 
                        </option>

                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="gdia" class="form-label">Gdia</label>
                <input type="text" name="gdia" id="gdia" class="form-control" pattern="^\d{7}$" title="El campo Gdia debe contener exactamente 7 dígitos.">
            </div>
            <div class="mb-3">
                <label for="estado_gdia" class="form-label">Estado_Gdia</label>
                <select name="estado_gdia" id="estado_gdia" class="form-select" >
                    <option value="">Selecciona estado Gdia ... </option>
                    <?php while($estadoG = $estadosG->fetch_assoc()){ ?>
                        <option value="<?php echo $estadoG["id"]; ?>">
                           <?php echo $estadoG["estado"] ?> 
                        </option>

                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ventanilla" class="form-label">Ventanilla</label>
                <input type="text" name="ventanilla" id="ventanilla" class="form-control" pattern="^INC\d{4}$" title="El campo Ventanilla debe comenzar con 'INC' seguido de 4 dígitos.">
            </div>
            <div class="mb-3">
                <label for="estado_vent" class="form-label">Etado_Vent</label>
                <select name="estado_vent" id="estado_vent" class="form-select" >
                    <option value="">Selecciona estado ventanilla ... </option>
                    <?php while($estadoI = $estadosI->fetch_assoc()){ ?>
                        <option value="<?php echo $estadoI["id"]; ?>">
                           <?php echo $estadoI["estado"] ?> 
                        </option>

                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tipologia" class="form-label">Tipologia</label>
                <select name="tipologia" id="tipologia" class="form-select" required>
                    <option value="">Selecciona tipologia ... </option>
                    <?php while($tipo = $tipos->fetch_assoc()){ ?>
                        <option value="<?php echo $tipo["id"]; ?>">
                           <?php echo $tipo["tipologia"] ?> 
                        </option>

                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="incidencia" class="form-label">Incidencia</label>
                <input type="text" name="incidencia" id="incidencia" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="info_adicional" class="form-label">Info adicional</label>
                <textarea name="info_adicional" id="info_adicional" class="form-control" rows="3" ></textarea>
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