<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<div class="container">
    <div style="margin-bottom: 10px;" class="row mt-3">
    <style>
        .page-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .action-btn {
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
    </style>
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="page-header">
                <h2 class="fw-bold mb-0"><i style="position: relative; right: 15px; bottom: 3px;" class="bi bi-box-seam-fill me-2"></i>Gestión de Productos</h2>
                <p class="mb-0 opacity-75">Administre su inventario de productos de manera eficiente</p>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-primary action-btn"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#modalCrearProducto"
                    onclick="limpiarFormulario()">
                    <i class="bi bi-plus-circle"></i>
                    Crear Producto
                </button>
                <div>
                    <button id="btnActualizar" class="btn btn-warning me-2 action-btn text-white"><i class="bi bi-pencil-square"></i> Actualizar </button>
                    <button id="btnEliminar" class="btn btn-danger action-btn"><i class="bi bi-trash"></i> Eliminar </button>
                </div>
            </div>
            <div class="tabla-scroll-vertical table-container">

                <table id="tablaMisProductos" class="table table-hover table-bordered mt-3 align-middle">
                    <thead>
                        <tr class="table-light">
                            <th>Seleccionar</th>
                            <th>ID del Producto</th>
                            <th>Nombre</th>
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

<div class="modal fade" id="modalCrearProducto" tabindex="-1" aria-labelledby="modalCrearProductoLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalCrearProductoLabel">
                    <i class="bi bi-box-seam-fill me-2"></i>Registrar Nuevo Producto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-4">Complete la información del producto a continuación.</p>
                
                <div class="row g-3">
                    <!-- Fila 1: ID y Precio -->
                    <div class="col-md-6">
                        <label for="idProducto_crear" class="form-label fw-semibold">ID del Producto</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-upc-scan"></i></span>
                            <input type="text" class="form-control" id="idProducto_crear" placeholder="Ej: PROD-001">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="precioUnitario_crear" class="form-label fw-semibold">Precio Unitario</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">$</span>
                            <input type="number" class="form-control" id="precioUnitario_crear" placeholder="0.00" step="0.01">
                        </div>
                    </div>

                    <!-- Fila 2: Nombre -->
                    <div class="col-12">
                        <label for="nombreProducto_crear" class="form-label fw-semibold">Nombre del Producto</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                            <input type="text" class="form-control" id="nombreProducto_crear" placeholder="Ej: Pantalón Jeans Clásico">
                        </div>
                    </div>

                    <!-- Fila 3: Descripción -->
                    <div class="col-12">
                        <label for="descripcion_crear" class="form-label fw-semibold">Descripción</label>
                        <textarea class="form-control" id="descripcion_crear" rows="3" placeholder="Ingrese una descripción detallada del producto..."></textarea>
                    </div>
                </div>
                <div id="resultado" class="mt-3"></div>

                <div class="modal-footer bg-light mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary px-4" onclick="CrearProducto()">
                        <i class="bi bi-save me-2"></i>Guardar Producto
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal para actualizar -->
<div class="modal fade" id="modalActualizarProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-theme="light">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title fw-bold" id="exampleModalLabel"><i class="bi bi-pencil-square me-2"></i>Actualizar Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="id_producto_actualizar">
                <div class="mb-3">
                    <label for="nombreProducto_actualizar" class="form-label fw-semibold">Nombre</label>
                    <input type="text" class="form-control" id="nombreProducto_actualizar">
                </div>
                <div class="mb-3">
                    <label for="descripcion_actualizar" class="form-label fw-semibold">Descripción</label>
                    <textarea class="form-control" id="descripcion_actualizar" name="descripcion" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label for="precioUnitario_actualizar" class="form-label fw-semibold">Precio Unitario</label>
                    <input type="number" class="form-control" id="precioUnitario_actualizar" name="precio_unitario">
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning text-white px-4" id="btnGuardarCambios">Guardar Cambios</button>
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
                    data: 'nombre'
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
                        
                        $('#id_producto_actualizar').val(producto.id_producto);
                        $('#nombreProducto_actualizar').val(producto.nombre);
                        $('#precioUnitario_actualizar').val(producto.precio_unitario);
                        $('#descripcion_actualizar').val(producto.descripcion);

                        $('#modalActualizarProducto').modal('show');

                        // Asignar el evento click al botón de guardar, pasando el ID
                        // Se usa .off() para evitar múltiples listeners si el modal se abre varias veces
                        $('#btnGuardarCambios').off('click').on('click', function() {
                            guardarCambios(producto.id_producto);
                        });
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
            console.log(idProducto);

            $('#btnConfirmarEliminar').off('click').on('click', function() {
                $.ajax({
                    url: `<?= base_url('eliminarProducto') ?>/${encodeURIComponent(idProducto)}`,
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
                    error: function(xhr) {
                        let mensaje = 'Error al contactar al servidor.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            mensaje = xhr.responseJSON.message;
                        }
                        toast(mensaje);
                    },
                    complete: function() {
                        modal.hide();
                    }
                });
            });
        });
    });

    function CrearProducto() {
        const url = '<?= base_url('crearProducto'); ?>';
        let idProducto = document.getElementById('idProducto_crear').value;
        let nombreProducto = document.getElementById('nombreProducto_crear').value;
        let descripcion = document.getElementById('descripcion_crear').value;
        let precioUnitario = document.getElementById('precioUnitario_crear').value;

        if (idProducto === '' || nombreProducto === '' || descripcion === '' || precioUnitario === '') {
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
                    nombre: nombreProducto,
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

    function guardarCambios(idProducto) {
        const datosActualizar = {
            nombre: $('#nombreProducto_actualizar').val(),
            descripcion: $('#descripcion_actualizar').val(),
            precio_unitario: $('#precioUnitario_actualizar').val()
        };

        if (!datosActualizar.nombre || !datosActualizar.descripcion || !datosActualizar.precio_unitario) {
            toast('Por favor, complete todos los campos.');
            return;
        }

        $.ajax({
            url: `<?= base_url('actualizarProducto') ?>/${idProducto}`,
            method: 'POST',
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
                console.error('Error en la solicitud AJAX:', status, error);
                console.error('Detalles del error:', xhr.responseText);
                toast('Error al contactar al servidor.');
            }
        });
    }

    function limpiarFormulario() {
        document.getElementById('idProducto_crear').value = '';
        document.getElementById('nombreProducto_crear').value = '';
        document.getElementById('descripcion_crear').value = '';
        document.getElementById('precioUnitario_crear').value = '';
    }
</script>
<?php echo $this->endSection(); ?>