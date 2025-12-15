<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<div class="container-fluid px-4 mt-4">
    <div class="row justify-content-center">
        <div style="margin-bottom: 25px;" class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-success text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0 fw-bold">
                            <i style="position: relative; right: 3px; bottom: 4px;" class="bi bi-cart-check-fill me-2"></i> Gestión de Ventas
                        </h3>
                        <span class="badge bg-light text-success fs-6">Nueva Venta</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    
                    <!-- SECCIÓN SUPERIOR: CLIENTE Y DATOS DE VENTA -->
                    <div class="row g-4 mb-4">
                        <!-- Datos del Cliente -->
                        <div class="col-md-8">
                            <div class="card h-100 border-start border-4 border-success shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-success mb-3"><i class="bi bi-person-circle me-2"></i>Datos del Cliente</h5>
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-5">
                                            <label for="cliente_rif" class="form-label fw-semibold">RIF / Cédula</label>
                                            <div class="input-group">
                                                <input type="hidden" id="id_cliente">
                                                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                                                <input type="text" id="cliente_rif" class="form-control" placeholder="Ej: V12345678">
                                                <button class="btn btn-success" type="button" id="btnBuscarCliente" onclick="buscarCliente()">Buscar</button>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <label for="cliente_nombre" class="form-label fw-semibold">Nombre / Razón Social</label>
                                            <input type="text" id="cliente_nombre" class="form-control bg-light" readonly placeholder="Resultados de la búsqueda...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Datos de Venta -->
                        <div class="col-md-4">
                            <div class="card h-100 border-start border-4 border-secondary shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-secondary mb-3"><i class="bi bi-receipt me-2"></i>Información de Venta</h5>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Vendedor</label>
                                        <input type="text" class="form-control bg-light" value="<?= session()->get('persona') ?? 'Usuario' ?>" readonly>
                                    </div>
                                    <div class="text-end text-muted small mt-4">
                                        <i class="bi bi-calendar-event me-1"></i> Fecha: <?php echo date('d/m/Y'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 text-muted">

                    <!-- SECCIÓN CENTRAL: CARRITO DE VENTAS -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-dark fw-bold"><i style="position: relative; right: 5px; bottom: 2px;" class="bi bi-bag-check-fill me-2"></i>Detalle de Productos</h4>
                        <button type="button" class="btn btn-primary px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalProductos" onclick="cargarProductosDisponibles()">
                            <i class="bi bi-plus-lg me-2"></i> Agregar Producto
                        </button>
                    </div>

                    <div class="table-responsive shadow-sm rounded-3 mb-4">
                        <table id="tablaVenta" class="table table-hover align-middle mb-0">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th class="py-3 ps-4">Descripción del Producto</th>
                                    <th class="text-center py-3">Lote Origen</th>
                                    <th class="text-center py-3" style="width: 180px;">Precio Unit. ($)</th>
                                    <th class="text-center py-3" style="width: 150px;">Cantidad</th>
                                    <th class="text-end py-3 pe-4" style="width: 180px;">Subtotal</th>
                                    <th class="text-center py-3" style="width: 100px;">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTablaVenta" class="bg-white">
                                <!-- Filas dinámicas -->
                                <tr id="fila_vacia">
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-cart-x display-4 d-block mb-3 opacity-50"></i>
                                        No hay productos agregados a la venta
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-light border-top">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold py-3 fs-5">TOTAL A PAGAR:</td>
                                    <td colspan="2" class="text-end fw-bold py-3 fs-5 pe-4 text-success" id="totalVenta">$0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- BOTÓN DE ACCIÓN -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-secondary me-md-2 px-4" type="button" onclick="location.reload()">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </button>
                        <button class="btn btn-success btn-lg px-5 shadow" onclick="revisarYConfirmarVenta()">
                            <i class="bi bi-currency-dollar me-2"></i> Procesar Venta
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Selección de Productos (Inventario) -->
<div class="modal fade" id="modalProductos" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-box-seam-fill me-2"></i>Seleccionar Producto del Inventario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formProductoVenta">
                    <div class="mb-3">
                        <label for="selectProductoVenta" class="form-label fw-semibold">Producto Disponible (Lote - Talla - Color)</label>
                        <select class="form-select" id="selectProductoVenta" onchange="actualizarDatosProducto()">
                            <option value="">Cargando inventario...</option>
                        </select>
                        <div class="form-text text-muted">Seleccione el lote específico del cual desea descontar el inventario.</div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Stock Disponible</label>
                            <input type="text" class="form-control bg-light" id="stockDisplay" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Precio Unitario ($)</label>
                            <input type="number" class="form-control" id="precioVentaInput" step="0.01" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Cantidad a Vender</label>
                            <input type="number" class="form-control" id="cantidadVentaInput" min="1" value="1">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary px-4" onclick="agregarProductoAlCarrito()">
                    <i class="bi bi-cart-plus me-2"></i>Agregar al Carrito
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Cliente -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-2"></i>Cliente No Encontrado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-3">El documento <strong id="nuevoClienteRif" class="text-primary font-monospace fs-5"></strong> no está registrado.</p>
                <p class="text-muted mb-4">Registre los datos del nuevo cliente:</p>
                
                <form id="formNuevoCliente">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="new_tipo" class="form-label fw-semibold">Tipo de Persona</label>
                            <select class="form-select" id="new_tipo" onchange="toggleTipoPersona()">
                                <option value="N">Natural (Persona)</option>
                                <option value="J">Jurídica (Empresa)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">RIF / CI</label>
                            <input type="text" class="form-control bg-light" id="new_rif_display" readonly>
                        </div>
                        
                        <!-- Campos Natural -->
                        <div class="col-md-5" id="div_natural_nombre">
                            <label for="new_nombre" class="form-label fw-semibold">Nombre</label>
                            <input type="text" class="form-control" id="new_nombre" placeholder="Nombre">
                        </div>
                        <div class="col-md-5" id="div_natural_apellido">
                            <label for="new_apellido" class="form-label fw-semibold">Apellido</label>
                            <input type="text" class="form-control" id="new_apellido" placeholder="Apellido">
                        </div>
                        <div class="col-md-2" id="div_natural_sexo">
                            <label for="new_sexo" class="form-label fw-semibold">Sexo</label>
                            <select class="form-select" id="new_sexo">
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </select>
                        </div>

                        <!-- Campos Jurídica -->
                        <div class="col-12 d-none" id="div_juridica">
                            <label for="new_razon_social" class="form-label fw-semibold">Razón Social</label>
                            <input type="text" class="form-control" id="new_razon_social" placeholder="Nombre de la empresa">
                        </div>

                        <!-- Datos de Contacto -->
                        <div class="col-12">
                            <label for="new_direccion" class="form-label fw-semibold">Dirección</label>
                            <input type="text" class="form-control" id="new_direccion" placeholder="Dirección completa">
                        </div>
                        <div class="col-md-6">
                            <label for="new_telefono" class="form-label fw-semibold">Teléfono</label>
                            <input type="text" class="form-control" id="new_telefono" placeholder="Ej: 0414-1234567">
                        </div>
                        <div class="col-md-6">
                            <label for="new_correo" class="form-label fw-semibold">Correo Electrónico</label>
                            <input type="email" class="form-control" id="new_correo" placeholder="correo@ejemplo.com">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-link text-decoration-none text-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary px-4" onclick="guardarNuevoCliente()">Registrar Cliente</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirmación -->
<div class="modal fade" id="modalConfirmarVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Confirmar Venta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h6 class="text-muted text-uppercase small ls-1">Total a Cobrar</h6>
                    <h2 class="text-success fw-bold display-6" id="confirmTotalVenta"></h2>
                </div>
                
                <div class="card bg-light border-0 mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold text-muted">Cliente:</span>
                            <span class="text-end" id="confirmClienteNombre"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-muted">RIF/CI:</span>
                            <span class="text-end font-monospace" id="confirmClienteRif"></span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mb-3">Resumen de Productos:</h6>
                <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                    <table class="table table-sm table-borderless">
                        <tbody id="confirmDetalleVenta"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Volver</button>
                <button type="button" class="btn btn-success px-4" onclick="procesarVenta()">Confirmar Venta</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script>
    // --- Lógica de Clientes ---
    async function buscarCliente() {
        const rifInput = document.getElementById('cliente_rif');
        const nombreInput = document.getElementById('cliente_nombre');
        const rif = rifInput.value.trim().toUpperCase().replace(/[-.]/g, '');
        rifInput.value = rif;

        if (rif === '') {
            alert('Ingrese el RIF o Cédula del cliente.');
            rifInput.focus();
            return;
        }

        const btn = document.getElementById('btnBuscarCliente');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        try {
            const response = await fetch('<?= base_url("crearVenta/buscarCliente") ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ ci_rif: rif })
            });
            const result = await response.json();

            if (result.success) {
                const data = result.data;
                document.getElementById('id_cliente').value = data.id_cliente;
                let nombreMostrar = data.razon_social || `${data.nombre} ${data.apellido}`;
                nombreInput.value = nombreMostrar;
                nombreInput.classList.add('is-valid');
            } else {
                // Cliente no encontrado
                nombreInput.value = '';
                document.getElementById('id_cliente').value = '';
                nombreInput.classList.remove('is-valid');
                
                document.getElementById('nuevoClienteRif').textContent = rif;
                document.getElementById('new_rif_display').value = rif;
                document.getElementById('formNuevoCliente').reset();
                document.getElementById('new_rif_display').value = rif;
                toggleTipoPersona();
                
                new bootstrap.Modal(document.getElementById('modalNuevoCliente')).show();
            }
        } catch (error) {
            console.error(error);
            alert('Error al buscar cliente.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }

    function toggleTipoPersona() {
        const tipo = document.getElementById('new_tipo').value;
        if (tipo === 'J') {
            document.getElementById('div_juridica').classList.remove('d-none');
            document.getElementById('div_natural_nombre').classList.add('d-none');
            document.getElementById('div_natural_apellido').classList.add('d-none');
            document.getElementById('div_natural_sexo').classList.add('d-none');
        } else {
            document.getElementById('div_juridica').classList.add('d-none');
            document.getElementById('div_natural_nombre').classList.remove('d-none');
            document.getElementById('div_natural_apellido').classList.remove('d-none');
            document.getElementById('div_natural_sexo').classList.remove('d-none');
        }
    }

    function guardarNuevoCliente() {
        const url = '<?= base_url('crearVenta/crearCliente') ?>';
        // Recolectar datos del formulario modalNuevoCliente
        const tipo = document.getElementById('new_tipo').value;
        const ci_rif = document.getElementById('new_rif_display').value;
        const data = {
            tipo_persona: tipo,
            ci_rif: ci_rif,
            direccion: document.getElementById('new_direccion').value,
            telefono: document.getElementById('new_telefono').value,
            correo: document.getElementById('new_correo').value,
            nombre: document.getElementById('new_nombre').value,
            apellido: document.getElementById('new_apellido').value,
            sexo: document.getElementById('new_sexo').value,
            razon_social: document.getElementById('new_razon_social').value
        };

        fetch(url, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                document.getElementById('cliente_rif').value = ci_rif;
                document.getElementById('cliente_nombre').value = (tipo === 'J') ? data.razon_social : `${data.nombre} ${data.apellido}`;
                document.getElementById('id_cliente').value = res.id_cliente; // Asumiendo que el backend devuelve el ID
                bootstrap.Modal.getInstance(document.getElementById('modalNuevoCliente')).hide();
                alert('Cliente registrado exitosamente.');
            } else {
                alert(res.message || 'Error al registrar cliente.');
            }
        })
        .catch(err => console.error(err));
    }

    // --- Lógica de Productos y Carrito ---
    function cargarProductosDisponibles() {
        const select = document.getElementById('selectProductoVenta');
        select.disabled = true;
        select.innerHTML = '<option value="">Cargando...</option>';
        
        fetch('<?= base_url("crearVenta/listarProductos") ?>')
            .then(r => r.json())
            .then(res => {
                select.disabled = false;
                select.innerHTML = '<option value="">Seleccione un producto...</option>';
                if(res.success && res.data) {
                    res.data.forEach(p => {
                        // p debe contener: codigo_lote, producto (nombre), talla, tono, precio, stock
                        const label = `${p.producto} - Talla: ${p.talla} - Color: ${p.tono} - Lote: ${p.codigo_lote}`;
                        const option = document.createElement('option');
                        option.value = p.codigo_lote; 
                        option.text = label;
                        // Guardar datos en dataset para acceso rápido
                        option.dataset.id_producto = p.id_producto;
                        option.dataset.id_talla = p.id_talla;
                        option.dataset.id_tono = p.id_tono;
                        option.dataset.nombre = p.producto;
                        option.dataset.talla = p.talla;
                        option.dataset.tono = p.tono;
                        option.dataset.precio = p.precio;
                        option.dataset.stock = p.stock;
                        option.dataset.lote = p.codigo_lote;
                        select.appendChild(option);
                    });
                } else {
                    alert('Error al cargar productos: ' + (res.message || 'Intente nuevamente'));
                }
            })
            .catch(err => {
                console.error(err);
                select.disabled = false;
                select.innerHTML = '<option value="">Error de conexión</option>';
            });
    }

    function actualizarDatosProducto() {
        const select = document.getElementById('selectProductoVenta');
        const option = select.options[select.selectedIndex];
        
        if (option.value) {
            document.getElementById('stockDisplay').value = option.dataset.stock;
            document.getElementById('precioVentaInput').value = option.dataset.precio;
            document.getElementById('cantidadVentaInput').max = option.dataset.stock;
            document.getElementById('cantidadVentaInput').value = 1;
        } else {
            document.getElementById('stockDisplay').value = '';
            document.getElementById('precioVentaInput').value = '';
        }
    }

    function agregarProductoAlCarrito() {
        const select = document.getElementById('selectProductoVenta');
        const option = select.options[select.selectedIndex];
        
        if (!option.value) {
            alert('Seleccione un producto.');
            return;
        }

        const cantidad = parseFloat(document.getElementById('cantidadVentaInput').value);
        const precio = parseFloat(document.getElementById('precioVentaInput').value);
        const stock = parseFloat(option.dataset.stock);

        if (isNaN(cantidad) || cantidad <= 0) {
            alert('Cantidad inválida.');
            return;
        }
        if (cantidad > stock) {
            alert(`La cantidad supera el stock disponible (${stock}).`);
            return;
        }

        // Ocultar fila vacía
        const filaVacia = document.getElementById('fila_vacia');
        if (filaVacia) filaVacia.style.display = 'none';

        const idFila = 'row_' + Date.now();
        const subtotal = cantidad * precio;
        const descripcion = `${option.dataset.nombre} <br><small class="text-muted">Talla: ${option.dataset.talla} | Color: ${option.dataset.tono}</small>`;

        const html = `
            <tr id="${idFila}">
                <td class="ps-4">
                    <div class="fw-bold">${option.dataset.nombre}</div>
                    <div class="small text-muted">Talla: ${option.dataset.talla} | Color: ${option.dataset.tono}</div>
                    <input type="hidden" name="productos[${idFila}][codigo_lote]" value="${option.dataset.lote}">
                    <input type="hidden" name="productos[${idFila}][id_producto]" value="${option.dataset.id_producto}">
                    <input type="hidden" name="productos[${idFila}][id_talla]" value="${option.dataset.id_talla}">
                    <input type="hidden" name="productos[${idFila}][id_tono]" value="${option.dataset.id_tono}">
                </td>
                <td class="text-center"><span class="badge bg-light text-dark border">${option.dataset.lote}</span></td>
                <td class="text-center">$${precio.toFixed(2)}
                    <input type="hidden" class="input-precio" value="${precio}">
                </td>
                <td class="text-center">${cantidad}
                    <input type="hidden" class="input-cantidad" value="${cantidad}">
                </td>
                <td class="text-end pe-4 fw-bold subtotal-fila">$${subtotal.toFixed(2)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarFila('${idFila}')"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
        `;

        document.getElementById('cuerpoTablaVenta').insertAdjacentHTML('beforeend', html);
        calcularTotalGlobal();
        
        // Reset y cerrar modal
        document.getElementById('formProductoVenta').reset();
        bootstrap.Modal.getInstance(document.getElementById('modalProductos')).hide();
    }

    function eliminarFila(id) {
        document.getElementById(id).remove();
        const filas = document.querySelectorAll('#cuerpoTablaVenta tr:not(#fila_vacia)');
        if (filas.length === 0) document.getElementById('fila_vacia').style.display = 'table-row';
        calcularTotalGlobal();
    }

    function calcularTotalGlobal() {
        let total = 0;
        document.querySelectorAll('.subtotal-fila').forEach(el => {
            total += parseFloat(el.textContent.replace('$', ''));
        });
        document.getElementById('totalVenta').textContent = '$' + total.toFixed(2);
    }

    function revisarYConfirmarVenta() {
        const idCliente = document.getElementById('id_cliente').value;
        if (!idCliente) {
            alert('Seleccione un cliente.');
            return;
        }
        const filas = document.querySelectorAll('#cuerpoTablaVenta tr:not(#fila_vacia)');
        if (filas.length === 0) {
            alert('Agregue productos a la venta.');
            return;
        }

        // Llenar modal confirmación
        document.getElementById('confirmClienteNombre').textContent = document.getElementById('cliente_nombre').value;
        document.getElementById('confirmClienteRif').textContent = document.getElementById('cliente_rif').value;
        document.getElementById('confirmTotalVenta').textContent = document.getElementById('totalVenta').textContent;

        let htmlResumen = '';
        filas.forEach(fila => {
            const desc = fila.querySelector('div.fw-bold').textContent;
            const cant = fila.querySelector('.input-cantidad').value;
            const sub = fila.querySelector('.subtotal-fila').textContent;
            htmlResumen += `<tr><td>${desc}</td><td class="text-center">${cant}</td><td class="text-end">${sub}</td></tr>`;
        });
        document.getElementById('confirmDetalleVenta').innerHTML = htmlResumen;

        new bootstrap.Modal(document.getElementById('modalConfirmarVenta')).show();
    }

    function procesarVenta() {
        const data = {
            id_cliente: document.getElementById('id_cliente').value,
            total_venta: parseFloat(document.getElementById('totalVenta').textContent.replace('$', '')),
            productos: []
        };

        document.querySelectorAll('#cuerpoTablaVenta tr:not(#fila_vacia)').forEach(fila => {
            data.productos.push({
                codigo_lote: fila.querySelector('input[name*="[codigo_lote]"]').value,
                id_producto: fila.querySelector('input[name*="[id_producto]"]').value,
                id_talla: fila.querySelector('input[name*="[id_talla]"]').value,
                id_tono: fila.querySelector('input[name*="[id_tono]"]').value,
                cantidad: parseFloat(fila.querySelector('.input-cantidad').value),
                precio_unitario: parseFloat(fila.querySelector('.input-precio').value)
            });
        });

        const btn = document.querySelector('#modalConfirmarVenta .btn-success');
        btn.disabled = true;
        btn.innerHTML = 'Procesando...';

        fetch('<?= base_url("crearVenta/procesar") ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                alert('Venta procesada exitosamente.');
                location.reload();
            } else {
                alert(res.message || 'Error al procesar venta.');
                btn.disabled = false;
                btn.innerHTML = 'Confirmar Venta';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error de conexión.');
            btn.disabled = false;
            btn.innerHTML = 'Confirmar Venta';
        });
    }
</script>
<?php echo $this->endSection(); ?>
