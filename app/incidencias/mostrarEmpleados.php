<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/all.min.css" rel="stylesheet">
    <link href="../../assets/css/indexStyle.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<?php 
    require '../config/database.php';

    session_start();

    $sqlEmpleados = "SELECT id, empleado, nombre, apellidos FROM empleados";
    $empleados = $conexion->query($sqlEmpleados);
?>
    <?php require 'header.php'; ?>
    <?php $_SESSION['paginaAnterior'] = 'mostrarEmpleados.php'; ?>
    <div class="container py-3">
    <h2 class="text-center">Empleados</h2>
        <?php if(isset($_SESSION['usuarioLogueado']) && $_SESSION['usuarioLogueado'] == 'admin') {  ?>
            <div class="row justify-content-end">
            <div class="col-auto">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoEmpleadoModal"><i class="fa-solid fa-plus me-2"></i>Nuevo empleado</a>
            </div>
            </div>
        <?php } ?>
        <table class="table">
        <thead>
            <tr>
                <th scope="col">identificador</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <?php if(isset($_SESSION['usuarioLogueado']) && $_SESSION['usuarioLogueado'] == 'admin') {  ?>
                    <th scope="col"></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php while($empleado = $empleados->fetch_assoc()){ 
                if($empleado['empleado'] != 'admin'){
            ?>
            <tr>
                <td><?= $empleado['empleado'] ?></td>
                <td><?= $empleado['nombre'] ?></td>
                <td><?= $empleado['apellidos'] ?></td>
                <?php if(isset($_SESSION['usuarioLogueado']) && $_SESSION['usuarioLogueado'] == 'admin') {  ?>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editaEmpleadoModal" data-bs-idEmpleado="<?= $empleado['id'] ?>" ><i class="fa-solid fa-pen-to-square"></i>Editar</a>
                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaEmpleadoModal" data-bs-idEmpleado="<?= $empleado['id'] ?>" ><i class="fa-solid fa-trash me-1"></i>Eliminar</a>
                    </td>
                <?php } ?>
            </tr>
        <?php 
                }
            } ?>
        </tbody>
        </table>
        <div class="d-flex justify-content-center mt-5">
            <a class="btn btn-light" href="index.php" role="button">Volver a las incidencias</a>
        </div>
    </div>
    <?php require 'footer.php'; ?>
    <?php include 'nuevoEmpleadoModal.php'; ?>
    <?php include 'eliminaEmpleadoModal.php'; ?>
    <?php include 'editaEmpleadoModal.php'; ?>
    <?php include 'loginModal.php'; ?>
 
    <script>
        let editaEmpleadoModal = document.getElementById('editaEmpleadoModal')
        let eliminaEmpleadoModal = document.getElementById('eliminaEmpleadoModal')
        let nuevoEmpleadoModal = document.getElementById('nuevoEmpleadoModal')

        nuevoEmpleadoModal.addEventListener('shown.bs.modal', event => { // Evento javascript para que se coloque el foco en el primer input
            nuevoEmpleadoModal.querySelector('.modal-body #empleado').focus()

        })       

        eliminaEmpleadoModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget    // Se detecta el botón al que se clicó
            let idEmpleado = button.getAttribute('data-bs-idEmpleado')    
            eliminaEmpleadoModal.querySelector('.modal-footer #idEmpleado').value = idEmpleado
        })

        nuevoEmpleadoModal.addEventListener('hide.bs.modal', event => { // Evento javascript para que una vez que se oculte el modal, se borren los datos
            nuevoEmpleadoModal.querySelector('.modal-body #empleado').value = ""
            nuevoEmpleadoModal.querySelector('.modal-body #nombre').value = ""
            nuevoEmpleadoModal.querySelector('.modal-body #apellidos').value = ""
            nuevoEmpleadoModal.querySelector('.modal-body #clave').value = ""
            nuevoEmpleadoModal.querySelector('.modal-body #cargo').value = ""
            nuevoEmpleadoModal.querySelector('#errorNuevoEmpleado').innerHTML= "";
            nuevoEmpleadoModal.querySelector('.modal-body #errorNuevoEmpleado').classList.add('d-none');
        })

        editaEmpleadoModal.addEventListener('hide.bs.modal', event => { // Evento javascript para que una vez que se oculte el modal, se borren los datos
            editaEmpleadoModal.querySelector('.modal-body #empleado').value = ""
            editaEmpleadoModal.querySelector('.modal-body #nombre').value = ""
            editaEmpleadoModal.querySelector('.modal-body #apellidos').value = ""
            editaEmpleadoModal.querySelector('.modal-body #clave').value = ""
            editaEmpleadoModal.querySelector('.modal-body #cargo').value = ""
            editaEmpleadoModal.querySelector('#errorActualizaEmpleado').innerHTML="";
            editaEmpleadoModal.querySelector('.modal-body #errorActualizaEmpleado').classList.add('d-none');
        })

        editaEmpleadoModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget    // Se detecta el botón al que se clicó
            let idEmpleado = button.getAttribute('data-bs-idEmpleado')

            let inputIdEmpleado = editaEmpleadoModal.querySelector('.modal-body #idEmpleado')   // Busca el elemento que tenga como clase modal-body y el identificador idEmpleado
            let inputEmpleado = editaEmpleadoModal.querySelector('.modal-body #empleado')
            let inputNombre = editaEmpleadoModal.querySelector('.modal-body #nombre')
            let inputApellidos = editaEmpleadoModal.querySelector('.modal-body #apellidos') 
            let inputClave = editaEmpleadoModal.querySelector('.modal-body #clave') 
            let inputCargo = editaEmpleadoModal.querySelector('.modal-body #cargo') 

            let url = "getEmpleado.php"
            let formData = new FormData();
            formData.append('idEmpleado', idEmpleado)

            fetch(url, {    // Petición ajax desde javascript
                method: "POST",
                body: formData
            }).then(response => response.json()).then(data => { // La variable data contiene los datos del registro solicitado que se adjudicaran a los elementos definidos anteriormente
                inputIdEmpleado.value = data.id
                inputEmpleado.value = data.empleado
                inputNombre.value = data.nombre
                inputApellidos.value = data.apellidos
                inputClave.value = data.clave
                inputCargo.value = data.cargo

            }).catch(err => console.log(err))

        })

        document.getElementById('nuevoEmpleadoForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        let errorContainer = document.getElementById('errorNuevoEmpleado');

        fetch('insertarUsuario.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                errorContainer.classList.remove('d-none');
                errorContainer.innerHTML = data.erroresInsertarUsuario.map(err => `<p>${err}</p>`).join('');
            } else {
                let nuevoEmpleadoModal = bootstrap.Modal.getInstance(document.getElementById('nuevoEmpleadoModal'));
                nuevoEmpleadoModal.hide(); // Cierra el modal
                window.location.reload(); // Recargar para reflejar los cambios
            }
        })
        .catch(err => console.error(err));
    });

    document.getElementById('actualizaEmpleadoForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        let errorEditando = document.getElementById('errorActualizaEmpleado');

        fetch('actualizarEmpleado.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                errorEditando.classList.remove('d-none');
                errorEditando.innerHTML = data.erroresActualizarEmpleado.map(err => `<p>${err}</p>`).join('');
            } else {
                let editaEmpleadoModal = bootstrap.Modal.getInstance(document.getElementById('editaEmpleadoModal'));
                editaEmpleadoModal.hide(); // Cierra el modal
                window.location.reload(); // Recargar para reflejar los cambios
            }
        })
        .catch(err => console.error(err));
    });

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

    </script>


    <script src="../../assets/js/bootstrap.bundle.min.js" ></script>
</body>
</html>