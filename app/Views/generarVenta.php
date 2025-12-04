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
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="buscar_producto" class="form-label">Buscar Producto</label>
                    <div class="input-group">
                        <input type="text" id="buscar_producto" class="form-control" placeholder="Escriba el nombre o código del producto...">
                        <button class="btn btn-info" type="button" onclick="buscarProducto()"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="cliente_ci" class="form-label">CI/RIF del Cliente</label>
                    <input type="text" id="cliente_ci" class="form-control" placeholder="Ingrese CI/RIF del cliente">
                </div>
            </div>

            <!-- Resultados de la búsqueda -->
            <div id="resultados_busqueda" class="list-group mb-4" style="max-height: 200px; overflow-y: auto;">
                <!-- Los resultados de la búsqueda de productos aparecerán aquí -->
            </div>

            <hr>

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
    
</script>
<?php echo $this->endSection(); ?>