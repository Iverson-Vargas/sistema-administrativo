<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<style>
    .kpi-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        color: white;
    }
    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .kpi-icon {
        font-size: 3rem;
        opacity: 0.8;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #198754, #146c43);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107, #d39e00);
    }
    .form-switch .form-check-input {
        width: 3.5em;
        height: 1.75em;
    }
    .lote-card {
        transition: all 0.3s ease;
        border-left: 5px solid #0d6efd;
    }
    .lote-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    .lote-card.stock-bajo {
        border-left-color: #ffc107;
    }
    .lote-card.sin-stock {
        border-left-color: #dc3545;
        opacity: 0.7;
    }
    .lote-card .card-title {
        font-weight: bold;
        color: #343a40;
    }
    .lote-card .card-text {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Dashboard Principal</h2>

    <!-- KPIs (Key Performance Indicators) -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card kpi-card bg-gradient-primary p-3 overflow-hidden">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Total de Lotes</h5>
                        <h2 class="card-text fw-bold" id="kpi-total-lotes">0</h2>
                    </div>
                    <i style="position: absolute; right: 38px; bottom: 50px;" class="bi bi-box-seam kpi-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card kpi-card bg-gradient-success p-3 overflow-hidden">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Unidades Disponibles</h5>
                        <h2 class="card-text fw-bold" id="kpi-unidades-disponibles">0</h2>
                    </div>
                    <i style="position: absolute; right: 38px; bottom: 50px;"class="bi bi-check2-circle kpi-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card kpi-card bg-gradient-warning p-3 overflow-hidden">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Lotes con Bajo Stock</h5>
                        <h2 class="card-text fw-bold" id="kpi-bajo-stock">0</h2>
                    </div>
                    <i style="position: absolute; right: 38px; bottom: 50px;" class="bi bi-exclamation-triangle kpi-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Lotes -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Resumen de Inventario de Lotes</h4>
            <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input me-2" type="checkbox" role="switch" id="filtroDisponibles">
                <label class="form-check-label" for="filtroDisponibles">
                    Mostrar solo con disponibles
                </label>
            </div>
        </div>
        <div class="card-body">
            <div id="lotes-container" class="row p-2 gy-4">
                <!-- Las tarjetas de lotes se insertarán aquí dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del lote (reutilizado de crearLote.php) -->
<div class="modal fade" id="modalDetallesLote" tabindex="-1" aria-labelledby="modalDetallesLoteLabel" aria-hidden="true" data-bs-theme="light">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-light">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetallesLoteLabel"><i class="bi bi-box-seam-fill me-2"></i>Detalles del Lote: <span id="detalleCodigoLote" class="fw-bold"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-muted">Información Principal</h6>
                <hr class="mt-1">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <p class="mb-2"><i class="bi bi-tag-fill me-2 text-primary"></i><strong>Producto:</strong></p>
                        <p id="detalleProducto" class="ms-4"></p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-2"><i class="bi bi-person-workspace me-2 text-primary"></i><strong>Costurero:</strong></p>
                        <p id="detalleCosturero" class="ms-4"></p>
                    </div>
                </div>

                <h6 class="text-muted">Detalles de Inventario</h6>
                <hr class="mt-1">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="p-2 border rounded">
                            <p class="mb-1"><i class="bi bi-calendar-plus-fill me-2 text-primary"></i><strong>Fecha Creación</strong></p>
                            <p id="detalleFechaIngreso" class="mb-0"></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-2 border rounded">
                            <p class="mb-1"><i class="bi bi-arrow-down-square-fill me-2 text-primary"></i><strong>Cantidad Inicial</strong></p>
                            <p id="detalleCantidadInicial" class="mb-0 fs-5 fw-bold"></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-2 border rounded bg-body-secondary">
                            <p class="mb-1"><i class="bi bi-check-square-fill me-2 text-success"></i><strong>Cantidad Disponible</strong></p>
                            <p id="detalleCantidadDisponible" class="mb-0 fs-5 fw-bold"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script>
    let allLotesData = [];

    $(document).ready(function() {
        cargarLotes();

        // Evento para el filtro de disponibilidad
        $('#filtroDisponibles').on('change', function() {
            renderizarTarjetas(allLotesData);
        });
    });

    function cargarLotes() {
        fetch('<?= base_url('listaLotes'); ?>')
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    allLotesData = respuesta.data;
                    actualizarKPIs(allLotesData);
                    renderizarTarjetas(allLotesData);
                } else {
                    toast('Error al cargar los datos de los lotes.', 'error');
                }
            })
            .catch(error => {
                console.error('Error en fetch:', error);
                toast('Error de comunicación con el servidor.', 'error');
            });
    }

    function renderizarTarjetas(data) {
        const container = $('#lotes-container');
        container.empty();

        const mostrarDisponibles = $('#filtroDisponibles').is(':checked');
        const datosFiltrados = mostrarDisponibles ? data.filter(lote => parseInt(lote.cantidad_disponible, 10) > 0) : data;

        if (datosFiltrados.length === 0) {
            container.html('<p class="text-center text-muted">No hay lotes que coincidan con el filtro.</p>');
            return;
        }

        datosFiltrados.forEach(lote => {
            const disponible = parseInt(lote.cantidad_disponible, 10);
            let stockClass = '';
            let badgeClass = 'bg-success';

            if (disponible === 0) {
                stockClass = 'sin-stock';
                badgeClass = 'bg-danger';
            } else if (disponible < 10) {
                stockClass = 'stock-bajo';
                badgeClass = 'bg-warning text-dark';
            }

            const cardHTML = `
                <div class="col-xl-4 col-md-6">
                    <div class="card lote-card h-100 ${stockClass}">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <h5 class="card-title">${lote.codigo_lote}</h5>
                                <p class="card-text text-truncate" title="${lote.producto}">${lote.producto}</p>
                            </div>
                            <p class="card-text mb-2"><i class="bi bi-person-fill me-2"></i>${lote.costurero}</p>
                            <p class="card-text"><i class="bi bi-calendar-event me-2"></i>${lote.fecha_ingreso}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold">Disponible:</span>
                                    <span class="badge ${badgeClass} fs-6">${disponible}</span>
                                </div>
                                <button class="btn btn-sm btn-outline-primary btn-detalles">
                                    <i class="bi bi-eye-fill me-1"></i> Detalles
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            const cardElement = $(cardHTML);
            cardElement.find('.btn-detalles').on('click', function() {
                mostrarDetalles(lote);
            });

            container.append(cardElement);
        });
    }

    function actualizarKPIs(data) {
        const totalLotes = data.length;
        const unidadesDisponibles = data.reduce((sum, item) => sum + parseInt(item.cantidad_disponible, 10), 0);
        const bajoStock = data.filter(item => {
            const disponible = parseInt(item.cantidad_disponible, 10);
            return disponible > 0 && disponible < 10;
        }).length;

        $('#kpi-total-lotes').text(totalLotes);
        $('#kpi-unidades-disponibles').text(unidadesDisponibles);
        $('#kpi-bajo-stock').text(bajoStock);
    }

    function mostrarDetalles(data) {
        $('#detalleCodigoLote').text(data.codigo_lote);
        $('#detalleProducto').html(data.producto);
        $('#detalleCosturero').html(data.costurero);
        $('#detalleFechaIngreso').html(data.fecha_ingreso);
        $('#detalleCantidadInicial').html(data.cantidad_inicial);
        $('#detalleCantidadDisponible').html(data.cantidad_disponible);
        new bootstrap.Modal(document.getElementById('modalDetallesLote')).show();
    }
</script>
<?php echo $this->endSection(); ?>
