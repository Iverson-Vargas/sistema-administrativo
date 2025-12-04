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
            <!-- Sección de Búsqueda y Proveedor -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="buscar_producto_compra" class="form-label">Buscar Insumo o Producto</label>
                    <div class="input-group">
                        <input type="text" id="buscar_producto_compra" class="form-control" placeholder="Escriba el nombre o código...">
                        <button class="btn btn-info" type="button" onclick="buscarProductoParaCompra()"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="proveedor_rif" class="form-label">RIF del Proveedor</label>
                    <input type="text" id="proveedor_rif" class="form-control" placeholder="Ingrese el RIF del proveedor">
                </div>
            </div>

            <!-- Resultados de la búsqueda -->
            <div id="resultados_busqueda_compra" class="list-group mb-4" style="max-height: 200px; overflow-y: auto;">
                <!-- Los resultados de la búsqueda aparecerán aquí -->
            </div>

            <hr>

            <!-- Detalle de la Compra -->
            <h4 class="mb-3">Detalle de la Compra</h4>
            <div class="table-responsive">
                <table id="tablaCompra" class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Producto/Insumo</th>
                            <th class="text-center">Costo Unit.</th>
                            <th class="text-center" style="width: 120px;">Cantidad</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaCompra">
                        <!-- Los productos añadidos para la compra aparecerán aquí -->
                    </tbody>
                </table>
            </div>

            <!-- Totales -->
            <div class="row justify-content-end mt-3">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Total:</strong>
                            <span id="totalCompra" class="badge bg-success rounded-pill fs-6">$0.00</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Botón para procesar la compra -->
            <div class="text-end mt-4">
                <button class="btn btn-primary btn-lg" onclick="revisarYConfirmarCompra()">
                    <i class="bi bi-check-circle-fill"></i> Procesar Compra
                </button>
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
                <p><strong>Proveedor RIF:</strong> <span id="confirmProveedorRif"></span></p>
                <h6>Detalles de la Compra:</h6>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Producto/Insumo</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="confirmDetalleCompra">
                        <!-- Resumen de la compra -->
                    </tbody>
                </table>
                <hr>
                <h5 class="text-end">Total a Pagar: <span id="confirmTotalCompra" class="text-primary"></span></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="procesarCompra()">Confirmar y Guardar Compra</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>
<script>
    // Aquí puedes agregar el JavaScript para manejar la lógica de la compra,
    // como buscar productos, añadirlos a la tabla, calcular totales y procesar la compra.
    // Puedes tomar como referencia el script de la vista `generarVenta.php`.
</script>
<?php echo $this->endSection(); ?>