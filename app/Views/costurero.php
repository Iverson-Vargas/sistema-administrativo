<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<!-- 1. Estilos para el calendario (Flatpickr) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="container">
    <div style="margin-bottom: 10px;" class="row mt-3">
        <div class="col-md-12">
            <h3 class="text-center">Gestion de Costureros</h3>
            <hr>
            <button class="btn btn-primary"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalCrearCosturero"
                onclick="limpiarFormulario()">
                <i class="bi bi-plus-circle"></i>
                Crear Costurero
            </button>
                <table id="tablaCostureros" class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                         
                            <th>ID del Empleado</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cedula</th>
                            <th>Teléfono</th>
                            <th>Cargo</th>
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

<div class="modal fade" id="modalCrearCosturero" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nuevo Costurero</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="#" method="post">
                <div class="modal-body">

                    <h6 class="text-primary">Datos Personales</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tipo_persona">Tipo de Persona</label>
                            <select id="tipo_persona" class="form-select" required disabled>
                                <option value="N">Natural</option>
                                <option value="J">Jurídico</option>
                                <option value="G">Gubernamental</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ci_rif">Cédula</label> 
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
                            <input type="text" id="telefono" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="direccion">Dirección</label>
                            <textarea id="direccion" class="form-control" rows="2" required></textarea>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-success">Datos de Empleado</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_ingreso">Fecha de Ingreso</label>
                            <input type="text" id="fecha_ingreso" class="form-control" placeholder="AAAA/MM/DD" required>
                        </div>
                        <div class="col-md-6">
                            <label for="descripcion_cargo">Descripción de Cargo</label>
                            <input type="text" id="descripcion_cargo" class="form-control" value="Costurero" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="CrearCosturero()">Guardar</button>
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

    let tabla; // Declara la variable 'tabla' aquí para que sea global
    $(document).ready(function() {
        tabla = $('#tablaCostureros').DataTable({
            ajax: '<?= base_url('listaCostureros'); ?>',
            columnDefs: [{
                    targets: 0, // Columna "Seleccionar"
                    width: "10px", // Ancho reducido
                    className: "text-center", // Centrar contenido
                    orderable: false,
                    searchable: false
                },
                {
                    targets: [1, 2, 3, 4 , 5], // ID del Empleado, Nombre, Apellido, Cédula, Cargo
                    className: "text-center"
                }
            ],
            columns: [
                {
                    data: 'id_empleado'
                },
                {
                    data: 'nombre'
                },
                {
                    data: 'apellido'
                },
                {
                    data: 'ci_rif'
                },
                {
                    data: 'telefono'
                },
                {
                    data: 'descripcion_cargo'
                }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });

        // Lógica para permitir solo un checkbox seleccionado
        $('#tablaCostureros tbody').on('click', '.usuario-checkbox', function() {
            const clickedCheckbox = this;

            if ($(clickedCheckbox).is(':checked')) {
                // Desmarcar todos los demás checkboxes en el cuerpo de la tabla
                $('#tablaCostureros tbody .usuario-checkbox').not(clickedCheckbox).prop('checked', false);
            }
        });

    });

    function CrearCosturero() {
        const url = '<?= base_url('crearCosturero'); ?>';
        let tipo = document.getElementById('tipo_persona').value;
        let ci_rif = document.getElementById('ci_rif').value;
        let nombre = document.getElementById('nombre').value;
        let apellido = document.getElementById('apellido').value;
        let sexo = document.getElementById('sexo').value;
        let telefono = document.getElementById('telefono').value;
        let correo = document.getElementById('correo').value;
        let direccion = document.getElementById('direccion').value;
        let fecha_ingreso = document.getElementById('fecha_ingreso').value;
        let descripcion_cargo = document.getElementById('descripcion_cargo').value;

        if (tipo === '' || ci_rif === '' || nombre === '' || apellido === '' || sexo === '' || telefono === '' || correo === '' || direccion === '' || fecha_ingreso === '' || descripcion_cargo === '') {
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
                    fecha_ingreso: fecha_ingreso,
                    descripcion_cargo: descripcion_cargo
                })
            })
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                     tabla.ajax.reload(); // Descomenta esta línea cuando inicialices tu DataTable
                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalCrearCosturero'));
                    modal.hide();
                    limpiarFormulario();
                    let mensaje = 'El costurero fue creado correctamente.';
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



    function limpiarFormulario() {
        document.getElementById('ci_rif').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('apellido').value = '';
        document.getElementById('sexo').value = ''; // Restablece el select de sexo
        document.getElementById('telefono').value = '';
        document.getElementById('correo').value = '';
        document.getElementById('direccion').value = '';
        document.getElementById('fecha_ingreso').value = '';
        // Los campos deshabilitados como tipo_persona y descripcion_cargo no necesitan limpiarse
        // ya que mantienen sus valores fijos.
    }



    // 3. Activación del calendario en el campo de fecha
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#fecha_ingreso", {
            "locale": "es", // Usar el idioma español
            dateFormat: "Y/m/d", // Formato de fecha DD/MM/AAAA
        });
    });

</script>


<?php echo $this->endSection(); ?>