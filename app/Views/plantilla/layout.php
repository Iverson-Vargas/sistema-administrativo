<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets\css\bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/layout.css'); ?>">

</head>

<body>

    <div class="menu-superior">
        <p>Logo</p>

        <nav id="busqueda" class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </nav>

        <div class="menu-superior-derecha">
            <div>
                <!-- aqui va un Icono -->
                <p>Configuraciones</p>
            </div>
            <div>
                <!-- aqui va un Icono -->
                <p>Icono usuario</p>
            </div>
        </div>
    </div>

    <div class="menu-lateral">
        <ul>
            <li>
                <!--Aqui va un Icono -->
                <a href="<?= base_url('/home'); ?>">Home</a>
            </li>
            <li>
                <!--Aqui va un Icono -->
                <a href="<?= base_url('/ventas'); ?>">Ventas</a>
            </li>
            <li>
                <!--Aqui va un Icono -->
                <a href="<?= base_url('/produccion'); ?>">Produccion</a>
            </li>
            <li>
                <!--Aqui va un Icono -->
                <a href="<?= base_url('/reportes'); ?>">Reportes</a>
            </li>
        </ul>
    </div>

    <main class="contenido">
        <?php echo $this->renderSection('contenido'); ?>
    </main>




    <?php echo $this->renderSection('scripts'); ?>

    <script src="assets\js\bootstrap.bundle.min.js"></script>

</body>

</html>