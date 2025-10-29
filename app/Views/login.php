<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">
    
    <title>Login - Sistema de Producción y Ventas de Pantalones</title>

</head>
<body>
    <div class="system-title">Sistema de Producción y Ventas de Pantalones</div>
    <div class="login-container">
        <h2>INICIAR SESIÓN</h2>
        <form action="/login" method="post"> <!-- Ajusta la acción según tu backend -->
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" placeholder="Usuario o Correo" >
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Contraseña" >
            <button type="button" onclick="redirigirAlHome()">Entrar</button>
        </form>
    </div>

    <script>
        function redirigirAlHome() {
            window.location.href = "<?php echo base_url('home'); ?>"; 
        }
    </script>
</body>
</html>
