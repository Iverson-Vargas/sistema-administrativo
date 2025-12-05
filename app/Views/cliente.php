<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="bi bi-people-fill me-3"></i>
                Gestión de Clientes
            </h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalCrearCliente" onclick="limpiarFormulario()">
                    <i class="bi bi-plus-circle"></i> Crear Cliente
                </button>
            </div>
            <div class="table-responsive">
                <table id="tablaClientes" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Nombre / Razón Social</th>
                            <th class="text-center">CI / RIF</th>
                            <th class="text-center">Tipo</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Dirección</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Crear Cliente -->
<div class="modal fade" id="modalCrearCliente" tabindex="-1" aria-labelledby="modalCrearClienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearClienteLabel">Registrar Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCrearCliente">
                    <h6 class="text-primary">Datos Generales</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tipo_persona" class="form-label">Tipo de Persona</label>
                            <select id="tipo_persona" class="form-select" required onchange="toggleCamposPersona()">
                                <option value="N" selected>Natural</option>
                                <option value="J">Jurídico</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ci_rif" class="form-label">Cédula / RIF</label>
                            <input type="text" id="ci_rif" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" id="telefono" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" id="correo" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea id="direccion" class="form-control" rows="2" required></textarea>
                    </div>

                    <hr>

                    <!-- Campos para Persona Natural -->
                    <div id="camposPersonaNatural">
                        <h6 class="text-success">Datos Persona Natural</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" id="apellido" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select id="sexo" class="form-select">
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Campos para Persona Jurídica -->
                    <div id="camposPersonaJuridica" style="display: none;">
                        <h6 class="text-info">Datos Persona Jurídica</h6>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="razon_social" class="form-label">Razón Social</label>
                                <input type="text" id="razon_social" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="crearCliente()">Guardar Cliente</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script>
    let tablaClientes;

    $(document).ready(function() {
        tablaClientes = $('#tablaClientes').DataTable({
            ajax: {
                url: '<?= base_url('cliente/listar') ?>',
                dataSrc: 'data',
                error: function(xhr, error, thrown) {
                    console.error("DataTables AJAX error:", xhr, error, thrown);
                    let errorMessage = 'Error al cargar los datos de clientes.';
                    try {
                        const responseJson = JSON.parse(xhr.responseText);
                        if (responseJson && responseJson.message) {
                            errorMessage = responseJson.message;
                        } else if (xhr.status === 0) {
                            errorMessage = 'No se pudo conectar con el servidor.';
                        } else if (xhr.status === 404) {
                            errorMessage = 'Recurso no encontrado (404).';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Error interno del servidor (500).';
                        } else {
                            errorMessage = `Error: ${xhr.status} ${xhr.statusText}`;
                        }
                    } catch (e) { /* Not JSON */ }
                    toast(errorMessage, 'error');
                }
            },
            columns: [
                { data: 'id_cliente', className: 'text-center' },
                { data: 'nombre_completo' },
                { data: 'ci_rif', className: 'text-center' },
                { 
                    data: 'tipo', 
                    className: 'text-center',
                    render: function(data) {
                        if (data === 'N') return '<span class="badge bg-primary">Natural</span>';
                        if (data === 'J') return '<span class="badge bg-info">Jurídico</span>';
                        return data;
                    }
                },
                { data: 'telefono' },
                { data: 'correo' },
                { data: 'direccion' }
            ],
            language: { url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" }
        });
    });

    function toggleCamposPersona() {
        const tipo = $('#tipo_persona').val();
        if (tipo === 'N') {
            $('#camposPersonaNatural').show();
            $('#camposPersonaJuridica').hide();
        } else if (tipo === 'J') {
            $('#camposPersonaNatural').hide();
            $('#camposPersonaJuridica').show();
        }
    }

    function limpiarFormulario() {
        $('#formCrearCliente')[0].reset();
        toggleCamposPersona();
    }

    function crearCliente() {
        const url = '<?= base_url('cliente/crear') ?>';
        const tipo = $('#tipo_persona').val();
        
        let payload = {
            tipo: tipo,
            ci_rif: $('#ci_rif').val(),
            telefono: $('#telefono').val(),
            correo: $('#correo').val(),
            direccion: $('#direccion').val()
        };

        if (tipo === 'N') {
            payload.nombre = $('#nombre').val();
            payload.apellido = $('#apellido').val();
            payload.sexo = $('#sexo').val();
        } else if (tipo === 'J') {
            payload.razon_social = $('#razon_social').val();
        }

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(respuesta => {
            if (respuesta.success) {
                toast('Cliente creado exitosamente.');
                tablaClientes.ajax.reload();
                bootstrap.Modal.getInstance(document.getElementById('modalCrearCliente')).hide();
            } else {
                toast(respuesta.message || 'Error al crear el cliente.', 'error');
            }
        })
        .catch(error => {
            console.error('Error en fetch:', error);
            toast('Error de comunicación con el servidor.', 'error');
        });
    }
</script>
<?php echo $this->endSection(); ?>
