<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<div class="container">
    <div style="margin-bottom: 10px;" class="row mt-3">
        <div class="col-md-12">
            <h3 class="text-center">Gestion de Productos</h3>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-primary"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#modalCrearProducto"
                    onclick="limpiarFormulario()">
                    <i class="bi bi-plus-circle"></i>
                    Crear Producto
                </button>
                <div>
                    <button id="btnActualizar" class="btn btn-warning me-2" style="color: #FCF7F7;"><i class="bi bi-pencil-square"></i> Actualizar </button>
                    <button id="btnEliminar" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar </button>
                </div>
            </div>
            <div class="tabla-scroll-vertical">

                <table id="tablaMisProductos" class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>ID del Producto</th>
                            <th>Tono</th>
                            <th>Talla</th>
                            <th>Descripcion</th>
                            <th>Precio Unitario</th>
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

<div class="modal fade" id="modalCrearProducto" tabindex="-1" aria-labelledby="modalCrearProducto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCrearProducto">Crear Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Detalles del Producto</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="idProducto" class="form-label">Ingresar ID del Producto</label>
                        <input type="text" class="form-control" id="idProducto">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="precioUnitario" class="form-label">Ingresar Precio Unitario</label>
                        <input type="number" class="form-control" id="precioUnitario">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tonoProducto" class="form-label">Seleccionar tono del producto</label>
                        <select type="text" class="form-select" id="tonoProducto"></select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tallaProducto" class="form-label">Seleccionar talla del producto</label>
                        <select type="text" class="form-select" id="tallaProducto"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="text" class="form-control" id="descripcion" rows="2"></textarea>
                    </div>
                </div>
                <div id="resultado"></div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="CrearProducto()">Crear Producto</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal para actualizar -->
<div class="modal fade" id="modalActualizarProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-theme="light">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Información del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_producto_actualizar">
                <div class="mb-3">
                    <label for="descripcion_actualizar" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion_actualizar" name="descripcion" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label for="precioUnitario_actualizar" class="form-label">Precio Unitario</label>
                    <input type="number" class="form-control" id="precioUnitario_actualizar" name="precio_unitario">
                </div>
                <div class="mb-3">
                    <label for="tonoProducto_actualizar" class="form-label">Tono del producto</label>
                    <select class="form-select" id="tonoProducto_actualizar" name="id_tono"></select>
                </div>
                <div class="mb-3">
                    <label for="tallaProducto_actualizar" class="form-label">Talla del producto</label>
                    <select class="form-select" id="tallaProducto_actualizar" name="id_talla"></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btnGuardarCambios" onclick="guardarCambios()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true" data-bs-theme="light">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea eliminar este producto? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Sí, eliminar</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>
<script>
    window.onload = function() {
        listarTonos('#tonoProducto');
        listarTallas('#tallaProducto');
    };

    let tabla; // Declara la variable 'tabla' aquí para que sea global
    $(document).ready(function() {
        tabla = $('#tablaMisProductos').DataTable({
            ajax: '<?= base_url('listaProducto'); ?>',
            columns: [{
                    data: null,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="producto-checkbox" name="seleccionarProducto" value="${data.id_producto}">`;
                    }
                },
                {
                    data: 'id_producto'
                },
                {
                    data: 'tono'
                },
                {
                    data: 'talla'
                },
                {
                    data: 'descripcion'
                },
                {
                    data: 'precio_unitario'
                },
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });

        // Lógica para permitir solo un checkbox seleccionado
        $('#tablaMisProductos tbody').on('click', '.producto-checkbox', function() {
            const clickedCheckbox = this;

            if ($(clickedCheckbox).is(':checked')) {
                // Desmarcar todos los demás checkboxes en el cuerpo de la tabla
                $('#tablaMisProductos tbody .producto-checkbox').not(clickedCheckbox).prop('checked', false);
            }
        });

        $('#btnActualizar').on('click', function() {
            const checkboxSeleccionado = $('#tablaMisProductos tbody .producto-checkbox:checked');

            if (checkboxSeleccionado.length === 0) {
                toast('Por favor, seleccione un producto para actualizar.');
                return;
            }

            const idProducto = checkboxSeleccionado.val();

            $.ajax({
                url: `<?= base_url('getOneProducto') ?>/${idProducto}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.success && response.data) {
                        const producto = response.data;
                        
                        // Llenar los selects y luego el resto del formulario
                        listarTonos('#tonoProducto_actualizar', producto.id_tono);
                        listarTallas('#tallaProducto_actualizar', producto.id_talla);

                        $('#id_producto_actualizar').val(producto.id_producto);
                        $('#precioUnitario_actualizar').val(producto.precio_unitario);
                        $('#descripcion_actualizar').val(producto.descripcion);

                        $('#modalActualizarProducto').modal('show');
                    } else {
                        toast(response.message || 'No se pudo obtener la información del producto.');
                    }
                },
                error: function() {
                    toast('Error al contactar al servidor.');
                }
            });
        });

        $('#btnEliminar').on('click', function() {
            const checkboxSeleccionado = $('#tablaMisProductos tbody .producto-checkbox:checked');

            if (checkboxSeleccionado.length === 0) {
                toast('Por favor, seleccione un producto para eliminar.');
                return;
            }

            const idProducto = checkboxSeleccionado.val();
            const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
            modal.show();

            $('#btnConfirmarEliminar').off('click').on('click', function() {
                $.ajax({
                    url: `<?= base_url('eliminarProducto/') ?>/${idProducto}`,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.success) {
                            toast('Producto eliminado correctamente.');
                            tabla.ajax.reload();
                        } else {
                            toast(response.message || 'Error al eliminar el producto.');
                        }
                    },
                    error: function() {
                        toast('Error al contactar al servidor.');
                    },
                    complete: function() {
                        modal.hide();
                    }
                });
            });
        });
    });

    function listarTonos(selector, selectedId = null) {

        const url = '<?= base_url('listaTono') ?>';
        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    let select = document.querySelector(selector);
                    select.innerHTML = '<option value="" selected disabled>Seleccione...</option>';
                    respuesta.data.forEach(tono => {
                        let option = document.createElement('option');
                        option.value = tono.id_tono;
                        option.textContent = tono.descripcion;
                        select.appendChild(option);
                    });
                    if (selectedId) {
                        select.value = selectedId;
                    }
                } else {
                    alert('Error al cargar los tonos.')
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function listarTallas(selector, selectedId = null) {

        const url = '<?= base_url('listaTalla') ?>';
        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    let select = document.querySelector(selector);
                    select.innerHTML = '<option value="" selected disabled>Seleccione...</option>';
                    respuesta.data.forEach(talla => {
                        let option = document.createElement('option');
                        option.value = talla.id_talla;
                        option.textContent = talla.descripcion;
                        select.appendChild(option);
                    });
                    if (selectedId) {
                        select.value = selectedId;
                    }
                } else {
                    alert('Error al cargar las tallas.')
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function CrearProducto() {
        const url = '<?= base_url('crearProducto'); ?>';
        let idProducto = document.getElementById('idProducto').value;
        let tonoProducto = document.getElementById('tonoProducto').value;
        let tallaProducto = document.getElementById('tallaProducto').value;
        let descripcion = document.getElementById('descripcion').value;
        let precioUnitario = document.getElementById('precioUnitario').value;

        if (idProducto === '' || tonoProducto === '' || tallaProducto === '' || descripcion === '' || precioUnitario === '') {
            const mensaje = document.getElementById('resultado');
            mensaje.innerHTML = '<div class="alert alert-danger" role="alert">Por favor, complete todos los campos.</div>';
            return;
        }

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    idProducto: idProducto,
                    tonoProducto: tonoProducto,
                    tallaProducto: tallaProducto,
                    descripcion: descripcion,
                    precioUnitario: precioUnitario
                })
            })
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    tabla.ajax.reload();
                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalCrearProducto'));
                    modal.hide();
                    let mensaje = 'El producto fue creado correctamente.';
                    setTimeout(function() {
                        toast(mensaje)
                    }, 500);
                } else {
                    mensaje = 'Error al crear el producto.';
                    setTimeout(function() {
                        toast(mensaje)
                    }, 500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
    }

    function guardarCambios() {
        const idProducto = $('#id_producto_actualizar').val();
        const datosActualizar = {
            id_tono: $('#tonoProducto_actualizar').val(),
            id_talla: $('#tallaProducto_actualizar').val(),
            descripcion: $('#descripcion_actualizar').val(),
            precio_unitario: $('#precioUnitario_actualizar').val()
        };

        $.ajax({
            url: `<?= base_url('actualizarProducto/') ?>/${idProducto}`,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(datosActualizar),
            dataType: 'json',
            success: function(response) {
                if (response && response.success) {
                    toast('Producto actualizado exitosamente.');
                    $('#modalActualizarProducto').modal('hide');
                    tabla.ajax.reload();
                } else {
                    toast(response.message || 'Error al actualizar el producto.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
                console.error('Detalles del error:', xhr.responseText);
                toast('Error al contactar al servidor.');
            }
        });
    }

    function limpiarFormulario() {
        document.getElementById('idProducto').value = '';
        document.getElementById('tonoProducto').value = '';
        document.getElementById('tallaProducto').value = '';
        document.getElementById('descripcion').value = '';
        document.getElementById('precioUnitario').value = '';
    }
</script>
<?php echo $this->endSection(); ?>