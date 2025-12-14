<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<div class="container-fluid px-4 mt-4">
    <div class="row justify-content-center">
        <div style="margin-bottom: 25px;" class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0 fw-bold">
                            <i style="position: relative; right: 3px; bottom: 4px;" class="bi bi-basket2-fill me-2"></i> Gestión de Compras
                        </h3>
                        <span class="badge bg-light text-primary fs-6">Nueva Transacción</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    
                    <!-- SECCIÓN SUPERIOR: PROVEEDOR Y FACTURA -->
                    <div class="row g-4 mb-4">
                        <!-- Datos del Proveedor -->
                        <div class="col-md-8">
                            <div class="card h-100 border-start border-4 border-primary shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-primary mb-3"><i class="bi bi-person-vcard me-2"></i>Datos del Proveedor</h5>
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-5">
                                            <label for="proveedor_rif" class="form-label fw-semibold">RIF / Cédula</label>
                                            <div class="input-group">
                                                <input type="hidden" id="id_proveedor">
                                                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                                                <input type="text" id="proveedor_rif" class="form-control" placeholder="Ej: J123456789 o 11123456">
                                                <button class="btn btn-primary" type="button" id="btnBuscarProveedor" onclick="buscarProveedor()">Buscar</button>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <label for="proveedor_nombre" class="form-label fw-semibold">Razón Social / Nombre</label>
                                            <input type="text" id="proveedor_nombre" class="form-control bg-light" readonly placeholder="Resultados de la búsqueda...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Datos de Factura -->
                        <div class="col-md-4">
                            <div class="card h-100 border-start border-4 border-secondary shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-secondary mb-3"><i class="bi bi-receipt me-2"></i>Datos de Facturación</h5>
                                    <div class="mb-3">
                                        <label for="numero_factura" class="form-label fw-semibold">N° Factura / Control</label>
                                        <input type="text" id="numero_factura" class="form-control" placeholder="Ingrese número de control">
                                    </div>
                                    <div class="text-end text-muted small">
                                        <i class="bi bi-calendar-event me-1"></i> Fecha: <?php echo date('d/m/Y'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 text-muted">

                    <!-- SECCIÓN CENTRAL: CARRITO DE COMPRAS -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-dark fw-bold"><i style="position: relative; right: 5px; bottom: 2px;" class="bi bi-box-seam me-2"></i>Detalle de Materia Prima / Insumos</h4>
                        <button type="button" class="btn btn-success px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalInsumos">
                            <i class="bi bi-plus-lg me-2"></i> Agregar Insumos
                        </button>
                    </div>

                    <div class="table-responsive shadow-sm rounded-3 mb-4">
                        <table id="tablaCompra" class="table table-hover align-middle mb-0">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th class="py-3 ps-4">Descripción del Insumo</th>
                                    <th class="text-center py-3">Lote</th>
                                    <th class="text-center py-3" style="width: 180px;">Costo Unitario ($)</th>
                                    <th class="text-center py-3" style="width: 150px;">Cantidad</th>
                                    <th class="text-end py-3 pe-4" style="width: 180px;">Subtotal</th>
                                    <th class="text-center py-3" style="width: 100px;">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTablaCompra" class="bg-white">
                                <!-- Filas dinámicas -->
                                <tr id="fila_vacia">
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-basket display-4 d-block mb-3 opacity-50"></i>
                                        No hay insumos agregados a la compra
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-light border-top">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold py-3 fs-5">TOTAL A PAGAR:</td>
                                    <td colspan="2" class="text-end fw-bold py-3 fs-5 pe-4 text-success" id="totalCompra">$0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- BOTÓN DE ACCIÓN -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-secondary me-md-2 px-4" type="button" onclick="location.reload()">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </button>
                        <button class="btn btn-primary btn-lg px-5 shadow" onclick="revisarYConfirmarCompra()">
                            <i class="bi bi-check2-circle me-2"></i> Procesar Compra
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Formulario para Agregar Insumo -->
<div class="modal fade" id="modalInsumos" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-box-seam-fill me-2"></i>Agregar Materia Prima al Carrito</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formInsumo">
                    <div class="row g-3">
                        <!-- Datos de Materia Prima -->
                        <div class="col-12">
                            <h6 class="text-primary fw-bold border-bottom pb-2">Datos del Insumo</h6>
                        </div>
                        <div class="col-md-6">
                            <label for="inputNombre" class="form-label fw-semibold small">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inputNombre" placeholder="Nombre del insumo">
                        </div>
                        <div class="col-md-6">
                            <label for="inputUnidad" class="form-label fw-semibold small">Unidad de Medida <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inputUnidad" placeholder="Ej: kilo, Metro, Unidad">
                        </div>
                        <div class="col-12">
                            <label for="inputDescripcion" class="form-label fw-semibold small">Descripción</label>
                            <input type="text" class="form-control" id="inputDescripcion" placeholder="Descripción detallada">
                        </div>
                        <div class="col-md-4">
                            <label for="inputStockMin" class="form-label fw-semibold small">Stock Mínimo</label>
                            <input type="number" class="form-control" id="inputStockMin" step="0.01" placeholder="0.00">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success px-4" id="btnAgregarInsumo" onclick="agregarInsumoAlCarrito()">
                    <i class="bi bi-plus-circle me-2"></i>Agregar al Carrito
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nuevo Proveedor -->
<div class="modal fade" id="modalNuevoProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Proveedor No Encontrado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-3">El RIF/Cédula <strong id="nuevoProveedorRif" class="text-primary font-monospace fs-5"></strong> no está registrado.</p>
                <p class="text-muted mb-4">Complete los datos para registrar al nuevo proveedor en el sistema:</p>
                
                <form id="formNuevoProveedor">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="new_tipo" class="form-label fw-semibold">Tipo de Persona</label>
                            <select class="form-select" id="new_tipo" onchange="toggleTipoPersona()">
                                <option value="J">Jurídica (Empresa)</option>
                                <option value="N">Natural (Persona)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">RIF / CI</label>
                            <input type="text" class="form-control bg-light" id="new_rif_display" readonly>
                        </div>
                        
                        <!-- Campos Jurídica -->
                        <div class="col-12" id="div_juridica">
                            <label for="new_razon_social" class="form-label fw-semibold">Razón Social</label>
                            <input type="text" class="form-control" id="new_razon_social" placeholder="Nombre de la empresa">
                        </div>

                        <!-- Campos Natural -->
                        <div class="col-md-5 d-none" id="div_natural_nombre">
                            <label for="new_nombre" class="form-label fw-semibold">Nombre</label>
                            <input type="text" class="form-control" id="new_nombre" placeholder="Nombre">
                        </div>
                        <div class="col-md-5 d-none" id="div_natural_apellido">
                            <label for="new_apellido" class="form-label fw-semibold">Apellido</label>
                            <input type="text" class="form-control" id="new_apellido" placeholder="Apellido">
                        </div>
                        <div class="col-md-2 d-none" id="div_natural_sexo">
                            <label for="new_sexo" class="form-label fw-semibold">Sexo</label>
                            <select class="form-select" id="new_sexo">
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </select>
                        </div>

                        <!-- Datos de Contacto (Tabla Persona) -->
                        <div class="col-12">
                            <label for="new_direccion" class="form-label fw-semibold">Dirección Fiscal</label>
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
                <button type="button" class="btn btn-primary px-4" onclick="guardarNuevoProveedor()">Registrar y Continuar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Compra -->
<div class="modal fade" id="modalConfirmarCompra" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Confirmar Compra</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h6 class="text-muted text-uppercase small ls-1">Total a Pagar</h6>
                    <h2 class="text-success fw-bold display-6" id="confirmTotalCompra"></h2>
                </div>
                
                <div class="card bg-light border-0 mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold text-muted">Proveedor:</span>
                            <span class="text-end" id="confirmProveedorNombre"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-muted">RIF/CI:</span>
                            <span class="text-end font-monospace" id="confirmProveedorRif"></span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mb-3">Resumen de Items:</h6>
                <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                    <table class="table table-sm table-borderless">
                        <tbody id="confirmDetalleCompra"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Volver</button>
                <button type="button" class="btn btn-success px-4" onclick="procesarCompra()">Confirmar Transacción</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Alerta Empleado -->
<div class="modal fade" id="modalAlertaEmpleado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold">
                <i class="bi bi-exclamation-circle-fill me-2"></i>Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3"><i style="position: relative; right: 30px; bottom: 10px;" class="bi bi-person-badge text-warning display-1"></i></div>
                <p class="fs-5">La persona consultada figura como un <strong>Empleado Activo</strong> de la empresa.</p>
                <p class="text-muted">¿Desea continuar registrando la compra a nombre de este empleado?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning px-4" onclick="usarProveedorPendiente()">Sí, Continuar</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>
<script>
    function agregarInsumoAlCarrito() {
        // 1. Obtener valores del formulario
        const nombreInput = document.getElementById('inputNombre');
        const unidadInput = document.getElementById('inputUnidad');
        const descripcionInput = document.getElementById('inputDescripcion');
        const stockMinInput = document.getElementById('inputStockMin');

        const nombre = nombreInput.value.trim();
        const unidad = unidadInput.value.trim();
        const descripcion = descripcionInput.value.trim();
        const stockMin = stockMinInput.value.trim();

        // 2. Validaciones
        if (nombre === '') {
            alert('Por favor, ingrese el nombre del insumo.');
            nombreInput.focus();
            return;
        }
        if (unidad === '') {
            alert('Por favor, ingrese la unidad de medida.');
            unidadInput.focus();
            return;
        }
        if (stockMin !== '' && (isNaN(stockMin) || parseFloat(stockMin) < 0)) {
            alert('El stock mínimo debe ser un número válido positivo.');
            stockMinInput.focus();
            return;
        }

        // 3. Ocultar mensaje de "No hay insumos"
        const filaVacia = document.getElementById('fila_vacia');
        if (filaVacia) {
            filaVacia.style.display = 'none';
        }

        // 4. Crear fila dinámica
        const idFila = 'row_' + Date.now();
        const htmlFila = `
            <tr id="${idFila}">
                <td class="ps-4">
                    <div class="fw-bold text-primary">${nombre}</div>
                    <div class="small text-muted">${descripcion}</div>
                    <span class="badge bg-light text-secondary border mt-1">${unidad}</span>
                    <!-- Inputs ocultos para guardar datos de materia prima -->
                    <input type="hidden" name="insumos[${idFila}][nombre]" value="${nombre}">
                    <input type="hidden" name="insumos[${idFila}][unidad]" value="${unidad}">
                    <input type="hidden" name="insumos[${idFila}][descripcion]" value="${descripcion}">
                    <input type="hidden" name="insumos[${idFila}][stock_min]" value="${stockMin}">
                </td>
                <td class="text-center align-middle">
                    <input type="text" class="form-control form-control-sm" name="insumos[${idFila}][lote]" placeholder="Lote" required>
                </td>
                <td class="text-center align-middle">
                    <input type="number" class="form-control form-control-sm input-costo" name="insumos[${idFila}][costo]" placeholder="0.00" min="0" step="0.01" oninput="calcularSubtotal('${idFila}')" required>
                </td>
                <td class="text-center align-middle">
                    <input type="number" class="form-control form-control-sm input-cantidad" name="insumos[${idFila}][cantidad]" value="1" min="1" step="1" oninput="calcularSubtotal('${idFila}')" required>
                </td>
                <td class="text-end pe-4 align-middle fw-bold text-dark subtotal-fila" id="subtotal_${idFila}">$0.00</td>
                <td class="text-center align-middle">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarFila('${idFila}')" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        document.getElementById('cuerpoTablaCompra').insertAdjacentHTML('beforeend', htmlFila);

        // 5. Limpiar y cerrar modal
        document.getElementById('formInsumo').reset();
        const modalEl = document.getElementById('modalInsumos');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    function calcularSubtotal(idFila) {
        const fila = document.getElementById(idFila);
        const costo = parseFloat(fila.querySelector('.input-costo').value) || 0;
        const cantidad = parseFloat(fila.querySelector('.input-cantidad').value) || 0;
        const subtotal = costo * cantidad;
        document.getElementById('subtotal_' + idFila).textContent = '$' + subtotal.toFixed(2);
        calcularTotalGlobal();
    }

    function calcularTotalGlobal() {
        let total = 0;
        document.querySelectorAll('.subtotal-fila').forEach(td => {
            total += parseFloat(td.textContent.replace('$', '')) || 0;
        });
        document.getElementById('totalCompra').textContent = '$' + total.toFixed(2);
    }

    function eliminarFila(idFila) {
        const fila = document.getElementById(idFila);
        if (fila) fila.remove();
        
        const filasVisibles = document.querySelectorAll('#cuerpoTablaCompra tr:not(#fila_vacia)');
        if (filasVisibles.length === 0) {
            const filaVacia = document.getElementById('fila_vacia');
            if (filaVacia) filaVacia.style.display = 'table-row';
        }
        calcularTotalGlobal();
    }

    // --- Lógica de Proveedores ---

    let proveedorPendiente = null;

    function usarProveedorPendiente() {
        if (proveedorPendiente) {
            const data = proveedorPendiente;
            if (data.id_proveedor) {
                document.getElementById('id_proveedor').value = data.id_proveedor;
            }
            const nombreInput = document.getElementById('proveedor_nombre');
            
            let nombreMostrar = '';
            if (data.razon_social) {
                nombreMostrar = data.razon_social;
            } else if (data.nombre && data.apellido) {
                nombreMostrar = `${data.nombre} ${data.apellido}`;
            } else {
                nombreMostrar = 'Proveedor encontrado';
            }

            nombreInput.value = nombreMostrar;
            nombreInput.classList.add('is-valid');
            nombreInput.classList.remove('is-invalid');
            
            const modalEl = document.getElementById('modalAlertaEmpleado');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        }
    }

    async function buscarProveedor() {
        const rifInput = document.getElementById('proveedor_rif');
        const nombreInput = document.getElementById('proveedor_nombre');
        // Limpiar guiones y puntos, y convertir a mayúsculas
        const rif = rifInput.value.trim().toUpperCase().replace(/[-.]/g, '');
        rifInput.value = rif; // Actualizar campo visualmente

        if (rif === '') {
            alert('Por favor, ingrese el RIF o Cédula del proveedor.');
            rifInput.focus();
            return;
        }

        // Validación de formato RIF/Cédula (Sin guiones ni puntos)
        // RIF: Letra + 9 dígitos (Ej: V123456789) | CI: Solo números (Ej: 11123456)
        const regex = /^([VEJPG]\d{9}|\d{6,9})$/;
        if (!regex.test(rif)) {
            alert('Formato inválido. Ingrese solo números para Cédula (Ej: 11123456) o Letra y 9 números para RIF (Ej: V123456789), sin guiones ni puntos.');
            rifInput.classList.add('is-invalid');
            rifInput.focus();
            return;
        }
        rifInput.classList.remove('is-invalid');

        // Feedback visual de carga
        const btn = document.getElementById('btnBuscarProveedor');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

        try {
            // Petición al backend
            const response = await fetch('<?= base_url("buscarProvedor") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ ci_rif: rif })
            });
            
            const result = await response.json();

            if (result.success) {
                const data = result.data;
                
                // Validación de Empleado Activo
                if (data.estatus_empleado === 'A') {
                    proveedorPendiente = data;
                    const modal = new bootstrap.Modal(document.getElementById('modalAlertaEmpleado'));
                    modal.show();
                    return; // Detenemos aquí esperando confirmación
                }

                // Si no es empleado, llenamos directamente (reutilizamos la lógica)
                proveedorPendiente = data;
                usarProveedorPendiente();
                
            } else {
                // Si no existe, preparar y mostrar modal
                nombreInput.value = '';
                document.getElementById('id_proveedor').value = '';
                nombreInput.classList.remove('is-valid');
                
                // Pre-llenar RIF en el modal
                document.getElementById('nuevoProveedorRif').textContent = rif;
                document.getElementById('new_rif_display').value = rif;
                
                // Resetear formulario y mostrar modal
                document.getElementById('formNuevoProveedor').reset();
                document.getElementById('new_rif_display').value = rif; // Restaurar RIF tras reset
                toggleTipoPersona(); // Asegurar estado inicial de campos
                
                const modal = new bootstrap.Modal(document.getElementById('modalNuevoProveedor'));
                modal.show();
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al buscar el proveedor. Verifique la conexión.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }

    function toggleTipoPersona() {
        const tipo = document.getElementById('new_tipo').value;
        const divJuridica = document.getElementById('div_juridica');
        const divNaturalNombre = document.getElementById('div_natural_nombre');
        const divNaturalApellido = document.getElementById('div_natural_apellido');
        const divNaturalSexo = document.getElementById('div_natural_sexo');

        if (tipo === 'J') {
            divJuridica.classList.remove('d-none');
            divNaturalNombre.classList.add('d-none');
            divNaturalApellido.classList.add('d-none');
            divNaturalSexo.classList.add('d-none');
        } else {
            divJuridica.classList.add('d-none');
            divNaturalNombre.classList.remove('d-none');
            divNaturalApellido.classList.remove('d-none');
            divNaturalSexo.classList.remove('d-none');
        }
    }

    function guardarNuevoProveedor() {
        const url = '<?= base_url('crearProvedor') ?>';
        
        const tipo = document.getElementById('new_tipo').value;
        const ci_rif = document.getElementById('new_rif_display').value;
        const direccion = document.getElementById('new_direccion').value;
        const telefono = document.getElementById('new_telefono').value;
        const correo = document.getElementById('new_correo').value;
        
        let nombre = null;
        let apellido = null;
        let sexo = null;
        let razon_social = null;

        // Validaciones
        if (!ci_rif) {
            alert('El RIF/CI es obligatorio.');
            return;
        }
        if (!direccion || !telefono || !correo) {
            alert('Por favor complete dirección, teléfono y correo.');
            return;
        }

        if (tipo === 'J') {
            razon_social = document.getElementById('new_razon_social').value;
            if (!razon_social) {
                alert('Por favor ingrese la Razón Social.');
                return;
            }
        } else {
            nombre = document.getElementById('new_nombre').value;
            apellido = document.getElementById('new_apellido').value;
            sexo = document.getElementById('new_sexo').value;
            
            if (!nombre || !apellido || !sexo) {
                alert('Por favor complete nombre, apellido y sexo.');
                return;
            }
        }

        const data = {
            tipo_persona: tipo,
            ci_rif: ci_rif,
            nombre: nombre,
            apellido: apellido,
            sexo: sexo,
            direccion: direccion,
            telefono: telefono,
            correo: correo,
            razon_social: razon_social
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
                // Actualizar la interfaz de compra con el nuevo proveedor
                document.getElementById('proveedor_rif').value = ci_rif;
                const nombreMostrar = (tipo === 'J') ? razon_social : `${nombre} ${apellido}`;
                document.getElementById('proveedor_nombre').value = nombreMostrar;
                document.getElementById('proveedor_nombre').classList.add('is-valid');
                if (respuesta.id_proveedor) {
                    document.getElementById('id_proveedor').value = respuesta.id_proveedor;
                }

                // Cerrar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoProveedor'));
                modal.hide();
                
                alert('Proveedor registrado exitosamente.');
            } else {
                alert(respuesta.message || 'Error al registrar el proveedor.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de comunicación con el servidor.');
        });
    }

    function revisarYConfirmarCompra() {
        const id_proveedor = document.getElementById('id_proveedor').value;
        const rif = document.getElementById('proveedor_rif').value;
        const nombre = document.getElementById('proveedor_nombre').value;
        const factura = document.getElementById('numero_factura').value;
        const id_empleado = '<?= session()->get('id_usuario'); ?>';
        
        // Validaciones básicas
        if (!id_proveedor || !nombre) {
            alert('Por favor, seleccione un proveedor válido.');
            return;
        }
        if (!id_empleado) {
            alert('Error: No se ha identificado al usuario en sesión. Por favor, inicie sesión nuevamente.');
            return;
        }
        if (!factura) {
            alert('Por favor, ingrese el número de factura o control.');
            return;
        }

        const filas = document.querySelectorAll('#cuerpoTablaCompra tr:not(#fila_vacia)');
        if (filas.length === 0) {
            alert('El carrito de compra está vacío. Agregue al menos un insumo.');
            return;
        }

        // Calcular totales y preparar resumen para el modal
        let totalCompra = 0;
        let htmlResumen = '';

        filas.forEach(fila => {
            const nombreInsumo = fila.querySelector('div.fw-bold').textContent;
            const cantidad = parseFloat(fila.querySelector('.input-cantidad').value) || 0;
            const costo = parseFloat(fila.querySelector('.input-costo').value) || 0;
            const subtotal = cantidad * costo;
            
            totalCompra += subtotal;

            htmlResumen += `
                <tr>
                    <td>${nombreInsumo}</td>
                    <td class="text-center">${cantidad}</td>
                    <td class="text-end">$${subtotal.toFixed(2)}</td>
                </tr>
            `;
        });

        // Llenar modal de confirmación
        document.getElementById('confirmProveedorNombre').textContent = nombre;
        document.getElementById('confirmProveedorRif').textContent = rif;
        document.getElementById('confirmTotalCompra').textContent = '$' + totalCompra.toFixed(2);
        document.getElementById('confirmDetalleCompra').innerHTML = htmlResumen;

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('modalConfirmarCompra'));
        modal.show();
    }

    function procesarCompra() {
        const url = '<?= base_url('procesarCompra'); ?>';
        const id_proveedor = document.getElementById('id_proveedor').value;
        const factura = document.getElementById('numero_factura').value;
        const id_empleado = '<?= session()->get('id_usuario'); ?>';
        
        const insumos = [];
        let total_compra = 0;
        const filas = document.querySelectorAll('#cuerpoTablaCompra tr:not(#fila_vacia)');

        filas.forEach(fila => {
            const costo = parseFloat(fila.querySelector('.input-costo').value) || 0;
            const cantidad = parseFloat(fila.querySelector('.input-cantidad').value) || 0;
            total_compra += costo * cantidad;

            insumos.push({
                nombre: fila.querySelector('input[name*="[nombre]"]').value,
                unidad_medida: fila.querySelector('input[name*="[unidad]"]').value,
                descripcion: fila.querySelector('input[name*="[descripcion]"]').value,
                stock_minimo: fila.querySelector('input[name*="[stock_min]"]').value,
                codigo_lote: fila.querySelector('input[name*="[lote]"]').value,
                costo_unitario: costo,
                cantidad: cantidad
            });
        });

        const data = {
            id_proveedor: id_proveedor,
            id_empleado: id_empleado,
            numero_factura_fisica: factura,
            total_compra: total_compra,
            insumos: insumos
        };

        // Deshabilitar botón para evitar doble envío
        const btnConfirmar = document.querySelector('#modalConfirmarCompra .btn-success');
        const textoOriginal = btnConfirmar.innerHTML;
        btnConfirmar.disabled = true;
        btnConfirmar.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';

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
                    alert('Compra procesada exitosamente.');
                    location.reload();
                } else {
                    alert(respuesta.message || 'Error al procesar la compra.');
                    btnConfirmar.disabled = false;
                    btnConfirmar.innerHTML = textoOriginal;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error de comunicación con el servidor.');
                btnConfirmar.disabled = false;
                btnConfirmar.innerHTML = textoOriginal;
            });
    }
</script>
<?php echo $this->endSection(); ?>
