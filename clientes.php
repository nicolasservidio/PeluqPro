<?php 
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('conn/conexion.php');
$MiConexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'documento' => isset($_GET['documento']) ? trim($_GET['documento']) : '',
    'nombre' => isset($_GET['nombre']) ? trim($_GET['nombre']) : '',
    'apellido' => isset($_GET['apellido']) ? trim($_GET['apellido']) : '',
    'email' => isset($_GET['email']) ? trim($_GET['email']) : '',
    'telefono' => isset($_GET['telefono']) ? trim($_GET['telefono']) : '',
    'direccion' => isset($_GET['direccion']) ? trim($_GET['direccion']) : '',
    'localidad' => isset($_GET['localidad']) ? trim($_GET['localidad']) : '',
];

// Generar consulta filtrada
include('funciones/ListarClientes.php');
$ListadoClientes = Listar_Clientes($MiConexion, $filtros);
$CantidadClientes = count($ListadoClientes);

include('head.php');
?>

<body style="background-color:rgb(68, 54, 47);">
    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">
        
        <?php 
        include('sidebarGOp.php');
        $tituloPagina = "CLIENTES";
        include('topNavBar.php');

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }
        ?>

        <div class="p-4 mb-4 shadow-sm" 
            style="margin-left: 2%; margin-right: 2%; margin-top: 15%; border-radius: 20px; background-color: #000000;"> 
            <h4 class="mb-5" style="color:rgb(175, 33, 8);"><strong>Filtrar Clientes</strong></h4>

            <!-- Formulario de filtro -->
            <form action="clientes.php" method="GET">
                <div class="row">
                    <div class="col-md-2">
                        <label for="documento" class="form-label" style="color: white !important;">Documento</label>
                        <input type="text" class="form-control" id="documento" name="documento" 
                            value="<?= htmlspecialchars($filtros['documento']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="nombre" class="form-label" style="color: white !important;">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                            value="<?= htmlspecialchars($filtros['nombre']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="apellido" class="form-label" style="color: white !important;">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" 
                            value="<?= htmlspecialchars($filtros['apellido']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="email" class="form-label" style="color: white !important;">Email</label>
                        <input type="text" class="form-control" id="email" name="email" 
                            value="<?= htmlspecialchars($filtros['email']) ?>">
                    </div>
                </div> 

                <div class="row" style="padding-top: 20px;">
                    <div class="col-md-2">
                        <label for="telefono" class="form-label" style="color: white !important;">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" 
                            value="<?= htmlspecialchars($filtros['telefono']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="direccion" class="form-label" style="color: white !important;">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" 
                            value="<?= htmlspecialchars($filtros['direccion']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="localidad" class="form-label" style="color: white !important;">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad" 
                            value="<?= htmlspecialchars($filtros['localidad']) ?>">
                    </div>
                </div>

                <div class="mt-3" style="padding-top: 50px; padding-bottom: 50px;">
                    <button type="submit" class="btn" style="background-color: rgb(175, 33, 8); color: white; margin-right: 20px;">
                        Filtrar
                    </button>
                    <a href="clientes.php" class="btn" style="background-color: rgb(175, 33, 8); color: white;">
                        Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between" style="margin-left: 2%; margin-right: 2%; margin-top: 8%;">
            <button class="btn" style="background-color: rgb(175, 33, 8); color: white;" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">
                <i class="fas fa-plus-circle"></i> Nuevo cliente
            </button>
            <div>
                <button class="btn btn-primary" id="btnModificar" onclick="modificarCliente()" disabled>Modificar Cliente</button>
                <button class="btn btn-danger" id="btnEliminar" onclick="eliminarCliente()" disabled>
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </div>
        </div>

        <!-- Sección de Listado Clientes -->
        <div class="table-responsive p-4 mb-4 border border-secondary rounded bg-white shadow-sm" 
             style="max-width: 97%; max-height: 700px; margin-left: 2%; margin-right: 2%; margin-top: 3%;">
            <h5 class="mb-4" style="color:rgb(175, 33, 8);"><strong>Listado Clientes</strong></h5>
            <table class="table table-hover" id="tablaClientes" >
                <thead>
                    <tr>
                        <th style='color: #bd399e;'><h3>N</h3></th>
                        <th>ID Cliente</th>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = "1";

                    for ($i = 0; $i < $CantidadClientes; $i++) {
                        echo "<tr class='cliente' data-id='" . $ListadoClientes[$i]['ID'] . "'>
                            <td><span style='color: #bd399e;'><h3>" . $contador . "</h3></span></td>
                            <td>" . $ListadoClientes[$i]['ID'] . "</td>
                            <td>" . $ListadoClientes[$i]['DOCUMENTO'] . "</td>
                            <td>" . $ListadoClientes[$i]['NOMBRE'] . "</td>
                            <td>" . $ListadoClientes[$i]['APELLIDO'] . "</td>
                            <td>" . $ListadoClientes[$i]['EMAIL'] . "</td>
                            <td>" . $ListadoClientes[$i]['TELEFONO'] . "</td>
                            <td>" . $ListadoClientes[$i]['DIRECCION'] . "</td>
                        </tr>";
                        $contador++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal para Nuevo Cliente -->
        <div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-labelledby="nuevoClienteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoClienteModalLabel">Agregar Nuevo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form action="NuevoCliente.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="documento" class="form-label">Documento</label>
                                <input type="text" class="form-control" id="documento" name="documento" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div style="padding-top: 5%; padding-bottom: 20px;">
            <?php require_once "foot.php"; ?>
        </div>

    </div>

    <script>
        let clienteSeleccionado = null;

        // Selección de cliente al hacer clic en una fila
        document.querySelectorAll('#tablaClientes .cliente').forEach(row => {
            row.addEventListener('click', () => {
                // Desmarcar cualquier fila previamente seleccionada
                document.querySelectorAll('.cliente').forEach(row => row.classList.remove('table-active'));
                // Marcar la fila seleccionada
                row.classList.add('table-active');
                clienteSeleccionado = row.dataset.id;
                // Habilitar los botones
                document.getElementById('btnModificar').disabled = false;
                document.getElementById('btnEliminar').disabled = false;
            });
        });

        // Función para redirigir a ModificarCliente.php con el ID del cliente seleccionado
        function modificarCliente() {
            if (clienteSeleccionado) {
                window.location.href = 'ModificarCliente.php?id=' + clienteSeleccionado;
            }
        }

        // Función para redirigir a EliminarCliente.php con el ID del cliente seleccionado
        function eliminarCliente() {
            if (clienteSeleccionado) {
                if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
                    window.location.href = 'EliminarCliente.php?id=' + clienteSeleccionado;
                }
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
