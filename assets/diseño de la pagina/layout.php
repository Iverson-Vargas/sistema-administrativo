<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/layout.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/dataTables.dataTables.min.css'); ?>">

</head>

<body>
  <script src="<?php echo base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/dataTables.min.js'); ?>"></script>
  
  <!-- Menú superior -->
  <div class="menu-superior d-flex justify-content-between align-items-center p-2 bg-light border-bottom">
    <img src="<?php echo base_url('assets/img/logo2.jpg'); ?>" alt="logo empresa" width="50" height="50">

    <div class="dropdown">
      <button class="btn dropdown-toggle text-white" type="button" id="dropdownUsuario" data-bs-toggle="dropdown" aria-expanded="false"
        style="background-color: #162456; border: none;">
        Usuario
      </button>


      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUsuario">
        <li>
          <button class="dropdown-item" type="button" onclick="abrirConfiguracionSistema()">
            <i class="bi bi-gear"></i> Configuración del Sistema
          </button>
        </li>
        <li>
          <button class="dropdown-item" type="button" onclick="cerrarSeccion()">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sección
          </button>
        </li>
      </ul>
    </div>
  </div>
  
  <!-- Menú lateral -->
  <div class="menu-lateral">
    <ul>
      <li><i class="bi bi-house-door"></i> <a href="<?= base_url('/home'); ?>">Home</a></li>
      <li><i class="bi bi-bag"></i> <a href="<?= base_url('/ventas'); ?>">Ventas</a></li>
      <li><i class="bi bi-arrow-repeat"></i> <a href="<?= base_url('/produccion'); ?>">Producción</a></li>
      <li><i class="bi bi-bar-chart"></i> <a href="<?= base_url('/reportes'); ?>">Reportes</a></li>
    </ul>
  </div>

  <!-- Contenido principal -->
  <main class="contenido">
    <?php echo $this->renderSection('contenido'); ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <?php echo $this->renderSection('scripts'); ?>

  <!-- Modal de Configuración del Sistema -->
  <div class="modal fade" id="modalConfiguracion" tabindex="-1" aria-labelledby="modalConfiguracionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalConfiguracionLabel">Configuración del Sistema</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <!-- Pestañas -->
        <ul class="nav nav-tabs" id="configTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="datos-tab" data-bs-toggle="tab" data-bs-target="#datos" type="button" role="tab">Datos Personales</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="usuarios-tab" data-bs-toggle="tab" data-bs-target="#usuarios" type="button" role="tab">Gestión de Usuarios</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="clave-tab" data-bs-toggle="tab" data-bs-target="#clave" type="button" role="tab">Cambiar Contraseña</button>
          </li>
        </ul>

        <!-- Contenido de pestañas -->
        <div class="container tab-content mt-3" id="configTabsContent">
          <!-- Datos Personales -->
          <div class="tab-pane fade show active" id="datos" role="tabpanel">
            <form>
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" placeholder="Tu nombre">
              </div>
              <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo" placeholder="tuemail@ejemplo.com">
              </div>
              <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="tel" class="form-control" id="telefono" placeholder="+58...">
              </div>
              <button type="submit" class="btn btn-success">Actualizar Datos</button>
            </form>
          </div>

          <!-- Gestión de Usuarios -->
          <div class="tab-pane fade" id="usuarios" role="tabpanel">
            <h6>Usuarios Existentes</h6>
            <ul class="list-group mb-3" id="listaUsuarios">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Usuario1 (Administrador)
                <div>

                  <button class="btn btn-sm btn-danger" onclick="eliminarUsuario('Usuario1')">Eliminar</button>
                </div>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Usuario2 (gerente)
                <div>

                  <button class="btn btn-sm btn-danger" onclick="eliminarUsuario('Usuario2')">Eliminar</button>
                </div>
              </li>
            </ul>

            <h6>Crear Nuevo Usuario</h6>
            <form onsubmit="crearUsuario(event)">
              <div class="mb-2">
                <label for="nuevoUsuario" class="form-label">Nombre de Usuario:</label>
                <input type="text" class="form-control" id="nuevoUsuario" required>
              </div>
              <div class="mb-2">
                <label for="nuevoCorreo" class="form-label">Correo:</label>
                <input type="email" class="form-control" id="nuevoCorreo" required>
              </div>
              <div class="mb-2">
                <label for="nuevoRol" class="form-label">Rol:</label>
                <select class="form-select" id="nuevoRol" required>
                  <option value="Administrador">Administrador</option>
                  <option value="Costurero">gerente</option>
                </select>
              </div>
              <div class="mb-2">
                <label for="permisos" class="form-label">Permisos:</label>
                <textarea class="form-control" id="permisos" placeholder="Home, Ventas, Producción, Reportes"></textarea>
              </div>
              <button type="submit" class="btn btn-success">Crear Usuario</button>
            </form>
          </div>

          <!-- Cambiar Contraseña -->
          <div class="tab-pane fade" id="clave" role="tabpanel">
            <form>
              <div class="mb-3">
                <label for="claveActual" class="form-label">Contraseña Actual:</label>
                <input type="password" class="form-control" id="claveActual" required>
              </div>
              <div class="mb-3">
                <label for="nuevaClave" class="form-label">Nueva Contraseña:</label>
                <input type="password" class="form-control" id="nuevaClave" required>
              </div>
              <div class="mb-3">
                <label for="confirmarClave" class="form-label">Confirmar Nueva Contraseña:</label>
                <input type="password" class="form-control" id="confirmarClave" required>
              </div>
              <button type="submit" class="btn btn-warning">Cambiar Contraseña</button>
            </form>

            <hr>
            <p><strong>Administradores:</strong> Cambiar contraseña de otro usuario</p>
            <select class="form-select mb-2" id="usuarioClaveSelect">
              <option value="">Seleccionar Usuario</option>
              <option value="Usuario1">Usuario1</option>
              <option value="Usuario2">Usuario2</option>
            </select>
            <button class="btn btn-secondary" onclick="cambiarClaveOtro()">Cambiar Contraseña de Usuario</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      function eliminarUsuario(nombre) {
        if (confirm("¿Eliminar usuario " + nombre + "?")) {
          const lista = document.getElementById("listaUsuarios");
          const items = lista.querySelectorAll("li");
          items.forEach(item => {
            if (item.textContent.includes(nombre)) {
              lista.removeChild(item);
            }
          });
        }
      }

      function crearUsuario(event) {
        event.preventDefault();
        const nombre = document.getElementById("nuevoUsuario").value;
        const rol = document.getElementById("nuevoRol").value;
        const lista = document.getElementById("listaUsuarios");
        const li = document.createElement("li");
        li.className = "list-group-item d-flex justify-content-between align-items-center";
        li.innerHTML = `${nombre} (${rol}) <div><button class="btn btn-sm btn-primary me-2" onclick="editarUsuario('${nombre}')">Editar</button><button class="btn btn-sm btn-danger" onclick="eliminarUsuario('${nombre}')">Eliminar</button></div>`;
        lista.appendChild(li);

        document.getElementById("nuevoUsuario").value = "";
        document.getElementById("nuevoCorreo").value = "";
        document.getElementById("nuevoRol").value = "";
        document.getElementById("permisos").value = "";
      }

      function cambiarClaveOtro() {
        const usuario = document.getElementById("usuarioClaveSelect").value;
        if (usuario) {
          alert("Cambiar contraseña de " + usuario);
        } else {
          alert("Selecciona un usuario");
        }
      }
    </script>

    <!-- Scripts Bootstrap y funciones -->
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

    <script>
      function cerrarSeccion() {
        window.location.href = "<?php echo base_url('/'); ?>";
      }

      function abrirConfiguracionSistema() {
        const modal = new bootstrap.Modal(document.getElementById('modalConfiguracion'));
        modal.show();
      }
      </script>
</body>

</html>