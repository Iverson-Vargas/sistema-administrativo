<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    <ul>
        <li>
            <a href="<?= base_url('/home'); ?>">Home</a>
        </li>
        <li>
            <a href="<?= base_url('/ventas'); ?>">Ventas</a>
        </li>
        <li>
            <a href="<?= base_url('/produccion'); ?>">Produccion</a>
        </li>
        <li>
            <a href="<?= base_url('/reportes'); ?>">Reportes</a>
        </li>
    </ul>
    
    <main class="contenido">
        <?php echo $this->renderSection('contenido'); ?>
    </main>



    <?php echo $this->renderSection('scripts'); ?>


</body>

</html>