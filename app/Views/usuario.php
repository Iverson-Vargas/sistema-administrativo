<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<!-- 1. Estilos para el calendario (Flatpickr) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container">
    <div style="margin-bottom: 10px;" class="row mt-3">
        <div class="col-md-12">
            <h3 class="text-center">Gestion de Usuarios</h3>
            <hr>
            <div class="d-flex justify-content-start mb-3">
                <button class="btn btn-primary me-2"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#modalCrearUsuario"
                    onclick="limpiarFormulario()"><i class="bi bi-plus-circle"></i>
                    Crear Usuario
                </button>
                <button id="btnActualizar" class="btn btn-warning" style="color: #FCF7F7;"><i class="bi bi-pencil-square"></i> Actualizar </button>
            </div>
            <div class="tabla-scroll-vertical">

                <table id="tablaUsuarios" class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>ID del Usuario</th>
                            <th>Rol</th>
                            <th>Persona</th>
                            <th>Nick</th>
                            <th>Contraseña</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <!-- <tbody id="cuerpoTablaMisProductos">
                <!-- Los datos se llenarán con JavaScript -->
                    <!--</tbody> -->
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= base_url('usuario/guardar') ?>" method="post">
                <div class="modal-body">

                    <h6 class="text-primary">Datos Personales</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tipo_persona">Tipo de Persona</label>
                            <select id="tipo_persona" class="form-select" disabled>
                                <option value="N">Natural</option>
                                <option value="J">Jurídico</option>
                                <option value="G">Gubernamental</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ci_rif">Cédula / RIF</label>
                            <input type="text" id="ci_rif" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido">Apellido</label>
                            <input type="text" id="apellido" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sexo">Sexo</label>
                            <select id="sexo" class="form-select" required>
                                <option value="" selected disabled>Seleccione...</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" class="form-control">
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="direccion">Dirección</label>
                        <textarea id="direccion" class="form-control" rows="2"></textarea>
                    </div>

                    <hr>

                    <h6 class="text-success">Datos de Empleado y Rol</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="roles">Rol de Usuario</label>
                            <select type="text" class="form-select" id="roles"></select>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_ingreso">Fecha de Ingreso</label>
                            <input type="text" id="fecha_ingreso" class="form-control" placeholder="AAAA/MM/DD" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nick">Nick (Usuario)</label>
                            <input type="text" id="nick" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contrasena">Contraseña</label>
                            <div class="input-group">
                                <input type="password" id="contrasena" class="form-control" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="CrearUsuario()">Guardar Todo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Actualizar Usuario -->
<div class="modal fade" id="modalActualizarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_usuario_actualizar">
                <div class="mb-3">
                    <label for="roles_actualizar" class="form-label">Rol</label>
                    <select id="roles_actualizar" class="form-select"></select>
                </div>
                <div class="mb-3">
                    <label for="nick_actualizar" class="form-label">Nick</label>
                    <input type="text" id="nick_actualizar" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="contrasena_actualizar" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input type="password" id="contrasena_actualizar" class="form-control">
                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordActualizar">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" onclick="ActualizarUsuario()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>


<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>

<!-- 2. Librería JavaScript para el calendario (Flatpickr) -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
    // Declaramos la variable 'tabla' en un alcance más amplio
    // para que sea accesible en otras funciones.
    // Asegúrate de inicializar tu DataTable aquí.
    let tabla; // Declara la variable 'tabla' aquí para que sea global
    $(document).ready(function() {
        tabla = $('#tablaUsuarios').DataTable({
            ajax: '<?= base_url('listaUsuarios'); ?>',
            columnDefs: [{
                    targets: 0, // Columna "Seleccionar"
                    width: "10px", // Ancho reducido
                    className: "text-center", // Centrar contenido
                    orderable: false,
                    searchable: false
                },
                {
                    targets: [1, 2, 3, 4, 5, 6], // ID, Rol, Persona, Nick, Contraseña, Estatus
                    className: "text-center"
                }
            ],
            columns: [
                
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="usuario-checkbox" name="seleccionarUsuario" value="${data.id_usuario}">`;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id_usuario'
                },
                {
                    data: 'rol'
                },
                {
                    data: 'persona'
                },
                {
                    data: 'nick'
                },
                {
                    data: 'contrasena'
                },
                {
                    data: 'estatus'
                },
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });

        // Lógica para permitir solo un checkbox seleccionado
        $('#tablaUsuarios tbody').on('click', '.usuario-checkbox', function() {
            const clickedCheckbox = this;

            if ($(clickedCheckbox).is(':checked')) {
                // Desmarcar todos los demás checkboxes en el cuerpo de la tabla
                $('#tablaUsuarios tbody .usuario-checkbox').not(clickedCheckbox).prop('checked', false);
            }
        });

        $('#btnActualizar').on('click', function() {
            const checkboxSeleccionado = $('#tablaUsuarios tbody .usuario-checkbox:checked');

            if (checkboxSeleccionado.length === 0) {
                let mensaje = 'Por favor, seleccione un usuario para actualizar.';
                setTimeout(function() {
                    toast(mensaje);
                }, 500);
                return;
            }

            const idUsuario = checkboxSeleccionado.val();
            console.log("ID del usuario seleccionado:", idUsuario);
            // AJAX para obtener los datos del usuario
            $.ajax({
                url: `<?= base_url('getOneUsuario/') ?>/${idUsuario}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.success && response.data) {
                        // Accedemos al objeto del usuario dentro de response.data
                        const usuario = response.data; // response.data ya es el objeto del usuario
                        if (usuario) {
                            // Llenar el select de roles para la modal de actualización
                            ListarRoles('#roles_actualizar', usuario.id_roles);

                            // Llenar el formulario en el modal
                            $('#id_usuario_actualizar').val(usuario.id_usuario);
                            $('#nick_actualizar').val(usuario.nick);
                            $('#contrasena_actualizar').val(usuario.contrasena); // Dejar en blanco por seguridad

                            // Mostrar el modal
                            $('#modalActualizarUsuario').modal('show');
                        } else {
                            let mensaje = 'No se pudo obtener la información del usuario.';
                            setTimeout(function() {
                                toast(mensaje);
                            }, 500);
                        }
                    } else {
                        let mensaje = 'No se pudo obtener la información del usuario.';
                        setTimeout(function() {
                            toast(mensaje);
                        }, 500);
                    }
                },
                error: function() {
                    let mensaje = 'Error al contactar al servidor.';
                    setTimeout(function() {
                        toast(mensaje);
                    }, 500);
                }
            });
        });

        // Funcionalidad para mostrar/ocultar contraseña en modal de CREAR
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#contrasena');
        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye icon
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            } else {
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            }
        });

        // Funcionalidad para mostrar/ocultar contraseña en modal de ACTUALIZAR
        const togglePasswordActualizar = document.querySelector('#togglePasswordActualizar');
        const passwordActualizar = document.querySelector('#contrasena_actualizar');
        togglePasswordActualizar.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = passwordActualizar.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordActualizar.setAttribute('type', type);
            // toggle the eye icon
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            } else {
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            }
        });
    });

    window.onload = function() {
        ListarRoles('#roles');
    };

    function CrearUsuario() {
        const url = '<?= base_url('crearUsuario'); ?>';
        let tipo = document.getElementById('tipo_persona').value;
        let ci_rif = document.getElementById('ci_rif').value;
        let nombre = document.getElementById('nombre').value;
        let apellido = document.getElementById('apellido').value;
        let sexo = document.getElementById('sexo').value;
        let telefono = document.getElementById('telefono').value;
        let correo = document.getElementById('correo').value;
        let direccion = document.getElementById('direccion').value;
        let roles = document.getElementById('roles').value;
        let nick = document.getElementById('nick').value;
        let contrasena = document.getElementById('contrasena').value;
        let fecha_ingreso = document.getElementById('fecha_ingreso').value;
        
        if (tipo === '' || ci_rif === '' || nombre === '' || apellido === '' || sexo === '' || telefono === '' || correo === '' || direccion === '' || roles === '' || nick === '' || contrasena === '' || fecha_ingreso === '') {
            // Usamos la función toast para notificar al usuario, ya que el elemento 'resultado' no existe.
            toast('Por favor, complete todos los campos.');
            return;
        }

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    tipo: tipo,
                    ci_rif: ci_rif,
                    nombre: nombre,
                    apellido: apellido,
                    sexo: sexo,
                    telefono: telefono,
                    correo: correo,
                    direccion: direccion,
                    roles: roles,
                    nick: nick,
                    contrasena: contrasena,
                    fecha_ingreso: fecha_ingreso
                })
            })
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    tabla.ajax.reload(); // Descomenta esta línea cuando inicialices tu DataTable
                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalCrearUsuario'));
                    modal.hide();
                    let mensaje = 'El usuario fue creado correctamente.';
                    setTimeout(function() {
                        toast(mensaje)
                    }, 500);
                } else {
                    // Usamos el mensaje de error específico que nos envía el servidor
                    let mensaje = respuesta.message;
                    setTimeout(function() {
                        toast(mensaje)
                    }, 500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toast('Ocurrió un error de comunicación con el servidor.');
            })
    }

    function ActualizarUsuario() {
        let id_usuario = document.getElementById('id_usuario_actualizar').value;
        const url = `<?= base_url('actualizarUsuario/'); ?>${id_usuario}`;
        let id_roles = document.getElementById('roles_actualizar').value;
        let nick = document.getElementById('nick_actualizar').value;
        let contrasena = document.getElementById('contrasena_actualizar').value;

        if (!id_roles || !nick) {
            toast('Por favor, complete todos los campos requeridos.');
            return;
        }

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id_roles: id_roles,
                nick: nick,
                contrasena: contrasena // Enviar vacía si no se cambia
            })
        })
        .then(response => response.json())
        .then(respuesta => {
            if (respuesta.success) {
                tabla.ajax.reload();
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalActualizarUsuario'));
                modal.hide();
                toast('El usuario fue actualizado correctamente.');
            } else {
                toast(respuesta.message || 'Ocurrió un error al actualizar.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toast('Ocurrió un error de comunicación con el servidor.');
        });
    }

    function ListarRoles(selector, selectedId = null) {

        const url = '<?= base_url('listaRoles') ?>';
        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    let select = document.querySelector(selector);
                    select.innerHTML = '<option value="" selected disabled>Seleccione...</option>';
                    respuesta.data.forEach(rol => {
                        let option = document.createElement('option');
                        option.value = rol.id_roles;
                        option.textContent = rol.tipo_rol;
                        select.appendChild(option);
                    });
                    if (selectedId) {
                        select.value = selectedId;
                    }
                } else {
                    alert('Error al cargar los roles.')
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function limpiarFormulario() {
        document.getElementById('roles').value = '';
        document.getElementById('tipo_persona').value = 'N';
        document.getElementById('ci_rif').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('apellido').value = '';
        document.getElementById('sexo').value = '';
        document.getElementById('telefono').value = '';
        document.getElementById('correo').value = '';
        document.getElementById('direccion').value = '';
        document.getElementById('nick').value = '';
        document.getElementById('contrasena').value = '';
        document.getElementById('fecha_ingreso').value = '';
    }

    // 3. Activación del calendario en el campo de fecha
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#fecha_ingreso", {
            "locale": "es", // Usar el idioma español
            dateFormat: "Y/m/d", // Formato de fecha AAAA/MM/DD
        });
    });
</script>


<?php echo $this->endSection(); ?>