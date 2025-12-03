<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<!-- Estilos para el calendario (Flatpickr) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid mt-3">
    <h2 class="text-center">Módulo de Reportes</h2>
    <hr>

    <ul class="nav nav-tabs" id="reportesTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="operacionales-tab" data-bs-toggle="tab" data-bs-target="#operacionales" type="button" role="tab" aria-controls="operacionales" aria-selected="true">Reportes Operacionales</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="supervision-tab" data-bs-toggle="tab" data-bs-target="#supervision" type="button" role="tab" aria-controls="supervision" aria-selected="false">Reportes de Supervisión</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="gerenciales-tab" data-bs-toggle="tab" data-bs-target="#gerenciales" type="button" role="tab" aria-controls="gerenciales" aria-selected="false">Reportes Gerenciales</button>
        </li>
    </ul>

    <div class="tab-content p-3 border border-top-0" id="reportesTabContent">
        <!-- Pestaña de Reportes Operacionales -->
        <div class="tab-pane fade show active" id="operacionales" role="tabpanel" aria-labelledby="operacionales-tab">
            <div class="accordion" id="accordionOperacionales">
                <!-- Reporte 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOp1" aria-expanded="false" aria-controls="collapseOp1">
                            #1 - Listado de Producción por Fechas
                        </button>
                    </h2>
                    <div id="collapseOp1" class="accordion-collapse collapse" data-bs-parent="#accordionOperacionales">
                        <div class="accordion-body">
                            <p>Contenido del reporte 1...</p>
                        </div>
                    </div>
                </div>
                <!-- Reporte 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOp2" aria-expanded="false" aria-controls="collapseOp2">
                            #2 - Inventario Actual de Productos
                        </button>
                    </h2>
                    <div id="collapseOp2" class="accordion-collapse collapse" data-bs-parent="#accordionOperacionales">
                        <div class="accordion-body">
                            <p>Contenido del reporte 2...</p>
                        </div>
                    </div>
                </div>
                <!-- Reporte 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOp3" aria-expanded="false" aria-controls="collapseOp3">
                            #3 - Detalle de Ventas Recientes
                        </button>
                    </h2>
                    <div id="collapseOp3" class="accordion-collapse collapse" data-bs-parent="#accordionOperacionales">
                        <div class="accordion-body">
                            <p>Contenido del reporte 3...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pestaña de Reportes de Supervisión -->
        <div class="tab-pane fade" id="supervision" role="tabpanel" aria-labelledby="supervision-tab">
            <div class="accordion" id="accordionSupervision">
                <!-- Reporte 4: Producción por Costurero (EJEMPLO IMPLEMENTADO) -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSup1" aria-expanded="true" aria-controls="collapseSup1">
                            #4 - Producción por Costurero
                        </button>
                    </h2>
                    <div id="collapseSup1" class="accordion-collapse collapse show" data-bs-parent="#accordionSupervision">
                        <div class="accordion-body">
                            <div class="row mb-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="fechasCosturero" class="form-label">Rango de Fechas</label>
                                    <input type="text" id="fechasCosturero" class="form-control" placeholder="Seleccione un rango">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" id="btnFiltrarCosturero">Filtrar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <canvas id="chartProduccionCosturero"></canvas>
                                </div>
                                <div class="col-lg-4">
                                    <h5>Datos Detallados</h5>
                                    <table id="tablaProduccionCosturero" class="table table-sm table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Costurero</th>
                                                <th>Total Producido</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Reporte 5 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSup2" aria-expanded="false" aria-controls="collapseSup2">
                            #5 - Productos Más Vendidos
                        </button>
                    </h2>
                    <div id="collapseSup2" class="accordion-collapse collapse" data-bs-parent="#accordionSupervision">
                        <div class="accordion-body">
                            <div class="row mb-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="fechasMasVendidos" class="form-label">Rango de Fechas</label>
                                    <input type="text" id="fechasMasVendidos" class="form-control" placeholder="Seleccione un rango (opcional)">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" id="btnFiltrarMasVendidos">Filtrar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <canvas id="chartProductosMasVendidos"></canvas>
                                </div>
                                <div class="col-lg-5">
                                    <h5>Top 10 Productos</h5>
                                    <table id="tablaProductosMasVendidos" class="table table-sm table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Total Vendido</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Reporte 6 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSup3" aria-expanded="false" aria-controls="collapseSup3">
                            #6 - Rendimiento de Vendedores
                        </button>
                    </h2>
                    <div id="collapseSup3" class="accordion-collapse collapse" data-bs-parent="#accordionSupervision">
                        <div class="accordion-body">
                            <p>Contenido del reporte 6...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pestaña de Reportes Gerenciales -->
        <div class="tab-pane fade" id="gerenciales" role="tabpanel" aria-labelledby="gerenciales-tab">
            <div class="accordion" id="accordionGerenciales">
                <!-- Reporte 7 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGer1" aria-expanded="false" aria-controls="collapseGer1">
                            #7 - Comparativa de Ventas Mensuales
                        </button>
                    </h2>
                    <div id="collapseGer1" class="accordion-collapse collapse" data-bs-parent="#accordionGerenciales">
                        <div class="accordion-body">
                            <p>Contenido del reporte 7...</p>
                        </div>
                    </div>
                </div>
                <!-- Reporte 8 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGer2" aria-expanded="false" aria-controls="collapseGer2">
                            #8 - Análisis de Rentabilidad por Producto
                        </button>
                    </h2>
                    <div id="collapseGer2" class="accordion-collapse collapse" data-bs-parent="#accordionGerenciales">
                        <div class="accordion-body">
                            <p>Contenido del reporte 8...</p>
                        </div>
                    </div>
                </div>
                <!-- Reporte 9 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGer3" aria-expanded="false" aria-controls="collapseGer3">
                            #9 - Eficiencia de la Producción General
                        </button>
                    </h2>
                    <div id="collapseGer3" class="accordion-collapse collapse" data-bs-parent="#accordionGerenciales">
                        <div class="accordion-body">
                            <p>Contenido del reporte 9...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>

<!-- Librerías para calendario y gráficos -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
    let chartProduccionCosturero;
    let tablaProduccionCosturero;
    let chartProductosMasVendidos;
    let tablaProductosMasVendidos;

    document.addEventListener('DOMContentLoaded', function() {
        // --- INICIALIZACIÓN REPORTE #4: Producción por Costurero ---
        const fp = flatpickr("#fechasCosturero", {
            mode: "range",
            "locale": "es",
            dateFormat: "Y-m-d",
        });

        // Inicializar DataTable
        tablaProduccionCosturero = $('#tablaProduccionCosturero').DataTable({
            columns: [{
                data: 'costurero'
            }, {
                data: 'total_producido'
            }, ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            searching: false,
            lengthChange: false,
            pageLength: 5
        });

        // Cargar datos al hacer clic en el botón de filtrar
        document.getElementById('btnFiltrarCosturero').addEventListener('click', function() {
            cargarDatosProduccionCosturero(fp.selectedDates);
        });

        // Cargar datos iniciales (sin filtro de fecha)
        cargarDatosProduccionCosturero();

        // --- INICIALIZACIÓN REPORTE #5: Productos Más Vendidos ---
        const collapseMasVendidos = document.getElementById('collapseSup2');
        collapseMasVendidos.addEventListener('shown.bs.collapse', function() {
            const fpMasVendidos = flatpickr("#fechasMasVendidos", {
                mode: "range",
                "locale": "es",
                dateFormat: "Y-m-d",
            });

            tablaProductosMasVendidos = $('#tablaProductosMasVendidos').DataTable({
                columns: [{ data: 'producto' }, { data: 'total_vendido' }],
                language: { url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
                searching: false,
                lengthChange: false,
                pageLength: 10,
                ordering: false
            });

            document.getElementById('btnFiltrarMasVendidos').addEventListener('click', function() {
                cargarDatosMasVendidos(fpMasVendidos.selectedDates);
            });

            // Cargar datos iniciales del reporte de más vendidos
            cargarDatosMasVendidos();

        }, { once: true }); // El listener se ejecuta solo una vez para optimizar.

        // --- LÓGICA PARA ABRIR LA PESTAÑA CORRECTA DESDE EL MENÚ LATERAL ---
        const handleHashChange = () => {
            const hash = window.location.hash;
            if (hash) {
                // Construimos el ID del botón de la pestaña a partir del hash
                // Ejemplo: #supervision -> supervision-tab
                const tabId = hash.substring(1) + '-tab';
                const tabButton = document.getElementById(tabId);

                if (tabButton) {
                    // Usamos el método de Bootstrap para mostrar la pestaña
                    const tab = new bootstrap.Tab(tabButton);
                    tab.show();
                }
            }
        };

        // Ejecutar al cargar la página por primera vez
        handleHashChange();

        // Ejecutar cada vez que el hash en la URL cambie (si el usuario navega entre hashes en la misma página)
        window.addEventListener('hashchange', handleHashChange, false);
    });

    function cargarDatosProduccionCosturero(fechas = []) {
        let url = '<?= base_url('reportes/produccionPorCosturero') ?>';
        if (fechas.length === 2) {
            const fechaDesde = fechas[0].toISOString().split('T')[0];
            const fechaHasta = fechas[1].toISOString().split('T')[0];
            url += `?fecha_desde=${fechaDesde}&fecha_hasta=${fechaHasta}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    actualizarGraficoYTabla(respuesta.data);
                } else {
                    toast('Error al cargar los datos del reporte.');
                }
            })
            .catch(error => {
                console.error('Error en fetch:', error);
                toast('Error de comunicación con el servidor.');
            });
    }

    function actualizarGraficoYTabla(data) {
        // Actualizar DataTable
        tablaProduccionCosturero.clear();
        tablaProduccionCosturero.rows.add(data);
        tablaProduccionCosturero.draw();

        // Preparar datos para el gráfico
        const labels = data.map(item => item.costurero);
        const valores = data.map(item => item.total_producido);

        // Destruir gráfico anterior si existe
        if (chartProduccionCosturero) {
            chartProduccionCosturero.destroy();
        }

        // Crear nuevo gráfico
        const ctx = document.getElementById('chartProduccionCosturero').getContext('2d');
        chartProduccionCosturero = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Unidades Producidas',
                    data: valores,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Producción Total por Costurero'
                    }
                }
            }
        });
    }

    function cargarDatosMasVendidos(fechas = []) {
        let url = '<?= base_url('reportes/productosMasVendidos') ?>';
        if (fechas.length === 2) {
            const fechaDesde = fechas[0].toISOString().split('T')[0];
            const fechaHasta = fechas[1].toISOString().split('T')[0];
            url += `?fecha_desde=${fechaDesde}&fecha_hasta=${fechaHasta}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    actualizarGraficoYTablaMasVendidos(respuesta.data);
                } else {
                    toast('Error al cargar los datos del reporte de ventas.');
                }
            })
            .catch(error => {
                console.error('Error en fetch:', error);
                toast('Error de comunicación con el servidor.');
            });
    }

    function actualizarGraficoYTablaMasVendidos(data) {
        // Actualizar DataTable
        tablaProductosMasVendidos.clear().rows.add(data).draw();

        // Preparar datos para el gráfico
        const labels = data.map(item => item.producto);
        const valores = data.map(item => item.total_vendido);
        const colores = generarColores(data.length);

        // Destruir gráfico anterior si existe
        if (chartProductosMasVendidos) {
            chartProductosMasVendidos.destroy();
        }

        // Crear nuevo gráfico de pastel
        const ctx = document.getElementById('chartProductosMasVendidos').getContext('2d');
        chartProductosMasVendidos = new Chart(ctx, {
            type: 'pie', // Tipo de gráfico
            data: {
                labels: labels,
                datasets: [{
                    label: 'Unidades Vendidas',
                    data: valores,
                    backgroundColor: colores,
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'right' },
                    title: { display: true, text: 'Top 10 Productos Más Vendidos' }
                }
            }
        });
    }

    function generarColores(cantidad) {
        const colores = [];
        for (let i = 0; i < cantidad; i++) {
            colores.push(`hsl(${(i * 360 / cantidad) % 360}, 70%, 60%)`);
        }
        return colores;
    }
</script>

<?php echo $this->endSection(); ?>
