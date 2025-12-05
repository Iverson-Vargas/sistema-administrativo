<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="bi bi-cart-plus-fill me-3"></i>
                Generar Nueva Venta
            </h2>
        </div>
        <div class="card-body">
            <!-- Sección de Búsqueda de Productos -->
            <div class="row mb-3 align-items-end">
                <div class="col-md-8">
                    <label for="cliente_ci" class="form-label">CI/RIF del Cliente</label>
                    <input type="text" id="cliente_ci" class="form-control" placeholder="Ingrese CI/RIF del cliente">
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalProductosDisponibles">
                        <i class="bi bi-box-seam me-2"></i> Ver Productos Disponibles
                    </button>
                </div>
            </div>

            <hr>

            <hr class="my-4">

            <!-- Carrito de Venta -->
            <h4 class="mb-3">Detalle de la Venta</h4>
            <div class="table-responsive">
                <table id="tablaVenta" class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Precio Unit.</th>
                            <th class="text-center" style="width: 120px;">Cantidad</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaVenta">
                        <!-- Los productos añadidos aparecerán aquí -->
                    </tbody>
                </table>
            </div>

            <!-- Totales -->
            <div class="row justify-content-end mt-3">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Total:</strong>
                            <span id="totalVenta" class="badge bg-primary rounded-pill fs-6">$0.00</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Botón para procesar la venta -->
            <div class="text-end mt-4">
                <button class="btn btn-success btn-lg" onclick="revisarYConfirmarVenta()">
                    <i class="bi bi-check-circle-fill"></i> Procesar Venta
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver Productos Disponibles -->
<div class="modal fade" id="modalProductosDisponibles" tabindex="-1" aria-labelledby="modalProductosDisponiblesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProductosDisponiblesLabel">Productos Disponibles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="buscar_producto_modal" class="form-control" placeholder="Escriba para filtrar la lista...">
                </div>
                <div class="table-responsive">
                    <table id="tablaProductosDisponibles" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Precio Unit.</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Datos cargados por DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Venta -->
<div class="modal fade" id="modalConfirmarVenta" tabindex="-1" aria-labelledby="modalConfirmarVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmarVentaLabel">Revisar y Confirmar Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Cliente CI/RIF:</strong> <span id="confirmClienteCi"></span></p>
                <h6>Detalles del Pedido:</h6>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="confirmDetalleVenta">
                        <!-- Resumen de la venta -->
                    </tbody>
                </table>
                <hr>
                <h5 class="text-end">Total a Pagar: <span id="confirmTotalVenta" class="text-success"></span></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="procesarVenta()">Confirmar y Guardar Venta</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script>
    let carrito = []; // Almacena los productos en el carrito
    let idCounter = 0; // Para asignar IDs únicos a las filas del carrito
    let tablaProductosDisponibles;

    $(document).ready(function() {
        // Inicializar DataTable para productos disponibles
        tablaProductosDisponibles = $('#tablaProductosDisponibles').DataTable({
            ajax: {
                url: '<?= base_url('ventas/listarDisponibles'); ?>',
                dataSrc: 'data'
            },
            columns: [
                { data: 'descripcion' },
                { data: 'precio_unitario', className: 'text-end', render: $.fn.dataTable.render.number('.', ',', 2, '$') },
                { data: 'stock_disponible', className: 'text-center' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<button class="btn btn-success btn-sm btn-agregar-carrito" title="Añadir al carrito">
                                    <i class="bi bi-cart-plus"></i>
                                </button>`;
                    }
                }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });

        // Evento para el botón "Añadir al carrito" en la tabla de productos
        $('#tablaProductosDisponibles tbody').on('click', '.btn-agregar-carrito', function() {
            const data = tablaProductosDisponibles.row($(this).parents('tr')).data();
            agregarAlCarrito(data);
        });

        // Evento para buscar productos en el modal
        $('#buscar_producto_modal').on('keyup', function() {
            tablaProductosDisponibles.search($(this).val()).draw();
        });
    });

    function agregarAlCarrito(producto) {
        // Verificar si el producto ya está en el carrito
        const existingProductIndex = carrito.findIndex(item => item.id_producto === producto.id_producto);

        if (existingProductIndex > -1) {
            // Si ya existe, incrementar la cantidad
            const existingItem = carrito[existingProductIndex];
            if (existingItem.cantidad < producto.stock_disponible) {
                existingItem.cantidad++;
                $(`#cantidad_${existingItem.rowId}`).val(existingItem.cantidad);
                actualizarFilaCarrito(existingItem.rowId);
                toast('Cantidad actualizada en el carrito.', 'info');
            } else {
                toast('No hay más stock disponible para este producto.', 'warning');
            }
        } else {
            // Si no existe, añadirlo como nuevo
            if (producto.stock_disponible > 0) {
                idCounter++;
                const newItem = {
                    rowId: idCounter,
                    id_producto: producto.id_producto,
                    descripcion: producto.descripcion,
                    precio_unitario: parseFloat(producto.precio_unitario),
                    stock_disponible: parseInt(producto.stock_disponible),
                    cantidad: 1
                };
                carrito.push(newItem);
                renderizarCarrito();
                toast('Producto añadido al carrito.', 'success');
            } else {
                toast('Este producto no tiene stock disponible.', 'warning');
            }
        }
        calcularTotal();
    }

    function renderizarCarrito() {
        const cuerpoTabla = $('#cuerpoTablaVenta');
        cuerpoTabla.empty();

        carrito.forEach(item => {
            const subtotal = item.cantidad * item.precio_unitario;
            const row = `
                <tr id="fila_${item.rowId}">
                    <td>${item.descripcion} (ID: ${item.id_producto})</td>
                    <td class="text-end">$${item.precio_unitario.toFixed(2)}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm text-center" 
                               id="cantidad_${item.rowId}" value="${item.cantidad}" min="1" max="${item.stock_disponible}"
                               onchange="actualizarFilaCarrito(${item.rowId})">
                    </td>
                    <td class="text-end" id="subtotal_${item.rowId}">$${subtotal.toFixed(2)}</td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm" onclick="eliminarDelCarrito(${item.rowId})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            cuerpoTabla.append(row);
        });
    }

    function actualizarFilaCarrito(rowId) {
        const itemIndex = carrito.findIndex(item => item.rowId === rowId);
        if (itemIndex > -1) {
            const item = carrito[itemIndex];
            const newQuantity = parseInt($(`#cantidad_${rowId}`).val());

            if (newQuantity > item.stock_disponible) {
                toast(`La cantidad máxima disponible para ${item.descripcion} es ${item.stock_disponible}.`, 'warning');
                $(`#cantidad_${rowId}`).val(item.stock_disponible);
                item.cantidad = item.stock_disponible;
            } else if (newQuantity < 1) {
                toast('La cantidad debe ser al menos 1.', 'warning');
                $(`#cantidad_${rowId}`).val(1);
                item.cantidad = 1;
            } else {
                item.cantidad = newQuantity;
            }
            const subtotal = item.cantidad * item.precio_unitario;
            $(`#subtotal_${rowId}`).text(`$${subtotal.toFixed(2)}`);
            calcularTotal();
        }
    }

    function eliminarDelCarrito(rowId) {
        carrito = carrito.filter(item => item.rowId !== rowId);
        renderizarCarrito();
        calcularTotal();
        toast('Producto eliminado del carrito.', 'info');
    }

    function calcularTotal() {
        let total = 0;
        carrito.forEach(item => {
            total += item.cantidad * item.precio_unitario;
        });
        $('#totalVenta').text(`$${total.toFixed(2)}`);
    }

    function revisarYConfirmarVenta() {
        if (carrito.length === 0) {
            toast('El carrito está vacío. Agregue productos para procesar la venta.', 'warning');
            return;
        }

        const clienteCi = $('#cliente_ci').val();
        if (!clienteCi) {
            toast('Por favor, ingrese el CI/RIF del cliente.', 'warning');
            return;
        }

        $('#confirmClienteCi').text(clienteCi);
        const confirmDetalleVenta = $('#confirmDetalleVenta');
        confirmDetalleVenta.empty();
        let totalConfirm = 0;

        carrito.forEach(item => {
            const subtotal = item.cantidad * item.precio_unitario;
            totalConfirm += subtotal;
            confirmDetalleVenta.append(`
                <tr>
                    <td><strong>${item.descripcion}</strong></td>
                    <td class="text-center">${item.cantidad}</td>
                    <td class="text-end">$${subtotal.toFixed(2)}</td>
                </tr>
            `);
        });
        $('#confirmTotalVenta').text(`$${totalConfirm.toFixed(2)}`);
        new bootstrap.Modal(document.getElementById('modalConfirmarVenta')).show();
    }

    function procesarVenta() {
        const clienteCi = $('#cliente_ci').val();
        const productosParaEnviar = carrito.map(item => ({
            id_producto: item.id_producto,
            cantidad: item.cantidad,
            precio_unitario: item.precio_unitario
        }));

        fetch('<?= base_url('ventas/procesar') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                cliente_ci: clienteCi,
                productos: productosParaEnviar
            })
        })
        .then(response => response.json())
        .then(respuesta => {
            if (respuesta.success) {
                toast('Venta procesada exitosamente.', 'success');
                // Limpiar carrito y formulario
                carrito = [];
                renderizarCarrito();
                calcularTotal();
                $('#cliente_ci').val('');
                $('#modalConfirmarVenta').modal('hide');
                // Recargar la tabla de productos disponibles para actualizar el stock
                tablaProductosDisponibles.ajax.reload();
            } else {
                toast(respuesta.message || 'Error al procesar la venta.', 'error');
            }
        })
        .catch(error => {
            console.error('Error al procesar venta:', error);
            toast('Error de comunicación con el servidor al procesar la venta.', 'error');
        });
    }
</script>
<?php echo $this->endSection(); ?>
