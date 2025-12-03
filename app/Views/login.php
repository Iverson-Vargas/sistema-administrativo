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
                    id="usuario"
                    placeholder="Usuario" required />
                <label for="usuario">Usuario</label>
            </div>
            <div class="form-floating">
                <input
                    type="password"
                    class="form-control"
                    id="contrasena"
                    placeholder="Contraseña" required />
                <label for="contrasena">Contraseña</label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="button" onclick="validarLogin()">
                Iniciar Sesión 
            </button>
            <p class="text-center mt-5 mb-3 text-body-secondary">&copy; IF COMPANY 2025</p>
        </form>
    </main>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>

        function validarLogin() {
            const loginUrl = "<?= base_url('validarDatos') ?>";
            const usuario = document.getElementById('usuario').value
            const contrasena = document.getElementById('contrasena').value


            fetch(loginUrl, {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        usuario: usuario,
                        contrasena: contrasena,
                    })
                })
                .then(response => response.json())
                .then(respuesta => {
                    if (respuesta.success) {
                        window.location.href = '<?= base_url('/home'); ?>';
                    } else {
                        alert(respuesta.mensaje);
                    }
                });
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