<?php 

    /**
     * Página que proporciona un listado de las incidencias almacenadas en la base de datos
     * 
     * @package incidencias
     * @author Christian Gómez Lozano 
     */
    
    require '../config/database.php';

    session_start();

    if(isset($_SESSION['sqlFiltro'])) {
        $sqlIncidencias = $_SESSION['sqlFiltro'];


    } else {
        $sqlIncidencias = "SELECT i.*, e.empleado FROM incidencias AS i INNER JOIN empleados AS e ON i.id_empleado = e.id";

    }
    

    $incidencias = $conexion->query($sqlIncidencias);
    $contadorIncidencias = 0;

    $sqlTipologiaFiltro = "SELECT id, tipologia, descripcion FROM tipologia_inc";
    $tipologiasFiltro = $conexion->query($sqlTipologiaFiltro);

    $sqlEstadoGFiltro = "SELECT id, estado FROM estado_inc";
    $estadosGFiltro = $conexion->query($sqlEstadoGFiltro);

    $sqlEstadoVFiltro = "SELECT id, estado FROM estado_inc";
    $estadosVFiltro = $conexion->query($sqlEstadoVFiltro);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias</title>

    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/all.min.css" rel="stylesheet">
    <link href="../../assets/css/indexStyle.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php require 'header.php'; ?>
    <?php require 'getEstadoInc.php'; ?>
    <?php require 'obtenerTipologia.php'; ?>
    
    <?php $_SESSION['paginaAnterior'] = 'index.php'; ?>


    <div class="container py-3">
        
        <h2 class="text-center">Incidencias</h2>

        <form method="POST" class="mb-3" action="filtrar.php" >
            <div class="row align-items-end">
                <div class="col-md-3">
                    <select name="estado_gdia_filtro" id="estado_gdia_filtro" class="form-select">
                    <option value="">Estado Gdia</option>
                        <?php while ($estadoGFiltro = $estadosGFiltro->fetch_assoc()) { ?>
                            <option value="<?= $estadoGFiltro['id'] ?>" <?= isset($_SESSION['estado_gdia_filtro']) && $_SESSION['estado_gdia_filtro'] == $estadoGFiltro['id'] ? 'selected' : '' ?>>
                                <?= $estadoGFiltro['estado'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="estado_vent_filtro" id="estado_vent_filtro" class="form-select">
                    <option value="">Estado Ventanilla</option>
                        <?php while ($estadoVFiltro = $estadosVFiltro->fetch_assoc()) { ?>
                            <option value="<?= $estadoVFiltro['id'] ?>" <?= isset($_SESSION['estado_vent_filtro']) && $_SESSION['estado_vent_filtro'] == $estadoVFiltro['id'] ? 'selected' : '' ?>>
                                <?= $estadoVFiltro['estado'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="tipologia_filtro" id="tipologia_filtro" class="form-select">
                    <option value="">Tipologia</option>
                        <?php while ($tipologiaFiltro = $tipologiasFiltro->fetch_assoc()) { ?>
                            <option value="<?= $tipologiaFiltro['id'] ?>" <?= isset($_SESSION['tipologia_filtro']) && $_SESSION['tipologia_filtro'] == $tipologiaFiltro['id'] ? 'selected' : '' ?>>
                                <?= $tipologiaFiltro['tipologia'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="limpiarFiltro.php" class="btn btn-secondary">Limpiar Filtros</a>
                </div>
            </div>
        </form>



        <?php if(isset($_SESSION['usuarioLogueado']) && ($_SESSION['usuarioLogueado'] == 'admin' || $_SESSION['usuarioLogueado'] == 'empleado') ){  ?>
        <div class="row justify-content-end">
            <div class="col-auto">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal"><i class="fa-solid fa-plus me-2"></i>Nueva incidencia</a>
            </div>
        </div>
        <?php } ?>
        <table class="table table-sm table-striped table-hover mt-4" >
            <thead class="table-dark ">
                <tr>
                    <th class="ps-4" >Empleado</th>
                    <th>Gdia</th>
                    <th>Estado Gdia</th>
                    <th>Ventanilla</th>
                    <th>Estado Vent</th>
                    <th>Tipología</th>
                    <th>Incidencia</th>
                    <th>Info adicional</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while($incidencia = $incidencias->fetch_assoc()){ 
                    $tipologiaId = $incidencia['tipologia'];
                    $sqlDescripcion = "SELECT descripcion FROM tipologia_inc WHERE id = $tipologiaId";
                    $resultadoDescripcion = $conexion->query($sqlDescripcion);
                    $descripcion = $resultadoDescripcion->fetch_assoc()['descripcion'];
                ?>
                    <tr>
                        <td><?= $incidencia['empleado'] ?></td>
                        <td><?= $incidencia['gdia'] ?></td>
                        <td><?= obtenerEstadoInc($incidencia['estado_gdia']) ?></td>
                        <td><?= $incidencia['ventanilla'] ?></td>
                        <td><?= obtenerEstadoInc($incidencia['estado_vent']) ?></td>
                        <td class="tipologia">
                            <?= obtenerTipologia($incidencia['tipologia']) ?>
                            <span class="descripcion"><?= $descripcion ?></span>
                        </td>
                        <td><?= $incidencia['incidencia'] ?></td>
                        <td><?= $incidencia['info_adicional'] ?></td>
                        <?php if(isset($_SESSION['usuarioLogueado']) && ($_SESSION['usuarioLogueado'] == 'admin' || $_SESSION['usuarioLogueado'] == 'empleado') ){  ?>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editaModal" data-bs-id="<?= $incidencia['id'] ?>" ><i class="fa-solid fa-pen-to-square"></i>Editar</a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-id="<?= $incidencia['id'] ?>" ><i class="fa-solid fa-trash me-1"></i>Eliminar</a>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php $contadorIncidencias ++ ?>
                <?php } ?>

            </tbody>
        </table>
        <div>
            <?php echo "Nº incidencias: $contadorIncidencias" ?>
        </div>
        <?php if(isset($_SESSION['usuarioLogueado']) && $_SESSION['usuarioLogueado'] == 'admin') {  ?>
            <div class="container mt-3">
                <div class="d-flex justify-content-end">
                    <form action="generarExcel.php" method="POST">
                        <button type="submit" class="btn btn-success" >Generar Excel</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php require 'footer.php'; ?>
    <?php 
        $sqlEmpleado = "SELECT id, empleado FROM empleados";
        $empleados = $conexion->query($sqlEmpleado);

        $sqlEstadoG = "SELECT id, estado FROM estado_inc";
        $estadosG = $conexion->query($sqlEstadoG);

        $sqlEstadoI = "SELECT id, estado FROM estado_inc";
        $estadosI = $conexion->query($sqlEstadoI);

        $sqlTipo = "SELECT id, tipologia FROM tipologia_inc";
        $tipos = $conexion->query($sqlTipo);
    ?>

    <?php include 'nuevoModal.php'; ?>
    <?php $empleados->data_seek(0); ?>
    <?php $estadosG->data_seek(0); ?>
    <?php $estadosI->data_seek(0); ?>
    <?php $tipos->data_seek(0); ?>
    <?php include 'editaModal.php'; ?>
    <?php include 'eliminaModal.php'; ?>
    <?php include 'loginModal.php'; ?>

    <script>
        let editaModal = document.getElementById('editaModal')
        let eliminaModal = document.getElementById('eliminaModal')
        let nuevoModal = document.getElementById('nuevoModal')

        nuevoModal.addEventListener('shown.bs.modal', event => { // Evento javascript para que se coloque el foco en el primer input
            nuevoModal.querySelector('.modal-body #id_empleado').focus()

        })

        nuevoModal.addEventListener('hide.bs.modal', event => { // Evento javascript para que una vez que se oculte el modal, se borren los datos
            nuevoModal.querySelector('.modal-body #id_empleado').value = ""
            nuevoModal.querySelector('.modal-body #gdia').value = ""
            nuevoModal.querySelector('.modal-body #estado_gdia').value = ""
            nuevoModal.querySelector('.modal-body #ventanilla').value = ""
            nuevoModal.querySelector('.modal-body #estado_vent').value = ""
            nuevoModal.querySelector('.modal-body #tipologia').value = ""
            nuevoModal.querySelector('.modal-body #incidencia').value = ""
            nuevoModal.querySelector('.modal-body #info_adicional').value = ""
            nuevoModal.querySelector('#errorNuevaIncidencia').innerHTML= "";
            nuevoModal.querySelector('.modal-body #errorNuevaIncidencia').classList.add('d-none');

        })

        editaModal.addEventListener('hide.bs.modal', event => { 
            editaModal.querySelector('.modal-body #id_empleado').value = ""
            editaModal.querySelector('.modal-body #gdia').value = ""
            editaModal.querySelector('.modal-body #estado_gdia').value = ""
            editaModal.querySelector('.modal-body #ventanilla').value = ""
            editaModal.querySelector('.modal-body #estado_vent').value = ""
            editaModal.querySelector('.modal-body #tipologia').value = ""
            editaModal.querySelector('.modal-body #incidencia').value = ""
            editaModal.querySelector('.modal-body #info_adicional').value = ""
            editaModal.querySelector('#errorActualizaIncidencia').innerHTML= "";
            editaModal.querySelector('.modal-body #errorActualizaIncidencia').classList.add('d-none');

        })



        editaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget    // Se detecta el botón al que se clicó
            let id = button.getAttribute('data-bs-id')

            let inputId = editaModal.querySelector('.modal-body #id')   // Busca el elemento que tenga como clase modal-body y el identificador id
            let inputEmpleado = editaModal.querySelector('.modal-body #id_empleado')
            let inputGdia = editaModal.querySelector('.modal-body #gdia')
            let inputEstado_Gdia = editaModal.querySelector('.modal-body #estado_gdia') 
            let inputVentanilla = editaModal.querySelector('.modal-body #ventanilla') 
            let inputEstado_Vent = editaModal.querySelector('.modal-body #estado_vent') 
            let inputTipologia = editaModal.querySelector('.modal-body #tipologia') 
            let inputIncidencia = editaModal.querySelector('.modal-body #incidencia') 
            let inputInfo_Adicional = editaModal.querySelector('.modal-body #info_adicional') 

            let url = "getIncidencia.php"
            let formData = new FormData();
            formData.append('id', id)

            fetch(url, {    // Petición ajax desde javascript
                method: "POST",
                body: formData
            }).then(response => response.json()).then(data => { // La variable data contiene los datos del registro solicitado que se adjudicaran a los elementos definidos anteriormente
                inputId.value = data.id
                inputEmpleado.value = data.id_empleado
                inputGdia.value = data.gdia
                inputEstado_Gdia.value = data.estado_gdia
                inputVentanilla.value = data.ventanilla
                inputEstado_Vent.value = data.estado_vent
                inputTipologia.value = data.tipologia
                inputIncidencia.value = data.incidencia
                inputInfo_Adicional.value = data.info_adicional


            }).catch(err => console.log(err))

        })

        eliminaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget    // Se detecta el botón al que se clicó
            let id = button.getAttribute('data-bs-id')    
            eliminaModal.querySelector('.modal-footer #id').value = id
        })




        // Evita que el loginModal se cierre si las credenciales introducidas son incorrectas
        document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita el envío tradicional del formulario

        let formData = new FormData(this); // Captura los datos del formulario

        fetch('loguear.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            let loginError = document.getElementById('loginError');

            if (data.success) {
                // Si el inicio de sesión es exitoso, redirige o cierra el modal
                let loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                loginModal.hide(); // Cierra el modal
                window.location.reload();
                // Opcional: Redirige a la página principal
                //window.location.href = 'index.php';
            } else {
                // Si hay un error, muestra el mensaje en el modal
                loginError.classList.remove('d-none');
                loginError.textContent = data.mensajeErrorLogin;

                // Borra los campos de contraseña (por seguridad)
                document.getElementById('clave').value = '';
            }
        })
        .catch(error => console.error('Error:', error));
    });    

    loginModal.addEventListener('hide.bs.modal', event => { // Evento javascript para que una vez que se oculte el modal, se borren los datos
        document.getElementById('usuario').value = '';
        document.getElementById('clave').value = '';
        loginModal.querySelector('.modal-body #loginError').classList.add('d-none');

        })

    document.getElementById('nuevaIncidenciaForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        let errorNuevaIncidencia = document.getElementById('errorNuevaIncidencia');

        fetch('almacenar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                // Mostrar errores
                errorNuevaIncidencia.classList.remove('d-none');
                errorNuevaIncidencia.innerHTML = data.erroresNuevaIncidencia.map(err => `<p>${err}</p>`).join('');
            } else {
                // Cerrar el modal y recargar la página para reflejar los cambios
                let nuevaIncidenciaModal = bootstrap.Modal.getInstance(document.getElementById('nuevoModal'));
                nuevaIncidenciaModal.hide();
                window.location.reload();
            }
        })
        .catch(err => console.error(err));

    });


    document.getElementById('actualizaIncidenciaForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        let errorActualizaIncidencia = document.getElementById('errorActualizaIncidencia');

        fetch('actualizar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                errorActualizaIncidencia.classList.remove('d-none');
                errorActualizaIncidencia.innerHTML = data.erroresActualizarIncidencia.map(err => `<p>${err}</p>`).join('');
            } else {
                let actualizaIncidenciaModal = bootstrap.Modal.getInstance(document.getElementById('editaModal'));
                actualizaIncidenciaModal.hide(); // Cierra el modal
                window.location.reload(); // Recargar para reflejar los cambios
            }
        })
        .catch(err => console.error(err));

    });

    </script>


    <script src="../../assets/js/bootstrap.bundle.min.js" ></script>
</body>
</html>