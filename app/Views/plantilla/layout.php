<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets\css\bootstrap.min.css">
    <style>
        body {
            margin: 0;
            display: grid;
            grid-template-columns: 15% repeat(2, 1fr);
            grid-template-rows: 60px 1fr 30px;
            grid-template-areas:
                "menuSuperior menuSuperior menuSuperior"
                "menuLateral contenido contenido"
                "menuLateral contenido contenido";
            min-height: 100vh;
        }

        .menu-superior {
            grid-area: menuSuperior;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);

        }

        #busqueda {
            justify-self: center;
            align-self: center;
        }

        .menu-superior-derecha {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: auto; /* Empuja este grupo a la derecha */
        }



        .menu-lateral {
            grid-area: menuLateral;
            background-color: #162456;
            color: white;
            padding: 20px;
            height: 100%;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .menu-lateral ul {
            color: white;
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .menu-lateral ul li a {
            color: white;
            text-decoration: none;
            font-size: 25px;
        }


        .contenido {
            grid-area: contenido;
        }

        
    </style>


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