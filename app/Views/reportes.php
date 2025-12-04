<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<!-- Estilos para el calendario (Flatpickr) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .report-section {
        display: none;
    }
</style>

<div class="container-fluid mt-3">
    <h2 class="text-center">Módulo de Reportes</h2>
    <hr>

    <!-- Sección de Reportes Operacionales -->
    <div id="operacionales" class="report-section mb-5">
        <h3 class="mb-3">Reportes Operacionales</h3>
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
                        <div class="row">
                            <div class="col-lg-7">
                                <canvas id="chartInventarioActual"></canvas>
                            </div>
                            <div class="col-lg-5">
                                <h5>Stock por Producto</h5>
                                <table id="tablaInventarioActual" class="table table-sm table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Stock Actual</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
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

    <!-- Sección de Reportes de Supervisión -->
    <div id="supervision" class="report-section mb-5">
        <h3 class="mb-3">Reportes de Supervisión</h3>
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
                        <div class="row mb-3 align-items-end">
                            <div class="col-md-4">
                                <label for="fechasVendedores" class="form-label">Rango de Fechas</label>
                                <input type="text" id="fechasVendedores" class="form-control" placeholder="Seleccione un rango (opcional)">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="btnFiltrarVendedores">Filtrar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-7">
                                <canvas id="chartRendimientoVendedores"></canvas>
                            </div>
                            <div class="col-lg-5">
                                <h5>Ventas por Vendedor</h5>
                                <table id="tablaRendimientoVendedores" class="table table-sm table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Vendedor</th>
                                            <th>Monto Total Vendido</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Reportes Gerenciales -->
    <div id="gerenciales" class="report-section mb-5">
        <h3 class="mb-3">Reportes Gerenciales</h3>
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

    <!-- NUEVA SECCIÓN: Reportes Estadísticos -->
    <div id="estadisticos" class="report-section mb-5">
        <h3 class="mb-3">Reportes Estadísticos</h3>
        <div class="accordion" id="accordionEstadisticos">
            <!-- Reporte Estadístico 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEst1" aria-expanded="true" aria-controls="collapseEst1">
                        #10 - Correlación entre Precio y Unidades Vendidas por Producto
                    </button>
                </h2>
                <div id="collapseEst1" class="accordion-collapse collapse show" data-bs-parent="#accordionEstadisticos">
                    <div class="accordion-body">
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="selectProductoCorrelacion" class="form-label">Seleccione un producto para analizar:</label>
                                <select id="selectProductoCorrelacion" class="form-select"></select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button id="btnGenerarCorrelacion" class="btn btn-primary">Generar Gráfico</button>
                            </div>
                        </div>
                        <div id="correlationAnalysisContainer" class="mt-4" style="display: none;">
                            <div class="row">
                                <div class="col-lg-8">
                                    <canvas id="chartCorrelacion"></canvas>
                                </div>
                                <div class="col-lg-4">
                                    <h4>Análisis de Correlación</h4>
                                    <p id="correlationProductTitle" class="fw-bold"></p>
                                    <p>
                                        Este gráfico de dispersión analiza la relación entre dos variables para el producto seleccionado:
                                    </p>
                                    <ul>
                                        <li><strong>Variable Independiente (Eje X):</strong> Precio de Venta.</li>
                                        <li><strong>Variable Dependiente (Eje Y):</strong> Cantidad Vendida en esa transacción.</li>
                                    </ul>
                                    <div id="correlationAnalysisResult" class="alert">
                                        <!-- El resultado del análisis se insertará aquí -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="correlationPlaceholder" class="text-center text-muted p-5">
                            <p>Seleccione un producto y haga clic en "Generar Gráfico" para ver el análisis.</p>
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
    let chartRendimientoVendedores;
    let tablaRendimientoVendedores;
    let chartInventarioActual;
    let tablaInventarioActual;
    let chartCorrelacion;

    // Banderas para evitar reinicializaciones
    let reporte4Inicializado = false;
    let reporte5Inicializado = false;
    let reporte6Inicializado = false;
    let reporte2Inicializado = false;
    let reporteEstadisticoInicializado = false;

    function inicializarReporte4() {
        if (reporte4Inicializado) return;

        const fp = flatpickr("#fechasCosturero", {
            mode: "range",
            "locale": "es",
            dateFormat: "Y-m-d",
        });

        tablaProduccionCosturero = $('#tablaProduccionCosturero').DataTable({
            columns: [{ data: 'costurero' }, { data: 'total_producido' }],
            language: { url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
            searching: false,
            lengthChange: false,
            pageLength: 5
        });

        document.getElementById('btnFiltrarCosturero').addEventListener('click', function() {
            cargarDatosProduccionCosturero(fp.selectedDates);
        });

        cargarDatosProduccionCosturero();
        reporte4Inicializado = true;
    }

    function inicializarReporte5() {
        if (reporte5Inicializado) return;

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

        cargarDatosMasVendidos();
        reporte5Inicializado = true;
    }

    function inicializarReporte6() {
        if (reporte6Inicializado) return;

        const fpVendedores = flatpickr("#fechasVendedores", {
            mode: "range",
            "locale": "es",
            dateFormat: "Y-m-d",
        });

        tablaRendimientoVendedores = $('#tablaRendimientoVendedores').DataTable({
            columns: [{ data: 'vendedor' }, { data: 'total_vendido', render: $.fn.dataTable.render.number('.', ',', 2, '$') }],
            language: { url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
            searching: true,
            lengthChange: false,
            pageLength: 5
        });

        document.getElementById('btnFiltrarVendedores').addEventListener('click', function() {
            cargarDatosRendimientoVendedores(fpVendedores.selectedDates);
        });

        // Cargar datos al inicializar
        cargarDatosRendimientoVendedores();
        reporte6Inicializado = true;
    }

    function inicializarReporte2() {
        if (reporte2Inicializado) return;

        tablaInventarioActual = $('#tablaInventarioActual').DataTable({
            columns: [{ data: 'producto_desc' }, { data: 'stock' }],
            language: { url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
            searching: true,
            lengthChange: false,
            pageLength: 5
        });

        // Cargar datos al inicializar
        cargarDatosInventarioActual();

        reporte2Inicializado = true;
    }


    function inicializarReporteEstadistico() {
        if (reporteEstadisticoInicializado) return;

        // Cargar la lista de productos analizables
        fetch('<?= base_url('reportes/getProductsForCorrelation') ?>')
            .then(response => response.json())
            .then(respuesta => {
                const select = document.getElementById('selectProductoCorrelacion');
                select.innerHTML = '<option value="" selected disabled>Seleccione un producto...</option>';
                if (respuesta.success && respuesta.data.length > 0) {
                    respuesta.data.forEach(producto => {
                        const option = document.createElement('option');
                        option.value = producto.id_producto;
                        option.textContent = producto.descripcion;
                        select.appendChild(option);
                    });
                } else {
                    select.innerHTML = '<option value="" disabled>No hay productos con suficientes datos</option>';
                    document.getElementById('btnGenerarCorrelacion').disabled = true;
                }
            });

        // Añadir evento al botón
        document.getElementById('btnGenerarCorrelacion').addEventListener('click', () => {
            const productId = document.getElementById('selectProductoCorrelacion').value;
            if (productId) {
                fetchAndDrawCorrelationGraph(productId);
            } else {
                toast('Por favor, seleccione un producto.');
            }
        });

        reporteEstadisticoInicializado = true;
    }

    function fetchAndDrawCorrelationGraph(productId) {
        const url = `<?= base_url('reportes/getCorrelationDataForProduct') ?>?id_producto=${productId}`;
        
        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                const placeholder = document.getElementById('correlationPlaceholder');
                const container = document.getElementById('correlationAnalysisContainer');

                if (!respuesta.success || respuesta.data.length < 3) {
                    placeholder.style.display = 'block';
                    container.style.display = 'none';
                    placeholder.innerHTML = '<p>No hay suficientes datos para este producto para generar un análisis de correlación.</p>';
                    toast('Datos insuficientes para el producto seleccionado.');
                    return;
                }

                placeholder.style.display = 'none';
                container.style.display = 'block';

                const dataPoints = respuesta.data.map(p => ({
                    x: parseFloat(p.x), // precio_unitario
                    y: parseFloat(p.y)  // cantidad
                }));

                // --- Cálculos estadísticos ---
                const { m, b, r } = calculateCorrelation(dataPoints);

                // --- Actualizar texto de análisis ---
                const productName = document.getElementById('selectProductoCorrelacion').options[document.getElementById('selectProductoCorrelacion').selectedIndex].text;
                document.getElementById('correlationProductTitle').textContent = `Análisis para: ${productName}`;
                updateAnalysisText(r);

                // --- Preparar datos para el gráfico ---
                const trendlineData = dataPoints.map(p => ({ x: p.x, y: m * p.x + b }));
                trendlineData.sort((a, b) => a.x - b.x);

                // --- Dibujar el gráfico ---
                if (chartCorrelacion) {
                    chartCorrelacion.destroy();
                }
                const ctx = document.getElementById('chartCorrelacion').getContext('2d');
                chartCorrelacion = new Chart(ctx, {
                    type: 'scatter',
                    data: {
                        datasets: [{
                            label: `Ventas de ${productName}`,
                            data: dataPoints,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)'
                        }, {
                            label: 'Línea de Tendencia',
                            data: trendlineData,
                            type: 'line',
                            fill: false,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: `Correlación Precio vs. Cantidad Vendida` },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const point = context.raw; 
                                        return `Precio de Venta del producto "${productName}"= ${point.x.toFixed(2)} y y la cantidad vendida es de ${point.y}.`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                type: 'linear', position: 'bottom', beginAtZero: true,
                                title: { display: true, text: 'Precio de Venta ($)' }
                            },
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Cantidad Vendida (Unidades)' }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error al cargar datos de correlación:', error);
                toast('Error de comunicación al cargar datos para el reporte estadístico.');
            });
    }

    function calculateCorrelation(data) {
        let sumX = 0, sumY = 0, sumXY = 0, sumX2 = 0, sumY2 = 0;
        const n = data.length;

        if (n < 2) return { m: 0, b: 0, r: 0 };

        data.forEach(p => {
            sumX += p.x;
            sumY += p.y;
            sumXY += p.x * p.y;
            sumX2 += p.x * p.x;
            sumY2 += p.y * p.y;
        });

        const m = (n * sumXY - sumX * sumY) / (n * sumX2 - sumX * sumX);
        const b = (sumY - m * sumX) / n;

        const numerator = n * sumXY - sumX * sumY;
        const denominator = Math.sqrt((n * sumX2 - sumX * sumX) * (n * sumY2 - sumY * sumY));
        const r = denominator === 0 ? 0 : numerator / denominator;

        return { m, b, r };
    }

    function updateAnalysisText(r) {
        const analysisDiv = document.getElementById('correlationAnalysisResult');
        let strength = '';
        let direction = '';
        let conclusion = '';
        let alertClass = 'alert-secondary';

        if (r > 0.7) {
            strength = 'fuerte';
            direction = 'positiva';
            alertClass = 'alert-success';
            conclusion = 'A medida que el precio aumenta, las ventas de este producto tienden a aumentar significativamente. Podría ser percibido como un artículo de mayor calidad o deseabilidad a precios más altos.';
        } else if (r > 0.3) {
            strength = 'moderada';
            direction = 'positiva';
            alertClass = 'alert-info';
            conclusion = 'Existe una tendencia a que las ventas aumenten con el precio, aunque la relación no es muy fuerte.';
        } else if (r < -0.7) {
            strength = 'fuerte';
            direction = 'negativa';
            alertClass = 'alert-danger';
            conclusion = 'A medida que el precio aumenta, las ventas de este producto tienden a disminuir significativamente. Es un producto sensible al precio.';
        } else if (r < -0.3) {
            strength = 'moderada';
            direction = 'negativa';
            alertClass = 'alert-warning';
            conclusion = 'Existe una tendencia a que las ventas disminuyan con el precio, aunque otros factores también influyen.';
        } else {
            strength = 'muy débil o nula';
            direction = '';
            alertClass = 'alert-secondary';
            conclusion = 'No parece haber una relación clara entre el precio y la cantidad vendida. Las ventas pueden depender de otros factores como promociones, temporada, etc.';
        }

        analysisDiv.className = `alert ${alertClass}`;
        analysisDiv.innerHTML = `
            <strong>Coeficiente de Correlación (r): ${r.toFixed(4)}</strong>
            <p>Esto indica una correlación ${direction} <strong>${strength}</strong>.</p>
            <hr>
            <p class="mb-0"><strong>Conclusión:</strong> ${conclusion}</p>
        `;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const showSectionFromHash = () => {
            document.querySelectorAll('.report-section').forEach(section => {
                section.style.display = 'none';
            });

            let hash = window.location.hash || '#operacionales';
            const targetSection = document.querySelector(hash);

            if (targetSection) {
                targetSection.style.display = 'block';

                if (hash === '#supervision') {
                    inicializarReporte4();
                    if (document.getElementById('collapseSup2').classList.contains('show')) {
                        inicializarReporte5();
                    }
                } else if (hash === '#estadisticos') {
                    inicializarReporteEstadistico();
                }

            } else {
                document.querySelector('#operacionales').style.display = 'block';
            }
        };

        const collapseMasVendidos = document.getElementById('collapseSup2');
        collapseMasVendidos.addEventListener('shown.bs.collapse', inicializarReporte5, { once: true });

        // Para el reporte #6
        const collapseVendedores = document.getElementById('collapseSup3');
        collapseVendedores.addEventListener('shown.bs.collapse', inicializarReporte6, { once: true });

        // Para el reporte #2
        const collapseInventario = document.getElementById('collapseOp2');
        collapseInventario.addEventListener('shown.bs.collapse', inicializarReporte2, { once: true });


        showSectionFromHash();
        window.addEventListener('hashchange', showSectionFromHash, false);
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
        tablaProduccionCosturero.clear().rows.add(data).draw();
        const labels = data.map(item => item.costurero);
        const valores = data.map(item => item.total_producido);

        if (chartProduccionCosturero) {
            chartProduccionCosturero.destroy();
        }

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
                scales: { y: { beginAtZero: true } },
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Producción Total por Costurero' }
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
        tablaProductosMasVendidos.clear().rows.add(data).draw();
        const labels = data.map(item => item.producto);
        const valores = data.map(item => item.total_vendido);
        const colores = generarColores(data.length);

        if (chartProductosMasVendidos) {
            chartProductosMasVendidos.destroy();
        }

        const ctx = document.getElementById('chartProductosMasVendidos').getContext('2d');
        chartProductosMasVendidos = new Chart(ctx, {
            type: 'pie',
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

    function cargarDatosRendimientoVendedores(fechas = []) {
        let url = '<?= base_url('reportes/rendimientoVendedores') ?>';
        if (fechas.length === 2) {
            const fechaDesde = fechas[0].toISOString().split('T')[0];
            const fechaHasta = fechas[1].toISOString().split('T')[0];
            url += `?fecha_desde=${fechaDesde}&fecha_hasta=${fechaHasta}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    actualizarGraficoYTablaVendedores(respuesta.data);
                } else {
                    toast('Error al cargar los datos de vendedores.');
                }
            })
            .catch(error => {
                console.error('Error en fetch:', error);
                toast('Error de comunicación con el servidor.');
            });
    }

    function actualizarGraficoYTablaVendedores(data) {
        tablaRendimientoVendedores.clear().rows.add(data).draw();
        
        const labels = data.map(item => item.vendedor);
        const valores = data.map(item => item.total_vendido);

        if (chartRendimientoVendedores) {
            chartRendimientoVendedores.destroy();
        }

        const ctx = document.getElementById('chartRendimientoVendedores').getContext('2d');
        chartRendimientoVendedores = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monto Vendido',
                    data: valores,
                    backgroundColor: generarColores(labels.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { 
                    legend: { 
                        position: 'left',
                    }, 
                    title: { display: true, text: 'Rendimiento de Vendedores (Monto Total)' } 
                }
            }
        });
    }


    function cargarDatosInventarioActual() {
        let url = '<?= base_url('reportes/inventarioActual') ?>';

        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    actualizarGraficoYTablaInventario(respuesta.data);
                } else {
                    toast('Error al cargar los datos del inventario.');
                }
            })
            .catch(error => {
                console.error('Error en fetch:', error);
                toast('Error de comunicación con el servidor.');
            });
    }

    function actualizarGraficoYTablaInventario(data) {
        tablaInventarioActual.clear().rows.add(data).draw();
        
        // Tomar solo los primeros 15 para el gráfico para que sea legible
        const dataParaGrafico = data.slice(0, 15);
        const labels = dataParaGrafico.map(item => item.producto_desc);
        const valores = dataParaGrafico.map(item => item.stock);

        if (chartInventarioActual) {
            chartInventarioActual.destroy();
        }

        const ctx = document.getElementById('chartInventarioActual').getContext('2d');
        chartInventarioActual = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Stock Disponible',
                    data: valores,
                    backgroundColor: generarColores(labels.length),
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // Gráfico de barras horizontales para mejor legibilidad
                scales: { x: { beginAtZero: true } },
                responsive: true,
                plugins: { legend: { display: false }, title: { display: true, text: 'Inventario Actual de Productos (Top 15)' } }
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
