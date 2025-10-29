<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/layout.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">

</head>

<body>

    <div class="menu-superior">
        <img src="<?php echo base_url('assets/img/logo2.jpg')?>" alt="logo empresa" width="50" height="50">

        <div class="dropdown">
            <button id="btn-usuario" class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Usuario
            </button>
            <ul class="dropdown-menu">
                <li><button class="dropdown-item" type="button" onclick="cerrarSeccion()">Cerrar Sección</button></li>
            </ul>
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

    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        function cerrarSeccion() {
            window.location.href = "<?php echo base_url('/'); ?>"; 
        }
    </script>
</body>

</html>