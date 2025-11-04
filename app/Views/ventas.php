<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ventas.css'); ?>">
</head>
<body>
    <div class="sales-container">
        <h1>Apartado de Ventas de Pantalones</h1>
        
        <!-- Botón Crear Venta -->
        <button class="create-button" id="createBtn" data-bs-toggle="modal" data-bs-target="#createSaleModal">Crear Venta</button>
        
        <!-- Modal para Crear Venta -->
        <div class="modal fade" id="createSaleModal" tabindex="-1" aria-labelledby="createSaleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSaleModalLabel">Crear Venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="create-form" action="/submit-sale" method="post"> <!-- Ajusta la acción según tu backend -->
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="cedula">Cédula:</label>
                                <input type="text" id="cedula" name="cedula" required>
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección:</label>
                                <input type="text" id="direccion" name="direccion" required>
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo:</label>
                                <input type="email" id="correo" name="correo" required>
                            </div>
                            <div class="form-group">
                                <label for="tipo_cliente">Tipo Cliente:</label>
                                <select id="tipo_cliente" name="tipo_cliente" required>
                                    <option value="V">V</option>
                                    <option value="J">J</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lote_id">Lote ID:</label>
                                <input type="text" id="lote_id" name="lote_id" required>
                            </div>
                            <div class="form-group">
                                <label for="producto">Producto:</label>
                                <input type="text" id="producto" name="producto" required>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" id="cantidad" name="cantidad" required>
                            </div>
                            <div class="form-group">
                                <label for="costurero">Costurero:</label>
                                <input type="text" id="costurero" name="costurero" required>
                            </div>
                            <div class="form-group">
                                <label for="ano">Año:</label>
                                <input type="number" id="ano" name="ano" required>
                            </div>
                            <div class="form-group">
                                <label for="precio_total">Precio Total:</label>
                                <input type="number" step="0.01" id="precio_total" name="precio_total" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_venta">Fecha de la Venta:</label>
                                <input type="date" id="fecha_venta" name="fecha_venta" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Crear Venta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sección Consultar Ventas -->
        <div class="section" id="consultSection">
            <h2>Consultar Ventas</h2>
            <div class="search-bar">
                <input type="text" id="search" placeholder="Buscar por ID o Nombre...">
            </div>
            <div class="sales-list" id="salesList">
                <div class="sale-card" data-id="VENTA-001" data-name="Juan Pérez">
                    <h3>Venta ID: VENTA-001</h3>
                    <p><strong>Cliente:</strong> Juan Pérez (V-12345678)</p>
                    <p><strong>Producto:</strong> Pantalones Jeans Azul Oscuro</p>
                    <p><strong>Cantidad:</strong> 5 unidades</p>
                    <p><strong>Precio Total:</strong> $150.00</p>
                    <p><strong>Fecha:</strong> 2023-10-15</p>
                </div>
                <div class="sale-card" data-id="VENTA-002" data-name="María López">
                    <h3>Venta ID: VENTA-002</h3>
                    <p><strong>Cliente:</strong> María López (J-87654321)</p>
                    <p><strong>Producto:</strong> Pantalones Cargo Verde</p>
                    <p><strong>Cantidad:</strong> 3 unidades</p>
                    <p><strong>Precio Total:</strong> $120.00</p>
                    <p><strong>Fecha:</strong> 2023-10-16</p>
                </div>
                <!-- Agrega más tarjetas según necesites -->
            </div>
            <div class="no-results" id="noResults" style="display: none;">No se encontraron ventas que coincidan con la búsqueda.</div>
        </div>
    </div>

    <script>
        // JavaScript para funcionalidad de búsqueda (el modal se maneja con Bootstrap)
        const searchInput = document.getElementById('search');
        const salesList = document.getElementById('salesList');
        const saleCards = document.querySelectorAll('.sale-card');
        const noResults = document.getElementById('noResults');

        // Función de búsqueda
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();
            let hasResults = false;

            saleCards.forEach(card => {
                const id = card.getAttribute('data-id').toLowerCase();
                const name = card.getAttribute('data-name').toLowerCase();
                if (id.includes(query) || name.includes(query)) {
                    card.style.display = 'block';
                    hasResults = true;
                } else {
                    card.style.display = 'none';
                }
            });

            noResults.style.display = hasResults ? 'none' : 'block';
        });
    </script>
</body>
</html>

<?php echo $this->endSection(); ?>
