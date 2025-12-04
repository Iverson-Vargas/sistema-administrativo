<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<div class="container">
    <div style="margin-bottom: 10px;" class="row mt-3">
        <div class="col-md-12">
            <h3 class="text-center">Gestion de Productos</h3>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-primary"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#modalCrearProducto"
                    onclick="limpiarFormulario()">
                    <i class="bi bi-plus-circle"></i>
                    Crear Producto
                </button>
                <div>
                    <button id="btnActualizar" class="btn btn-warning me-2" style="color: #FCF7F7;"><i class="bi bi-pencil-square"></i> Actualizar </button>
                    <button id="btnDeshabilitar" class="btn btn-danger"><i class="bi bi-trash"></i> Deshabilitar </button>
                </div>
            </div>
            <div class="tabla-scroll-vertical">

                <table id="tablaMisProductos" class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>ID del Producto</th>
                            <th>Tono</th>
                            <th>Talla</th>
                            <th>Descripcion</th>
                            <th>Precio Unitario</th>
                        </tr>
                    </thead>
                    <!-- <tbody id="cuerpoTablaMisProductos">
                <!-- Los datos se llenarán con JavaScript -->
                    <!--</tbody> -->
                </table>
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
                <h3 class="text-center">Detalles del Producto</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="idProducto" class="form-label">Ingresar ID del Producto</label>
                        <input type="text" class="form-control" id="idProducto">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="precioUnitario" class="form-label">Ingresar Precio Unitario</label>
                        <input type="number" class="form-control" id="precioUnitario">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tonoProducto" class="form-label">Seleccionar tono del producto</label>
                        <select type="text" class="form-select" id="tonoProducto"></select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tallaProducto" class="form-label">Seleccionar talla del producto</label>
                        <select type="text" class="form-select" id="tallaProducto"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="text" class="form-control" id="descripcion" rows="2"></textarea>
                    </div>
                </div>
                <div id="resultado"></div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="CrearProducto()">Crear Producto</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>
<script>
    window.onload = function() {
        listarTonos();
        listarTallas();
    };

    let tabla; // Declara la variable 'tabla' aquí para que sea global
    $(document).ready(function() {
        tabla = $('#tablaMisProductos').DataTable({
            ajax: '<?= base_url('listaProducto'); ?>',
            columns: [{
                    data: null,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="producto-checkbox" name="seleccionarProducto" value="${data.id_producto}">`;
                    }
                },
                {
                    data: 'id_producto'
                },
                {
                    data: 'tono'
                },
                {
                    data: 'talla'
                },
                {
                    data: 'descripcion'
                },
                {
                    data: 'precio_unitario'
                },
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });

        // Lógica para permitir solo un checkbox seleccionado
        $('#tablaMisProductos tbody').on('click', '.producto-checkbox', function() {
            const clickedCheckbox = this;

            if ($(clickedCheckbox).is(':checked')) {
                // Desmarcar todos los demás checkboxes en el cuerpo de la tabla
                $('#tablaMisProductos tbody .producto-checkbox').not(clickedCheckbox).prop('checked', false);
            }
        });
    });

    function listarTonos() {

        const url = '<?= base_url('listaTono') ?>';
        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    let select = document.getElementById('tonoProducto');
                    select.innerHTML = '<option value="" selected disabled>Seleccione...</option>';
                    respuesta.data.forEach(tono => {
                        let option = document.createElement('option');
                        option.value = tono.id_tono;
                        option.textContent = tono.descripcion;
                        select.appendChild(option);
                    });
                } else {
                    alert('Error al cargar los tonos.')
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function listarTallas() {

        const url = '<?= base_url('listaTalla') ?>';
        fetch(url)
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    let select = document.getElementById('tallaProducto');
                    select.innerHTML = '<option value="" selected disabled>Seleccione...</option>';
                    respuesta.data.forEach(talla => {
                        let option = document.createElement('option');
                        option.value = talla.id_talla;
                        option.textContent = talla.descripcion;
                        select.appendChild(option);
                    });
                } else {
                    alert('Error al cargar las tallas.')
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function CrearProducto() {
        const url = '<?= base_url('crearProducto'); ?>';
        let idProducto = document.getElementById('idProducto').value;
        let tonoProducto = document.getElementById('tonoProducto').value;
        let tallaProducto = document.getElementById('tallaProducto').value;
        let descripcion = document.getElementById('descripcion').value;
        let precioUnitario = document.getElementById('precioUnitario').value;

        if (idProducto === '' || tonoProducto === '' || tallaProducto === '' || descripcion === '' || precioUnitario === '') {
            const mensaje = document.getElementById('resultado');
            mensaje.innerHTML = '<div class="alert alert-danger" role="alert">Por favor, complete todos los campos.</div>';
            return;
        }

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    idProducto: idProducto,
                    tonoProducto: tonoProducto,
                    tallaProducto: tallaProducto,
                    descripcion: descripcion,
                    precioUnitario: precioUnitario
                })
            })
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    tabla.ajax.reload();
                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalCrearProducto'));
                    modal.hide();
                    let mensaje = 'El producto fue creado correctamente.';
                    setTimeout(function() {
                        toast(mensaje)
                    }, 500);
                } else {
                    mensaje = 'Error al crear el producto.';
                    setTimeout(function() {
                        toast(mensaje)
                    }, 500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
    }

    function limpiarFormulario() {
        document.getElementById('idProducto').value = '';
        document.getElementById('tonoProducto').value = '';
        document.getElementById('tallaProducto').value = '';
        document.getElementById('descripcion').value = '';
        document.getElementById('precioUnitario').value = '';
    }
</script>
<?php echo $this->endSection(); ?>