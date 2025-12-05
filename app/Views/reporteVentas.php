<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<!-- Estilos para el calendario (Flatpickr) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="bi bi-file-earmark-text-fill me-3"></i>
                Reporte de Ventas
            </h2>
        </div>
        <div class="card-body">
            <!-- Sección de Filtros -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Filtros de Búsqueda</h5>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="filtroFechas" class="form-label">Rango de Fechas</label>
                            <input type="text" id="filtroFechas" class="form-control" placeholder="Seleccione un rango">
                        </div>
                        <div class="col-md-3">
                            <label for="filtroClienteCi" class="form-label">CI/RIF del Cliente</label>
                            <input type="text" id="filtroClienteCi" class="form-control" placeholder="Ingrese CI/RIF">
                        </div>
                        <div class="col-md-3">
                            <label for="filtroEmpleado" class="form-label">Vendedor</label>
                            <select id="filtroEmpleado" class="form-select">
                                <option value="">Todos</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" id="btnFiltrarVentas"><i class="bi bi-funnel-fill"></i> Filtrar</button>
                            <button class="btn btn-secondary w-100 mt-2" id="btnLimpiarFiltros"><i class="bi bi-eraser-fill"></i> Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Ventas -->
            <div class="table-responsive">
                <table id="tablaVentas" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th class="text-center">ID Venta</th>
                            <th class="text-center">Fecha</th>
                            <th>Cliente</th>
                            <th>CI/RIF Cliente</th>
                            <th>Vendedor</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se llenarán con DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Detalles de la Venta -->
<div class="modal fade" id="modalDetalleVenta" tabindex="-1" aria-labelledby="modalDetalleVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetalleVentaLabel">Detalles de la Venta #<span id="idVentaDetalle"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="infoVentaGeneral">
                    <!-- Info general de la venta se puede agregar aquí si se desea -->
                </div>
                <h6>Productos en la Venta:</h6>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>ID Producto</th>
                            <th>Descripción</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio Unit.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaDetalleVenta">
                        <!-- Los detalles de los productos se insertarán aquí -->
                    </tbody>
                </table>
                <h5 class="text-end mt-3">Total Venta: <span id="totalVentaDetalle" class="text-success"></span></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Librerías para calendario -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
    let tablaVentas;
    let fp;

    $(document).ready(function() {
        // Inicializar Flatpickr
        fp = flatpickr("#filtroFechas", {
            mode: "range",
            "locale": "es",
            dateFormat: "Y-m-d",
        });

        // Cargar lista de empleados/vendedores
        cargarVendedores();

        // Inicializar DataTable
        tablaVentas = $('#tablaVentas').DataTable({
            processing: true,
            serverSide: false, // Lo manejaremos del lado del cliente después de la carga inicial
            ajax: {
                url: '<?= base_url('reportes/listadoVentas') ?>',
                dataSrc: 'data'
            },
            columns: [
                { data: 'id_venta', className: 'text-center' },
                { data: 'fecha', className: 'text-center' },
                { data: 'nombre_cliente' },
                { data: 'ci_rif_cliente' },
                { data: 'nombre_empleado' },
                { data: 'total', className: 'text-end', render: $.fn.dataTable.render.number('.', ',', 2, '$') },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<button class="btn btn-info btn-sm" onclick="mostrarDetalles(${row.id_venta})">
                                    <i class="bi bi-eye"></i> Ver
                                </button>`;
                    }
                }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });

        // Evento para el botón de filtrar
        $('#btnFiltrarVentas').on('click', function() {
            filtrarVentas();
        });

        // Evento para limpiar filtros
        $('#btnLimpiarFiltros').on('click', function() {
            $('#filtroClienteCi').val('');
            $('#filtroEmpleado').val('');
            fp.clear();
            filtrarVentas(); // Recarga la tabla con todos los datos
        });
    });

    function filtrarVentas() {
        const fechas = fp.selectedDates;
        const clienteCi = $('#filtroClienteCi').val();
        const idEmpleado = $('#filtroEmpleado').val();
        
        let url = '<?= base_url('reportes/listadoVentas') ?>?';
        let params = [];

        if (fechas.length === 2) {
            params.push(`fecha_desde=${fechas[0].toISOString().split('T')[0]}`);
            params.push(`fecha_hasta=${fechas[1].toISOString().split('T')[0]}`);
        }
        if (clienteCi) {
            params.push(`cliente_ci=${clienteCi}`);
        }
        if (idEmpleado) {
            params.push(`id_empleado=${idEmpleado}`);
        }

        tablaVentas.ajax.url(url + params.join('&')).load();
    }

    function cargarVendedores() {
        fetch('<?= base_url('listaEmpleados') ?>')
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    const select = $('#filtroEmpleado');
                    respuesta.data.forEach(empleado => {
                        select.append(new Option(`${empleado.nombre} ${empleado.apellido}`, empleado.id_empleado));
                    });
                }
            })
            .catch(error => console.error('Error al cargar vendedores:', error));
    }

    function mostrarDetalles(idVenta) {
        fetch(`<?= base_url('reportes/detalleVenta/') ?>${idVenta}`)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    const detalles = respuesta.data;
                    const cuerpoTabla = $('#cuerpoTablaDetalleVenta');
                    cuerpoTabla.empty();
                    let totalVenta = 0;

                    detalles.forEach(item => {
                        const subtotal = parseFloat(item.cantidad) * parseFloat(item.precio_unitario);
                        totalVenta += subtotal;
                        const fila = `
                            <tr>
                                <td>${item.id_producto}</td>
                                <td>${item.producto_descripcion}</td>
                                <td class="text-center">${item.cantidad}</td>
                                <td class="text-end">$${parseFloat(item.precio_unitario).toFixed(2)}</td>
                                <td class="text-end">$${subtotal.toFixed(2)}</td>
                            </tr>
                        `;
                        cuerpoTabla.append(fila);
                    });

                    $('#idVentaDetalle').text(idVenta);
                    $('#totalVentaDetalle').text(`$${totalVenta.toFixed(2)}`);
                    
                    const modal = new bootstrap.Modal(document.getElementById('modalDetalleVenta'));
                    modal.show();
                } else {
                    toast('Error al cargar los detalles de la venta.', 'error');
                }
            })
            .catch(error => {
                console.error('Error en fetch:', error);
                toast('Error de comunicación con el servidor.', 'error');
            });
    }

</script>
<?php echo $this->endSection(); ?>

