<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>





<div class="container">
    <button style="background-color: #162456; color: white;" class="btn"
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#modalCrearLote"
        onclick="LimpiarFormulario()">
        Crear Lote
    </button>
    <button style="background-color: #162456; color: white;" class="btn"
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#modalCrearProducto"
        onclick="LimpiarFormulario()">
        Crear Producto
    </button>
    <table id="tablaProduccion" class="table table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Costurero</th>
                <th>Cantidad Producida</th>
                <th>Fecha de Producción</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Producto A</td>
                <td>Jose</td>
                <td>100</td>
                <td>2023-01-01</td>
            </tr>
            <tr>
                <td>Producto B</td>
                <td>Maria</td>
                <td>200</td>
                <td>2023-01-02</td>
            </tr>
            <tr>
                <td>Producto C</td>
                <td>Jose</td>
                <td>300</td>
                <td>2023-01-03</td>
            </tr>
            <tr>
                <td>Producto D</td>
                <td>Maria</td>
                <td>400</td>
                <td>2023-01-04</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalCrearLote" tabindex="-1" aria-labelledby="modalCrearLote" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCrearLote">Crear Lote</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Datos de Lote</h3>
                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="producto" class="form-label">Producto</label>
                            <select type="text" class="form-select" id="producto"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="text" class="form-control" id="cantidad" placeholder="Ingrese la cantidad">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha de fabricación</label>
                            <input type="date" class="form-control" id="fecha" placeholder="Ingrese la fecha de fabricación">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="costurero" class="form-label">Costurero</label>
                            <select type="text" class="form-select" id="costurero"></select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="">Crear Lote</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCrearProducto" tabindex="-1" aria-labelledby="modalCrearProducto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCrearProducto">Crear Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Datos de Producto</h3>
                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre del producto">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" placeholder="Ingrese el modelo del producto">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tono" class="form-label">Tono</label>
                            <input type="text" class="form-control" id="tono" placeholder="Ingrese el tono del producto">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="precio" placeholder="Ingrese el precio del producto">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="">Crear Producto</button>
                </div>
            </div>
        </div>
    </div>
</div>




    <?php echo $this->endSection(); ?>
    <?php echo $this->section('scripts'); ?>


    <script>
        $(document).ready(function() {
            tabla = $('#tablaProduccion').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                }
            });
        });
    </script>




    <?php echo $this->endSection(); ?>