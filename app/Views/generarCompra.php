<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="bi bi-cart-check-fill me-3"></i>
                Registrar Nueva Compra
            </h2>
        </div>
        <div class="card-body">
            <!-- PASO 1: DATOS DEL PROVEEDOR Y FACTURA -->
            <fieldset class="border p-3 mb-4 rounded">
                <legend class="float-none w-auto px-2 h6">Paso 1: Datos del Proveedor y Factura</legend>
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <label for="proveedor_rif" class="form-label">RIF del Proveedor</label>
                        <div class="input-group">
                            <input type="text" id="proveedor_rif" class="form-control" placeholder="Ej: J-12345678-9">
                            <button class="btn btn-outline-secondary" type="button" id="btnBuscarProveedor"><i class="bi bi-search"></i> Buscar</button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="proveedor_nombre" class="form-label">Nombre o Razón Social</label>
                        <input type="text" id="proveedor_nombre" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="numero_factura" class="form-label">N° Factura Física</label>
                        <input type="text" id="numero_factura" class="form-control" placeholder="Opcional">
                    </div>
                </div>
            </fieldset>

            <!-- PASO 2: AÑADIR PRODUCTOS -->
            <fieldset class="border p-3 mb-4 rounded">
                <legend class="float-none w-auto px-2 h6">Paso 2: Añadir Productos</legend>
                <div class="text-center">
                    <button type="button" class="btn btn-primary w-50" data-bs-toggle="modal" data-bs-target="#modalInsumos">
                        <i class="bi bi-box-seam me-2"></i> Ver Insumos/Productos para Comprar
                    </button>
                </div>
            </fieldset>

            <!-- PASO 3: DETALLE DE LA COMPRA -->
            <fieldset class="border p-3 rounded">
                <legend class="float-none w-auto px-2 h6">Paso 3: Detalle de la Compra</legend>
                <div class="table-responsive">
                    <table id="tablaCompra" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Producto/Insumo</th>
                                <th class="text-center" style="width: 150px;">Costo Unit.</th>
                                <th class="text-center" style="width: 120px;">Cantidad</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoTablaCompra">
                            <!-- Los productos añadidos aparecerán aquí -->
                        </tbody>
                    </table>
                </div>

                <!-- Totales -->
                <div class="row justify-content-end mt-3">
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Total Compra:</strong>
                                <span id="totalCompra" class="badge bg-success rounded-pill fs-6">$0.00</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Botón para procesar la compra -->
                <div class="text-end mt-4">
                    <button class="btn btn-success btn-lg" onclick="revisarYConfirmarCompra()">
                        <i class="bi bi-check-circle-fill"></i> Procesar Compra
                    </button>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<!-- Modal para ver Insumos/Productos para Comprar -->
<div class="modal fade" id="modalInsumos" tabindex="-1" aria-labelledby="modalInsumosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInsumosLabel">Insumos y Productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="tablaInsumos" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Tono</th>
                            <th>Talla</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nuevo Proveedor -->
<div class="modal fade" id="modalNuevoProveedor" tabindex="-1" aria-labelledby="modalNuevoProveedorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoProveedorLabel">Registrar Nuevo Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>El proveedor con RIF <strong id="nuevoProveedorRif"></strong> no fue encontrado.</p>
                <div class="mb-3">
                    <label for="nuevoProveedorNombre" class="form-label">Por favor, ingrese el Nombre o Razón Social:</label>
                    <input type="text" id="nuevoProveedorNombre" class="form-control" placeholder="Nombre de la empresa o persona">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarNuevoProveedor()">Guardar Proveedor</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Compra -->
<div class="modal fade" id="modalConfirmarCompra" tabindex="-1" aria-labelledby="modalConfirmarCompraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmarCompraLabel">Revisar y Confirmar Compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Proveedor:</strong> <span id="confirmProveedorNombre"></span> (<span id="confirmProveedorRif"></span>)</p>
                <h6>Detalles del Pedido:</h6>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="confirmDetalleCompra">
                        <!-- Resumen de la compra -->
                    </tbody>
                </table>
                <hr>
                <h5 class="text-end">Total Compra: <span id="confirmTotalCompra" class="text-success"></span></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="procesarCompra()">Confirmar y Guardar Compra</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>
<script>
    let carritoCompra = [];
    let idCounterCompra = 0;
    let tablaInsumos;
    let proveedorSeleccionado = { rif: null, nombre: null, esNuevo: false };

    $(document).ready(function() {
        $('#btnBuscarProveedor').on('click', buscarProveedor);

        tablaInsumos = $('#tablaInsumos').DataTable({
            ajax: {
                url: '<?= base_url('compra/listarInsumos'); ?>',
                dataSrc: 'data'
            },
            columns: [
                { data: 'id_producto' },
                { data: 'descripcion' },
                { data: 'tono' },
                { data: 'talla' },
                {
                    data: null, orderable: false, searchable: false, className: 'text-center',
                    render: (data, type, row) => `<button class="btn btn-success btn-sm btn-agregar-compra" title="Añadir a la compra"><i class="bi bi-plus-circle"></i></button>`
                }
            ],
            language: { url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" }
        });

        $('#tablaInsumos tbody').on('click', '.btn-agregar-compra', function() {
            const data = tablaInsumos.row($(this).parents('tr')).data();
            agregarACarritoCompra(data);
        });
    });

    function buscarProveedor() {
        const rif = $('#proveedor_rif').val().trim();
        if (!rif) {
            toast('Por favor, ingrese un RIF para buscar.', 'warning');
            return;
        }

        fetch(`<?= base_url('proveedor/buscar/') ?>${rif}`)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success && respuesta.data) {
                    $('#proveedor_nombre').val(respuesta.data.nombre_proveedor);
                    proveedorSeleccionado = { rif: respuesta.data.ci_rif, nombre: respuesta.data.nombre_proveedor, esNuevo: false };
                    toast('Proveedor encontrado.', 'success');
                } else {
                    // Proveedor no encontrado, abrir modal para crearlo
                    $('#nuevoProveedorRif').text(rif);
                    $('#nuevoProveedorNombre').val('');
                    new bootstrap.Modal(document.getElementById('modalNuevoProveedor')).show();
                }
            })
            .catch(error => toast('Error de comunicación al buscar proveedor.', 'error'));
    }

    function guardarNuevoProveedor() {
        const rif = $('#nuevoProveedorRif').text();
        const nombre = $('#nuevoProveedorNombre').val().trim();

        if (!nombre) {
            toast('Debe ingresar el nombre o razón social.', 'warning');
            return;
        }

        $('#proveedor_nombre').val(nombre);
        proveedorSeleccionado = { rif: rif, nombre: nombre, esNuevo: true };
        
        bootstrap.Modal.getInstance(document.getElementById('modalNuevoProveedor')).hide();
        toast('Proveedor listo para ser registrado con la compra.', 'info');
    }

    function agregarACarritoCompra(producto) {
        const existingProduct = carritoCompra.find(item => item.id_producto === producto.id_producto);
        if (existingProduct) {
            toast('Este producto ya está en la lista de compra. Puede modificar la cantidad.', 'info');
            return;
        }

        idCounterCompra++;
        const newItem = {
            rowId: idCounterCompra,
            id_producto: producto.id_producto,
            descripcion: `${producto.descripcion} (Tono: ${producto.tono}, Talla: ${producto.talla})`,
            costo_unitario: 0,
            cantidad: 1
        };
        carritoCompra.push(newItem);
        renderizarCarritoCompra();
        toast('Producto añadido a la compra.', 'success');
    }

    function renderizarCarritoCompra() {
        const cuerpoTabla = $('#cuerpoTablaCompra');
        cuerpoTabla.empty();
        carritoCompra.forEach(item => {
            const subtotal = item.cantidad * item.costo_unitario;
            const row = `
                <tr id="fila_compra_${item.rowId}">
                    <td>${item.descripcion}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm text-end" 
                               id="costo_${item.rowId}" value="${item.costo_unitario.toFixed(2)}" min="0.01" step="0.01"
                               onchange="actualizarFilaCompra(${item.rowId})">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm text-center" 
                               id="cantidad_compra_${item.rowId}" value="${item.cantidad}" min="1"
                               onchange="actualizarFilaCompra(${item.rowId})">
                    </td>
                    <td class="text-end" id="subtotal_compra_${item.rowId}">$${subtotal.toFixed(2)}</td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm" onclick="eliminarDeCarritoCompra(${item.rowId})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            cuerpoTabla.append(row);
        });
        calcularTotalCompra();
    }

    function actualizarFilaCompra(rowId) {
        const itemIndex = carritoCompra.findIndex(item => item.rowId === rowId);
        if (itemIndex > -1) {
            const item = carritoCompra[itemIndex];
            item.costo_unitario = parseFloat($(`#costo_${rowId}`).val()) || 0;
            item.cantidad = parseInt($(`#cantidad_compra_${rowId}`).val()) || 0;
            
            const subtotal = item.cantidad * item.costo_unitario;
            $(`#subtotal_compra_${item.rowId}`).text(`$${subtotal.toFixed(2)}`);
            calcularTotalCompra();
        }
    }

    function eliminarDeCarritoCompra(rowId) {
        carritoCompra = carritoCompra.filter(item => item.rowId !== rowId);
        renderizarCarritoCompra();
    }

    function calcularTotalCompra() {
        const total = carritoCompra.reduce((sum, item) => sum + (item.cantidad * item.costo_unitario), 0);
        $('#totalCompra').text(`$${total.toFixed(2)}`);
    }

    function revisarYConfirmarCompra() {
        if (carritoCompra.length === 0) {
            toast('Agregue productos para registrar la compra.', 'warning');
            return;
        }
        if (!proveedorSeleccionado.rif || !proveedorSeleccionado.nombre) {
            toast('Por favor, busque y seleccione un proveedor.', 'warning');
            return;
        }

        $('#confirmProveedorRif').text(proveedorSeleccionado.rif);
        $('#confirmProveedorNombre').text(proveedorSeleccionado.nombre);
        const confirmDetalle = $('#confirmDetalleCompra');
        confirmDetalle.empty();
        let totalConfirm = 0;

        carritoCompra.forEach(item => {
            const subtotal = item.cantidad * item.costo_unitario;
            totalConfirm += subtotal;
            confirmDetalle.append(`<tr><td>${item.descripcion}</td><td class="text-center">${item.cantidad}</td><td class="text-end">$${subtotal.toFixed(2)}</td></tr>`);
        });
        $('#confirmTotalCompra').text(`$${totalConfirm.toFixed(2)}`);
        new bootstrap.Modal(document.getElementById('modalConfirmarCompra')).show();
    }

    function procesarCompra() {
        const productosParaEnviar = carritoCompra.map(item => ({
            id_producto: item.id_producto,
            cantidad: item.cantidad,
            costo_unitario: item.costo_unitario
        }));

        const payload = {
            proveedor_rif: proveedorSeleccionado.rif,
            numero_factura: $('#numero_factura').val(),
            productos: productosParaEnviar
        };

        if (proveedorSeleccionado.esNuevo) {
            payload.proveedor_nombre = proveedorSeleccionado.nombre;
        }

        fetch('<?= base_url('compra/procesar') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(respuesta => {
            if (respuesta.success) {
                toast('Compra procesada exitosamente.', 'success');
                carritoCompra = [];
                renderizarCarritoCompra();
                $('#proveedor_rif').val('');
                $('#proveedor_nombre').val('');
                $('#numero_factura').val('');
                proveedorSeleccionado = { rif: null, nombre: null, esNuevo: false };
                $('#modalConfirmarCompra').modal('hide');
            } else {
                toast(respuesta.messages.error || 'Error al procesar la compra.', 'error');
            }
        })
        .catch(error => {
            console.error('Error al procesar compra:', error);
            toast('Error de comunicación con el servidor.', 'error');
        });
    }
</script>
<?php echo $this->endSection(); ?>
