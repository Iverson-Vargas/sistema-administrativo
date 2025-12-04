<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<!-- Estilos para el calendario (Flatpickr) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .btn-detalles-custom {
        background: linear-gradient(145deg, #1e90ff, #00bfff);
        border: none;
        border-radius: 50px;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    .btn-detalles-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestión de Lotes de Producción</h3>
                </div>
                <div class="card-body">
                    <h4 class="card-subtitle mb-3 text-muted">Crear Nuevo Lote</h4>
                    <form id="formCrearLote">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="codigo_lote" class="form-label">Código del Lote</label>
                                <input type="text" class="form-control" id="codigo_lote" placeholder="Ej: LOTE-001" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="producto_select" class="form-label">Producto</label>
                                <select id="producto_select" class="form-select" required></select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="id_empleado" class="form-label">Costurero</label>
                                <select id="id_empleado" class="form-select" required></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="fecha_ingreso" class="form-label">Fecha de Creación</label>
                                <input type="text" id="fecha_ingreso" class="form-control" placeholder="Seleccione la fecha" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cantidad" class="form-label">Cantidad a Crear</label>
                                <input type="number" class="form-control" id="cantidad" placeholder="Ingrese la cantidad de unidades" required min="1">
                            </div>
                            <div class="col-md-4 d-flex align-items-end mb-3">
                                <button type="button" class="btn btn-primary w-100" onclick="CrearLote()">
                                    <i class="bi bi-plus-circle"></i> Crear Lote
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="row mt-3">
        <div class="col-12">
            <h3 class="text-center">Lotes Registrados</h3>
            <div class="tabla-scroll-vertical mt-3">
                <table id="tablaLotes" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Código Lote</th>
                            <th class="text-center">ID Producto</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Costurero</th>
                            <th class="text-center">Fecha Creación</th>
                            <th class="text-center">Cant. Inicial</th>
                            <th class="text-center">Cant. Disponible</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se llenarán con JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del lote -->
<div class="modal fade" id="modalDetallesLote" tabindex="-1" aria-labelledby="modalDetallesLoteLabel" aria-hidden="true" data-bs-theme="light">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetallesLoteLabel">Detalles del Lote: <span id="detalleCodigoLote"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="detalleIdProducto" class="form-label">ID Producto</label>
                                <input type="text" id="detalleIdProducto" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="detalleProducto" class="form-label">Producto</label>
                                <textarea id="detalleProducto" class="form-control" rows="2" readonly></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="detalleCosturero" class="form-label">Costurero</label>
                                <input type="text" id="detalleCosturero" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="detalleFechaIngreso" class="form-label">Fecha de Creación</label>
                                <input type="text" id="detalleFechaIngreso" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="detalleCantidadInicial" class="form-label">Cantidad Inicial</label>
                                <input type="text" id="detalleCantidadInicial" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="detalleCantidadDisponible" class="form-label">Cantidad Disponible</label>
                                <input type="text" id="detalleCantidadDisponible" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>

<!-- Librería JavaScript para el calendario (Flatpickr) -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
    let tabla;

    $(document).ready(function() {
        // Inicializar Flatpickr
        flatpickr("#fecha_ingreso", {
            "locale": "es",
            dateFormat: "Y-m-d",
        });

        // Cargar datos para los selects
        listarProductos();
        listarCostureros('#id_empleado');

        // Inicializar DataTable
        tabla = $('#tablaLotes').DataTable({
            ajax: '<?= base_url('listaLotes'); ?>', // Asegúrate de crear esta ruta y su controlador
            columnDefs: [{
                targets: 0,
                width: "10px",
                className: "text-center",
                orderable: false,
                searchable: false
            }, {
                targets: [1, 2, 3, 4, 5, 6, 7],
                className: "text-center"
            }],
            columns: [ 
            {
                data: 'codigo_lote'
            },{
                data: 'id_producto'
            }, {
                data: 'producto'
            }, // Asume que el JSON de respuesta tendrá estos campos
            {
                data: 'costurero'
            }, {
                data: 'fecha_ingreso'
            }, {
                data: 'cantidad_inicial'
            }, {
                data: 'cantidad_disponible'
            }, {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    // Botón para mostrar detalles en una modal
                    return `<button class="btn btn-sm btn-detalles-custom btn-detalles" title="Ver Detalles">
                               <i class="bi bi-eye-fill"></i>
                            </button>`;
                }
            }],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });

        // Evento para el botón de detalles
        $('#tablaLotes tbody').on('click', '.btn-detalles', function() {
            let data = tabla.row($(this).parents('tr')).data();
            mostrarDetalles(data);
        });
    });

    function mostrarDetalles(data) {
        $('#detalleCodigoLote').text(data.codigo_lote);
        $('#detalleIdProducto').val(data.id_producto);
        $('#detalleProducto').val(data.producto);
        $('#detalleCosturero').val(data.costurero);
        $('#detalleFechaIngreso').val(data.fecha_ingreso);
        $('#detalleCantidadInicial').val(data.cantidad_inicial);
        $('#detalleCantidadDisponible').val(data.cantidad_disponible);
        new bootstrap.Modal(document.getElementById('modalDetallesLote')).show();
    }

    function CrearLote() {
        // URL para la creación del lote. Asegúrate de que esta ruta exista en tu archivo de rutas.
        const url = '<?= base_url('crearLote'); ?>';

        // Obtener los valores del formulario
        const codigoLote = document.getElementById('codigo_lote').value;
        const idProducto = document.getElementById('producto_select').value;
        const idEmpleado = document.getElementById('id_empleado').value;
        const fechaIngreso = document.getElementById('fecha_ingreso').value;
        const cantidad = document.getElementById('cantidad').value;

        // Validación de los campos
        if (!codigoLote || !idProducto || !idEmpleado || !fechaIngreso || !cantidad) {
            // Puedes usar tu función toast para mostrar errores también
            toast('Por favor, complete todos los campos para crear el lote.', 'error');
            return;
        }

        const data = {
            codigo_lote: codigoLote,
            id_producto: idProducto,
            id_empleado: parseInt(idEmpleado, 10),
            fecha_ingreso: fechaIngreso,
            cantidad: parseInt(cantidad, 10)
        };

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    //Si la tabla está inicializada, recargarla
                    if (typeof tabla !== 'undefined') {
                        tabla.ajax.reload();
                    }
                    document.getElementById('formCrearLote').reset(); // Limpiar el formulario
                    flatpickr("#fecha_ingreso", { "locale": "es", dateFormat: "Y-m-d" }).clear(); // Limpiar el campo de fecha
                    toast('Lote creado correctamente.');
                } else {
                    toast(respuesta.message || 'Error al crear el lote.', 'error');
                }
            })
            .catch(error => {
                console.error('Error en fetch para CrearLote:', error);
                toast('Ocurrió un error de conexión.', 'error');
            });
    }

    function listarProductos() {

                const url = '<?= base_url('listaProductoLote') ?>';
                fetch(url)
                    .then(response => response.json())
                    .then(respuesta => {
                        if (respuesta.success) {
                            let select = document.getElementById('producto_select');
                            select.innerHTML = '<option value="" selected disabled>Seleccione...</option>';
                            respuesta.data.forEach(producto => {
                                let option = document.createElement('option');
                                option.value = producto.id_producto;
                                option.textContent = producto.producto_descripcion;
                                select.appendChild(option);
                            });
                        } else {
                            // Es mejor mostrar el error que viene del servidor si existe.
                            let mensajeError = respuesta.message || 'Ocurrió un error inesperado al cargar los productos.';
                            alert(mensajeError);
                            console.error('Error del servidor:', respuesta);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

    function listarCostureros(selector, selectedId = null) {
        const url = '<?= base_url('listaCostureros') ?>';
        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    let select = document.querySelector(selector);
                    select.innerHTML = '<option value="" selected disabled>Seleccione...</option>';
                    respuesta.data.forEach(costurero => {
                        let option = document.createElement('option');
                        option.value = costurero.id_empleado;
                        option.textContent = `${costurero.nombre} ${costurero.apellido}`;
                        select.appendChild(option);
                    });
                    if (selectedId) {
                        select.value = selectedId;
                    }
                } else {
                    toast('Error al cargar los costureros.');
                }
            })
            .catch(error => {
                console.error('Error en fetch para listarCostureros:', error);
            });
    }
</script>

<?php echo $this->endSection(); ?>