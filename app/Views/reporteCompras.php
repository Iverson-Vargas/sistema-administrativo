<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<!-- Estilos para el calendario (Flatpickr) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="bi bi-collection-fill me-3"></i>
                Reporte de Compras
            </h2>
        </div>
        <div class="card-body">
            <!-- Sección de Filtros (funcionalidad a futuro) -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Filtros de Búsqueda</h5>
                    <p class="text-muted">Filtros estarán disponibles en una futura actualización.</p>
                </div>
            </div>

            <!-- Tabla de Compras -->
            <div class="table-responsive">
                <table id="tablaCompras" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th class="text-center">ID Compra</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">N° Factura</th>
                            <th>Proveedor</th>
                            <th>RIF Proveedor</th>
                            <th>Registrado por</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Detalles de la Compra -->
<div class="modal fade" id="modalDetalleCompra" tabindex="-1" aria-labelledby="modalDetalleCompraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetalleCompraLabel">Detalles de la Compra #<span id="idCompraDetalle"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Productos en la Compra:</h6>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>ID Producto</th>
                            <th>Descripción</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Costo Unit.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaDetalleCompra"></tbody>
                </table>
                <h5 class="text-end mt-3">Total Compra: <span id="totalCompraDetalle" class="text-success"></span></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
    let tablaCompras;

    $(document).ready(function() {
        tablaCompras = $('#tablaCompras').DataTable({
            ajax: {
                url: '<?= base_url('reportes/listadoCompras') ?>',
                dataSrc: 'data',
                error: function(xhr, error, thrown) {
                    console.error("DataTables AJAX error:", xhr, error, thrown);
                    // Attempt to parse JSON from responseText if available
                    let errorMessage = 'Error al cargar los datos de compras.';
                    try {
                        const responseJson = JSON.parse(xhr.responseText);
                        if (responseJson && responseJson.message) {
                            errorMessage = responseJson.message;
                        } else if (xhr.status === 0) {
                            errorMessage = 'No se pudo conectar con el servidor. Verifique su conexión a internet o la disponibilidad del servidor.';
                        } else if (xhr.status === 404) {
                            errorMessage = 'El recurso solicitado no fue encontrado (404).';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Error interno del servidor (500). Por favor, revise los logs del servidor.';
                        } else {
                            errorMessage = `Error de red o servidor: ${xhr.status} ${xhr.statusText}`;
                        }
                    } catch (e) { /* If responseText is not JSON, use generic message */ }
                    toast(errorMessage, 'error');
                }
            },
            columns: [
                { data: 'id_compra', className: 'text-center' },
                { data: 'fecha', className: 'text-center' },
                { data: 'numero_factura_fisica', className: 'text-center' },
                { data: 'nombre_proveedor' },
                { data: 'rif_proveedor' },
                { data: 'nombre_empleado' },
                { data: 'total_compra', className: 'text-end', render: $.fn.dataTable.render.number('.', ',', 2, '$') },
                {
                    data: null, orderable: false, searchable: false, className: 'text-center',
                    render: (data, type, row) => `<button class="btn btn-info btn-sm" onclick="mostrarDetalles(${row.id_compra})"><i class="bi bi-eye"></i> Ver</button>`
                }
            ],
            language: { url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" }
        });
    });

    function mostrarDetalles(idCompra) {
        fetch(`<?= base_url('reportes/detalleCompra/') ?>${idCompra}`)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    const detalles = respuesta.data;
                    const cuerpoTabla = $('#cuerpoTablaDetalleCompra');
                    cuerpoTabla.empty();
                    let totalCompra = 0;

                    detalles.forEach(item => {
                        const subtotal = parseFloat(item.cantidad) * parseFloat(item.costo_unitario);
                        totalCompra += subtotal;
                        cuerpoTabla.append(`<tr><td>${item.id_producto}</td><td>${item.producto_descripcion}</td><td class="text-center">${item.cantidad}</td><td class="text-end">$${parseFloat(item.costo_unitario).toFixed(2)}</td><td class="text-end">$${subtotal.toFixed(2)}</td></tr>`);
                    });

                    $('#idCompraDetalle').text(idCompra);
                    $('#totalCompraDetalle').text(`$${totalCompra.toFixed(2)}`);
                    new bootstrap.Modal(document.getElementById('modalDetalleCompra')).show();
                } else {
                    toast('Error al cargar los detalles de la compra.', 'error');
                }
            })
            .catch(error => toast('Error de comunicación con el servidor.', 'error'));
    }
</script>
<?php echo $this->endSection(); ?>
