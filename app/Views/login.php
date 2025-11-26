<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">

    <title>Login - Sistema de Producción y Ventas de Pantalones</title>

</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <!--  
    <div class="system-title">Sistema de Producción y Ventas de Pantalones</div>
    <div class="login-container">
        <h2>INICIAR SESIÓN</h2>
        <form action="/login" method="post"> Ajusta la acción según tu backend
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" placeholder="Usuario o Correo" >
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Contraseña" >
            <button type="button" onclick="redirigirAlHome()">Entrar</button>
        </form>
   </div> -->
   
    <main class="form-signin w-100 m-auto">
        <form>
            <div id="logo-if" style="font-family: serifa;" class="text-center mb-4">
                <h1 style="font-size: 70px; padding: 0; margin-bottom: 0; margin-left: 10px; margin-right: 0;">IF</h1>
                <h3 style="font-size: 10px; margin-top: -15px; margin-bottom: 0; margin-left: 0; margin-right: 0;">COMPANY</h3>
            </div>
            <h1 id="iniciar_Sesion_h1" class="h3 mb-3 fw-normal">Iniciar Sesión</h1>
            <div class="form-floating">
                <input
                    type="text"
                    class="form-control"
                    id="input-Usuario"
                    placeholder="Usuario" required />
                <label for="input-Usuario">Usuario</label>
            </div>
            <div class="form-floating">
                <input
                    type="password"
                    class="form-control"
                    id="input-contrasena"
                    placeholder="Contraseña" required />
                <label for="input-contrasena">Contraseña</label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="button" onclick="redirigirAlHome()">
                Iniciar Sesión
            </button>
            <p class="text-center mt-5 mb-3 text-body-secondary">&copy; IF COMPANY 2025</p>
        </form>
    </main>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        function redirigirAlHome() {
            window.location.href = "<?php echo base_url('home'); ?>";
        }

        (() => {
            'use strict'

            const getStoredTheme = () => localStorage.getItem('theme')
            const setStoredTheme = theme => localStorage.setItem('theme', theme)

            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme()
                if (storedTheme) {
                    return storedTheme
                }

                return 'dark'; // Se establece 'dark' como tema predeterminado
            }

            const setTheme = theme => {
                if (theme === 'auto') {
                    document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'))
                } else {
                    document.documentElement.setAttribute('data-bs-theme', theme)
                }
            }

            setTheme(getPreferredTheme())

            const showActiveTheme = (theme, focus = false) => {
                const themeSwitcher = document.querySelector('#bd-theme')

                if (!themeSwitcher) {
                    return
                }

                const themeSwitcherText = document.querySelector('#bd-theme-text')
                const activeThemeIcon = document.querySelector('.theme-icon-active use')
                const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
                const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')

                document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                    element.classList.remove('active')
                    element.setAttribute('aria-pressed', 'false')
                })

                btnToActive.classList.add('active')
                btnToActive.setAttribute('aria-pressed', 'true')
                activeThemeIcon.setAttribute('href', svgOfActiveBtn)
                themeSwitcherText.textContent = `(${btnToActive.dataset.bsThemeValue})`

                if (focus) {
                    themeSwitcher.focus()
                }
            }

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const storedTheme = getStoredTheme()
                if (storedTheme !== 'light' && storedTheme !== 'dark') {
                    setTheme(getPreferredTheme())
                }
            })

            window.addEventListener('DOMContentLoaded', () => {
                showActiveTheme(getPreferredTheme())

                document.querySelectorAll('[data-bs-theme-value]')
                    .forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const theme = toggle.getAttribute('data-bs-theme-value')
                            setStoredTheme(theme)
                            setTheme(theme)
                            showActiveTheme(theme, true)
                        })
                    })
            })
        })()
    </script>
</body>

</html>