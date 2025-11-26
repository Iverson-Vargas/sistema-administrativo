<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

    <div class="container mt-4">
        <h2>Generar Venta</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="cliente" class="form-label">Cliente:</label>
                <input type="text" class="form-control" id="cliente" name="cliente" required>
            </div>
            <div class="mb-3">
                <label for="producto" class="form-label">Producto:</label>
                <select class="form-select" id="producto" name="producto" required>
                    <option value="">Seleccione un producto</option>
                    <option value="Producto 1">Producto 1</option>
                    <option value="Producto 2">Producto 2</option>
                    <option value="Producto 3">Producto 3</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad:</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <button type="submit" class="btn btn-primary">Generar Venta</button>
        </form>
    </div>


<?php echo $this->endSection(); ?>