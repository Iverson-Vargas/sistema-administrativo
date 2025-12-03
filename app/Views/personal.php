<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

    <div class="row mt-1 " style="position: relative; right: 13px;">
        <div class="col-md-12">
            <h3 class="text-center">Gestion de Personal</h3>
            <hr>
            <div class="d-flex justify-content-end mb-3">
                <button id="btnActualizar" class="btn btn-warning me-2" style="color: #FCF7F7;"><i class="bi bi-pencil-square"></i> Actualizar </button>
                <button id="btnDeshabilitar" class="btn btn-danger"><i class="bi bi-trash"></i> Deshabilitar </button>
            </div>


            <div class="tabla-scroll-vertical">

                <table id="tablaPersonal" class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                            <th class="text-center">Seleccionar</th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Apellido</th>
                            <th class="text-center">Sexo</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Direccion</th>
                            <th class="text-center">Telefono</th>
                            <th class="text-center">Correo</th>
                            <th class="text-center">CI/RIF</th>
                            <th class="text-center">F. Ingreso</th>
                            <th class="text-center">Estatus</th>
                        </tr>
                    </thead>
                    <!-- <tbody id="cuerpoTablaMisProductos">
                <!-- Los datos se llenarán con JavaScript -->
                    <!--</tbody> -->
                </table>
            </div>
        </div>
    </div>

<!-- Modal para actualizar -->
<div class="modal fade" id="modalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Información del Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formActualizarEmpleado">
                    <input type="hidden" id="id_empleado_actualizar" name="id_empleado">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre_actualizar" name="nombre">
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido_actualizar" name="apellido">
                            </div>
                            <div class="mb-3">
                                <label for="ci_rif" class="form-label">CI/RIF</label>
                                <input type="text" class="form-control" id="ci_rif_actualizar" name="ci_rif">
                            </div>
                            <div class="mb-3">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-select" id="sexo_actualizar" name="sexo">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono_actualizar" name="telefono">
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correo_actualizar" name="correo">
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <textarea class="form-control" id="direccion_actualizar" name="direccion" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarCambios" onclick="guardarCambios()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar deshabilitación -->
<div class="modal fade" id="modalDeshabilitar" tabindex="-1" aria-labelledby="modalDeshabilitarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeshabilitarLabel">Confirmar Deshabilitación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea deshabilitar a este empleado? Esta acción no se puede deshacer fácilmente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarDeshabilitar">Sí, deshabilitar</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>

<script>
    let tabla; // Declara la variable 'tabla' aquí para que seja global
    $(document).ready(function() {
        tabla = $('#tablaPersonal').DataTable({
            ajax: '<?= base_url('listaEmpleados'); ?>',
            columnDefs: [{
                    targets: 0, // Columna "Seleccionar"
                    width: "10px", // Ancho reducido
                    className: "text-center", // Centrar contenido
                    orderable: false,
                    searchable: false
                },
                {
                    targets: [1, 4, 5, 11], // ID, Sexo, Tipo, Estatus
                    className: "text-center"
                }
            ],
            columns: [
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="empleado-checkbox" name="seleccionarEmpleado" value="${data.id_empleado}">`;
                    }
                },
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
                    data: 'sexo'
                },
                {
                    data: 'tipo'
                },
                {
                    data: 'direccion'
                },
                {
                    data: 'telefono'
                },
                {
                    data: 'correo'
                },
                {
                    data: 'ci_rif'
                },
                {
                    data: 'fecha_ingreso'
                },
                {
                    data: 'estatus'
                }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });

        // Lógica para permitir solo un checkbox seleccionado
        $('#tablaPersonal tbody').on('click', '.empleado-checkbox', function() {
            const clickedCheckbox = this;

            if ($(clickedCheckbox).is(':checked')) {
                // Desmarcar todos los demás checkboxes en el cuerpo de la tabla
                $('#tablaPersonal tbody .empleado-checkbox').not(clickedCheckbox).prop('checked', false);
            }
        });

        $('#btnActualizar').on('click', function() {
            const checkboxSeleccionado = $('#tablaPersonal tbody .empleado-checkbox:checked');

            if (checkboxSeleccionado.length === 0) {
                let mensaje = 'Por favor, seleccione un empleado para actualizar.';
                setTimeout(function() {
                    toast(mensaje);
                }, 500);
                return;
            }

            const idEmpleado = checkboxSeleccionado.val();
            console.log("ID del empleado seleccionado:", idEmpleado);
            // AJAX para obtener los datos del empleado
            $.ajax({
                url: `<?= base_url('getOneEmpleado/') ?>/${idEmpleado}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Asegurarse de que la respuesta no está vacía y tomar el primer elemento si es un array
                    if (response && response.success) {
                        // Accedemos al objeto del empleado dentro de response.data
                        const empleado = response.data;
                        if (empleado) {
                            // Llenar el formulario en el modal
                            $('#id_empleado_actualizar').val(empleado.id_empleado);
                            $('#nombre_actualizar').val(empleado.nombre);
                            $('#apellido_actualizar').val(empleado.apellido);
                            $('#ci_rif_actualizar').val(empleado.ci_rif);
                            $('#sexo_actualizar').val(empleado.sexo);
                            $('#telefono_actualizar').val(empleado.telefono);
                            $('#correo_actualizar').val(empleado.correo);
                            $('#direccion_actualizar').val(empleado.direccion);

                            // Mostrar el modal
                            $('#modalActualizar').modal('show');
                        } else {
                            let mensaje = 'No se pudo obtener la información del empleado.';
                            setTimeout(function() {
                                toast(mensaje);
                            }, 500);
                        }
                    } else {
                        let mensaje = 'No se pudo obtener la información del empleado.';
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

        $('#btnDeshabilitar').on('click', function() {
            const checkboxSeleccionado = $('#tablaPersonal tbody .empleado-checkbox:checked');

            if (checkboxSeleccionado.length === 0) {
                setTimeout(() => toast('Por favor, seleccione un empleado para deshabilitar.'), 500);
                return;
            }

            const idEmpleado = checkboxSeleccionado.val();
            const modal = new bootstrap.Modal(document.getElementById('modalDeshabilitar'));
            modal.show();

            // Al hacer clic en el botón de confirmación del modal
            $('#btnConfirmarDeshabilitar').off('click').on('click', function() {
                 $.ajax({
                     url: `<?= base_url('deshabilitarEmpleado/') ?>/${idEmpleado}`,
                     type: 'POST',
                     dataType: 'json',
                     success: function(response) {
                         if (response && response.success) {
                             toast('Empleado deshabilitado correctamente.');
                             tabla.ajax.reload(); // Recargar la tabla
                         } else {
                             // Usar el mensaje del servidor si está disponible
                             const mensaje = response.message || 'Error al deshabilitar el empleado.';
                             toast(mensaje);
                         }
                     },
                     error: function(xhr, status, error) {
                         console.error('Error en la solicitud AJAX:', error);
                         console.error('Detalles del error:', xhr.responseText);
                         toast('Error al contactar al servidor.');
                     },
                    complete: function() {
                        modal.hide();
                    }
                 });
            });
        });
    });

    function guardarCambios() {
        const idEmpleado = $('#id_empleado_actualizar').val();
        const datosActualizar = {
            nombre: $('#nombre_actualizar').val(),
            apellido: $('#apellido_actualizar').val(),
            ci_rif: $('#ci_rif_actualizar').val(),
            sexo: $('#sexo_actualizar').val(),
            telefono: $('#telefono_actualizar').val(),
            correo: $('#correo_actualizar').val(),
            direccion: $('#direccion_actualizar').val()
        };

        // Depuración: Verificar los datos antes de enviarlos
        console.log('Datos a enviar:', datosActualizar);

        $.ajax({
            url: `<?= base_url('actualizarEmpleado/') ?>/${idEmpleado}`,
            type: 'POST',
            contentType: 'application/json', // Especifica que estamos enviando JSON
            data: JSON.stringify(datosActualizar), // Convierte el objeto a una cadena JSON
            dataType: 'json', // Espera una respuesta JSON del servidor
            success: function(response) {
                console.log('Respuesta del servidor:', response); // Depuración
                if (response && response.success) {
                    let mensaje = 'Empleado actualizado exitosamente.';
                    setTimeout(function() {
                        toast(mensaje);
                    }, 500);
                    $('#modalActualizar').modal('hide');
                    tabla.ajax.reload(); // Recargar la tabla para reflejar los cambios
                } else {
                    let mensaje = 'Error al actualizar el empleado.';
                    setTimeout(function() {
                        toast(mensaje);
                    }, 500);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error); // Depuración
                console.error('Detalles del error:', xhr.responseText); // Depuración
                let mensaje = 'Error al contactar al servidor.';
                setTimeout(function() {
                    toast(mensaje);
                }, 500);
            }
        });
    }

</script>

    <?php echo $this->endSection(); ?>