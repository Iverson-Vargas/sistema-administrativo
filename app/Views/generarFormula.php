<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<style>
    .step-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: #0d6efd;
        color: white;
        font-weight: bold;
        margin-right: 10px;
        font-size: 1rem;
    }
    .table-header-custom {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    .card-header-gradient {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }
</style>

<div style="margin-bottom: 25px;" class="container-fluid mt-4">
    <div class="card shadow border-0 rounded-3">
        <div class="card-header card-header-gradient text-white py-3">
            <h3 class="card-title mb-0 fw-bold">
                <i class="bi bi-flask me-2"></i> Gestión de Fórmulas
            </h3>
        </div>
        <div class="card-body p-4">
            
            <!-- Paso A: Seleccionar Producto -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="text-primary fw-bold mb-3 d-flex align-items-center">
                        <span class="step-icon">1</span> Seleccionar Producto y Talla
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="form-floating">
                                <select id="selectProducto" class="form-select">
                                    <option value="" selected disabled>Seleccione un producto de la lista...</option>
                                </select>
                                <label for="selectProducto">Producto a formular</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select id="selectTalla" class="form-select">
                                    <option value="" selected disabled>Seleccione talla...</option>
                                </select>
                                <label for="selectTalla">Talla</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4 text-muted">

            <!-- Paso B: Agregar Ingredientes -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="text-primary fw-bold mb-3 d-flex align-items-center">
                        <span class="step-icon">2</span> Agregar Materia Prima (Ingredientes)
                    </h5>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="selectMateriaPrima" class="form-label fw-semibold">Materia Prima</label>
                    <select id="selectMateriaPrima" class="form-select" onchange="actualizarUnidad()">
                        <option value="" selected disabled>Seleccione ingrediente...</option>
                        <!-- Se llena dinámicamente -->
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="inputCantidad" class="form-label fw-semibold">Cantidad Requerida</label>
                    <div class="input-group">
                        <input type="number" id="inputCantidad" class="form-control" placeholder="Ej: 1.5" step="0.01" min="0.01">
                        <span class="input-group-text bg-light" id="unidadMedidaDisplay">Unid.</span>
                    </div>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button class="btn btn-success w-100 shadow-sm" id="btnAgregarIngrediente" onclick="agregarIngrediente()">
                        <i class="bi bi-plus-circle me-2"></i> Agregar
                    </button>
                </div>
            </div>

            <!-- Tabla Temporal -->
            <div class="table-responsive mb-4 shadow-sm rounded border">
                <table class="table table-hover align-middle mb-0" id="tablaFormula">
                    <thead class="table-header-custom">
                        <tr>
                            <th class="ps-4">Materia Prima</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Unidad</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaFormula">
                        <tr id="filaVacia">
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-basket display-6 d-block mb-2 opacity-50"></i>
                                No hay ingredientes agregados a la fórmula.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paso C: Guardar -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3 border-top">
                <button class="btn btn-outline-secondary me-md-2 px-4" onclick="location.reload()">
                    <i class="bi bi-x-lg me-2"></i> Cancelar
                </button>
                <button class="btn btn-primary btn-lg px-5 shadow" onclick="guardarFormula()">
                    <i class="bi bi-save-fill me-2"></i> Guardar Fórmula
                </button>
            </div>

        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>
<script>
    let ingredientes = [];

    $(document).ready(function() {
        cargarProductos();
        cargarMateriasPrimas();
        cargarTallas();
    });

    function cargarProductos() {
        fetch('<?= base_url('listaProducto') ?>')
            .then(response => response.json())
            .then(res => {
                if (res.data) {
                    const select = document.getElementById('selectProducto');
                    res.data.forEach(prod => {
                        const option = document.createElement('option');
                        option.value = prod.id_producto;
                        option.textContent = `${prod.nombre}`;
                        select.appendChild(option);
                    });
                }
            })
            .catch(err => console.error('Error cargando productos:', err));
    }

    function cargarTallas() {
        fetch('<?= base_url('listaTalla') ?>')
            .then(response => response.json())
            .then(res => {
                if (res.success && res.data) {
                    const select = document.getElementById('selectTalla');
                    res.data.forEach(talla => {
                        const option = document.createElement('option');
                        option.value = talla.id_talla;
                        option.textContent = talla.descripcion;
                        select.appendChild(option);
                    });
                }
            })
            .catch(err => console.error('Error cargando tallas:', err));
    }

    function cargarMateriasPrimas() {
        fetch('<?= base_url('listaMateriaPrima') ?>') 
            .then(response => response.json())
            .then(res => {
                if (res.data) {
                    llenarSelectMateriaPrima(res.data);
                } else {
                    console.error('No se encontraron datos de materia prima en la respuesta.');
                }
            })
            .catch(err => {
                console.error('Error al cargar las materias primas:', err);
            });
    }

    function llenarSelectMateriaPrima(data) {
        const select = document.getElementById('selectMateriaPrima');
        data.forEach(mp => {
            const option = document.createElement('option');
            option.value = mp.id_materia_prima;
            option.textContent = mp.nombre;
            option.dataset.unidad = mp.unidad_medida;
            select.appendChild(option);
        });
    }

    function actualizarUnidad() {
        const select = document.getElementById('selectMateriaPrima');
        const selectedOption = select.options[select.selectedIndex];
        const unidad = selectedOption.dataset.unidad || 'Unid.';
        document.getElementById('unidadMedidaDisplay').textContent = unidad;
    }

    function agregarIngrediente() {
        const selectMp = document.getElementById('selectMateriaPrima');
        const inputCant = document.getElementById('inputCantidad');
        
        const idMateriaPrima = selectMp.value;
        const nombreMateriaPrima = selectMp.options[selectMp.selectedIndex].text;
        const unidad = document.getElementById('unidadMedidaDisplay').textContent;
        const cantidad = parseFloat(inputCant.value);

        if (!idMateriaPrima) {
            toast('Seleccione una materia prima.');
            return;
        }
        if (isNaN(cantidad) || cantidad <= 0) {
            toast('Ingrese una cantidad válida mayor a 0.');
            return;
        }

        // Verificar si ya existe
        const existe = ingredientes.find(i => i.id_materia_prima === idMateriaPrima);
        if (existe) {
            toast('Esta materia prima ya está en la lista.');
            return;
        }

        // Agregar al array
        ingredientes.push({
            id_materia_prima: idMateriaPrima,
            nombre: nombreMateriaPrima,
            cantidad_requerida: cantidad,
            unidad: unidad
        });

        renderizarTabla();
        
        // Limpiar campos
        selectMp.value = "";
        inputCant.value = "";
        document.getElementById('unidadMedidaDisplay').textContent = "Unid.";
        selectMp.focus();
    }

    function renderizarTabla() {
        const tbody = document.getElementById('cuerpoTablaFormula');
        tbody.innerHTML = '';

        if (ingredientes.length === 0) {
            tbody.innerHTML = `
                <tr id="filaVacia">
                    <td colspan="4" class="text-center text-muted py-5">
                        <i class="bi bi-basket display-6 d-block mb-2 opacity-50"></i>
                        No hay ingredientes agregados a la fórmula.
                    </td>
                </tr>`;
            return;
        }

        ingredientes.forEach((ing, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="ps-4 fw-semibold">${ing.nombre}</td>
                <td class="text-center">${ing.cantidad_requerida}</td>
                <td class="text-center text-muted small">${ing.unidad}</td>
                <td class="text-center">
                    <button class="btn btn-outline-danger btn-sm" onclick="eliminarIngrediente(${index})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function eliminarIngrediente(index) {
        ingredientes.splice(index, 1);
        renderizarTabla();
    }

    function guardarFormula() {
        const idProducto = document.getElementById('selectProducto').value;
        const idTalla = document.getElementById('selectTalla').value;

        if (!idProducto) {
            toast('Por favor, seleccione un producto.');
            return;
        }
        if (!idTalla) {
            toast('Por favor, seleccione una talla.');
            return;
        }
        if (ingredientes.length === 0) {
            toast('Agregue al menos un ingrediente a la fórmula.');
            return;
        }

        const data = {
            id_producto: idProducto,
            id_talla: idTalla,
            ingredientes: ingredientes
        };

        // Botón loading
        const btn = document.querySelector('button[onclick="guardarFormula()"]');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';

        // Se asume la ruta 'guardarFormula'
        fetch('<?= base_url('guardarFormula') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                toast('Fórmula guardada exitosamente.');
                setTimeout(() => location.reload(), 1500);
            } else {
                toast(res.message || 'Error al guardar la fórmula.');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        })
        .catch(err => {
            console.error(err);
            // Mensaje de fallback si la ruta no existe aún
            toast('Error de comunicación (Verifique que la ruta guardarFormula exista).');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }
</script>
<?php echo $this->endSection(); ?>