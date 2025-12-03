<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<!-- 1. Estilos para el calendario (Flatpickr) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container">
    <div style="margin-bottom: 10px;" class="row mt-3">
        <div class="col-md-12">
            <h3 class="text-center">Gestion de Usuarios</h3>
            <hr>
            <button class="btn btn-primary"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalCrearUsuario"
                onclick="limpiarFormulario()">
                Crear Usuario
            </button>
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
                        <div class="col-md-6">
                            <label for="sexo">Sexo</label>
                            <select id="sexo" class="form-select" required>
                                <option value="" selected disabled>Seleccione...</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
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
                        <div class="col-md-4">
                            <label for="roles">Rol de Usuario</label>
                            <select type="text" class="form-select" id="roles"></select>
                        </div>
                        <div class="col-md-4">
                            <label for="nick">Nick (Usuario)</label>
                            <input type="text" id="nick" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="contrasena">Contraseña</label>
                            <input type="password" id="contrasena" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_ingreso">Fecha de Ingreso</label>
                            <input type="text" id="fecha_ingreso" class="form-control" placeholder="AAAA/MM/DD" required>
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

    });

    window.onload = function() {
        ListarRoles();
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

    function ListarRoles() {

        const url = '<?= base_url('listaRoles') ?>';
        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    let select = document.getElementById('roles');
                    select.innerHTML = '';
                    respuesta.data.forEach(rol => {

                        let option = document.createElement('option');
                        option.value = rol.id_roles;
                        option.textContent = rol.tipo_rol;
                        select.appendChild(option);
                    });
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