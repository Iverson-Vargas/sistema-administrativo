<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<!-- Estilos para el calendario (Flatpickr) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Estilos personalizados para mejorar la apariencia */
    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        overflow: hidden; /* Para que el header respete el borde redondeado */
    }
    .card-header-gradient {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        padding: 1.5rem;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.6rem 1rem;
        border: 1px solid #ced4da;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    .btn-detalles-custom {
        background: linear-gradient(145deg, #0dcaf0, #0aa2c0);
        border: none;
        border-radius: 50px;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    .btn-detalles-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        color: white;
    }
    .bg-light-custom {
        background-color: #f8f9fa;
        border-radius: 10px;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header card-header-gradient">
                    <h3 class="card-title mb-0"><i class="bi bi-box-seam-fill me-2"></i>Gestión de Lotes de Producción</h3>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-subtitle mb-4 text-muted border-bottom pb-2">Crear Nuevo Lote</h5>
                    <form id="formCrearLote">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="codigo_lote" class="form-label">Código del Lote</label>
                                <input type="text" class="form-control" id="codigo_lote" placeholder="Ej: LOTE-001" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="producto_select" class="form-label">Producto</label>
                                <select id="producto_select" class="form-select" required></select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="id_empleado" class="form-label">Costurero</label>
                                <select id="id_empleado" class="form-select" required></select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="fecha_ingreso" class="form-label">Fecha de Creación</label>
                                <input type="text" id="fecha_ingreso" class="form-control" placeholder="Seleccione la fecha" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="id_tono" class="form-label">Tono / Color</label>
                                <select id="id_tono" class="form-select" required>
                                    <option value="" selected disabled>Seleccione...</option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">Distribución por Tallas</h5>
                        
                        <div class="row align-items-end mb-3 p-3 bg-light-custom border">
                            <div class="col-md-4">
                                <label for="select_talla" class="form-label">Talla</label>
                                <select id="select_talla" class="form-select">
                                    <option value="" selected disabled>Seleccione...</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="cantidad_talla" class="form-label">Cantidad</label>
                                <input type="number" id="cantidad_talla" class="form-control" placeholder="0" min="1">
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100 fw-bold" onclick="agregarTalla()">
                                    <i class="bi bi-plus-lg"></i> Agregar Talla
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive mb-3">
                            <table class="table table-hover table-bordered text-center align-middle">
                                <thead class="table-light fw-bold">
                                    <tr>
                                        <th>Talla</th>
                                        <th>Cantidad</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyTallas">
                                    <tr id="filaSinTallas"><td colspan="3" class="text-muted">No se han agregado tallas</td></tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-end">Total Unidades:</th>
                                        <th id="totalUnidades">0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-primary px-5 py-2 shadow-sm" onclick="CrearLote()">
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

    <div style="margin-bottom: 25px;" class="row mt-3">
        <div class="col-12">
            <h3 class="text-center mb-4 fw-bold text-secondary">Lotes Registrados</h3>
            <div class="tabla-scroll-vertical mt-3 card-custom p-3 bg-white">
                <table id="tablaLotes" class="table table-striped table-hover align-middle w-100">
                    <thead class="table-dark">
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
    let tallasSeleccionadas = [];

    $(document).ready(function() {
        // Inicializar Flatpickr
        flatpickr("#fecha_ingreso", {
            "locale": "es",
            dateFormat: "Y-m-d",
        });

        // Cargar datos para los selects
        listarProductos();
        listarCostureros('#id_empleado');
        listarTonos();
        listarTallas();

        // Inicializar DataTable
        tabla = $('#tablaLotes').DataTable({
              ajax: {
                url: '<?= base_url('listaLotes'); ?>',
                dataSrc: 'data' // Especifica que los datos están en la propiedad 'data' del JSON
            },
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
        const idTono = document.getElementById('id_tono').value;
        const totalCantidad = document.getElementById('totalUnidades').innerText;

        // Validación de los campos
        if (!codigoLote || !idProducto || !idEmpleado || !fechaIngreso || !idTono) {
            // Puedes usar tu función toast para mostrar errores también
            toast('Por favor, complete todos los campos para crear el lote.', 'error');
            return;
        }

        if (tallasSeleccionadas.length === 0) {
            toast('Debe agregar al menos una talla con su cantidad.', 'error');
            return;
        }

        const data = {
            codigo_lote: codigoLote,
            id_producto: idProducto,
            id_empleado: parseInt(idEmpleado, 10),
            fecha_ingreso: fechaIngreso,
            id_tono: idTono,
            cantidad_total: parseInt(totalCantidad, 10),
            detalles: tallasSeleccionadas // Enviamos el array de tallas
        };
        console.log('Datos a enviar para CrearLote:', data);
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
                    // Reiniciar tabla de tallas
                    tallasSeleccionadas = [];
                    renderizarTablaTallas();
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

    function listarTonos() {
        fetch('<?= base_url('listaTono') ?>')
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    let select = document.getElementById('id_tono');
                    select.innerHTML = '<option value="" selected disabled>Seleccione...</option>';
                    respuesta.data.forEach(tono => {
                        let option = document.createElement('option');
                        option.value = tono.id_tono;
                        option.textContent = tono.descripcion; // Asumiendo que el campo es descripcion o nombre
                        select.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error listando tonos:', error));
    }

    function listarTallas() {
        fetch('<?= base_url('listaTalla') ?>')
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    let select = document.getElementById('select_talla');
                    select.innerHTML = '<option value="" selected disabled>Seleccione...</option>';
                    respuesta.data.forEach(talla => {
                        let option = document.createElement('option');
                        option.value = talla.id_talla;
                        option.textContent = talla.descripcion;
                        select.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error listando tallas:', error));
    }

    function agregarTalla() {
        const selectTalla = document.getElementById('select_talla');
        const inputCantidad = document.getElementById('cantidad_talla');
        
        const idTalla = selectTalla.value;
        const nombreTalla = selectTalla.options[selectTalla.selectedIndex].text;
        const cantidad = parseInt(inputCantidad.value);

        if (!idTalla || isNaN(cantidad) || cantidad <= 0) {
            toast('Seleccione una talla y una cantidad válida.', 'warning');
            return;
        }

        // Verificar si ya existe
        const existe = tallasSeleccionadas.find(t => t.id_talla === idTalla);
        if (existe) {
            existe.cantidad += cantidad; // Sumar cantidad si ya existe
        } else {
            tallasSeleccionadas.push({ id_talla: idTalla, nombre: nombreTalla, cantidad: cantidad });
        }

        renderizarTablaTallas();
        selectTalla.value = "";
        inputCantidad.value = "";
    }

    function eliminarTalla(index) {
        tallasSeleccionadas.splice(index, 1);
        renderizarTablaTallas();
    }

    function renderizarTablaTallas() {
        const tbody = document.getElementById('tbodyTallas');
        const totalSpan = document.getElementById('totalUnidades');
        tbody.innerHTML = '';
        let total = 0;

        if (tallasSeleccionadas.length === 0) {
            tbody.innerHTML = '<tr id="filaSinTallas"><td colspan="3" class="text-muted">No se han agregado tallas</td></tr>';
            totalSpan.innerText = '0';
            return;
        }

        tallasSeleccionadas.forEach((item, index) => {
            total += item.cantidad;
            const row = `
                <tr>
                    <td>${item.nombre}</td>
                    <td>${item.cantidad}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarTalla(${index})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
        totalSpan.innerText = total;
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
                                option.textContent = producto.nombre;
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