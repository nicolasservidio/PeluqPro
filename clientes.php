<?php 
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('conn/conexion.php');
$MiConexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'documento' => isset($_GET['documento']) ? strip_tags(trim($_GET['documento'])) : '',
    'nombre' => isset($_GET['nombre']) ? strip_tags(trim($_GET['nombre'])) : '',
    'apellido' => isset($_GET['apellido']) ? strip_tags(trim($_GET['apellido'])) : '',
    'email' => isset($_GET['email']) ? strip_tags(trim($_GET['email'])) : '',
    'telefono' => isset($_GET['telefono']) ? strip_tags(trim($_GET['telefono'])) : '',
    'direccion' => isset($_GET['direccion']) ? strip_tags(trim($_GET['direccion'])) : '',
    'localidad' => isset($_GET['localidad']) ? strip_tags(trim($_GET['localidad'])) : '',
    'identificador' => isset($_GET['identificador']) ? strip_tags(trim($_GET['identificador'])) : '',
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

        <!-- Algunos efectos moderno para el form de consultas ;) -->
        <style>

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .filtro-clientes {
                transition: all 0.4s ease-in-out; 
                border-radius: 15px; 
                background-color:rgb(19, 4, 2); 
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); 
                margin-left: 2%; 
                margin-right: 2%; 
                margin-top: 15%;
                animation: fadeInUp 0.8s ease-in-out; /* Hace que el cuadro "aparezca suavemente" */
            }

            .filtro-clientes:hover {
                transform: translateY(-5px); 
                box-shadow: 0px 10px 20px rgba(198, 167, 31, 0.5);
            }

            .form-control {
                transition: all 0.3s ease-in-out;
                border: 4px solid transparent;
            }

            .form-control:focus {
                border: 4px solid rgb(198, 167, 31); /* Resalta con dorado */
                box-shadow: 0px 0px 10px rgba(198, 167, 31, 0.6);
            }

            .btn-filtrar {
                transition: transform 0.3s ease-in-out;
            }

            .btn-filtrar:hover {
                transform: scale(1.1); /* Botón se agranda ligeramente */
            }
        </style>

        <div class="p-4 mb-4 shadow-sm filtro-clientes"> 
            <h4 class="mb-5" style="color:rgb(175, 33, 8);"><strong>Filtrar Clientes</strong></h4>

            <!-- Formulario de filtro -->
            <form action="clientes.php" method="GET" onsubmit="scrollToTable()">
            
                <div class="row">
                    <div class="col-md-2">
                        <label for="identificador" class="form-label" style="color: white !important;">ID</label>
                        <input type="number" min="1" step="1" class="form-control" id="identificador" name="identificador" 
                            value="<?= htmlspecialchars($filtros['identificador']) ?>">
                    </div>
                    <div class="col-md-3">
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
                </div> 

                <div class="row" style="padding-top: 40px;">
                    <div class="col-md-3">
                        <label for="email" class="form-label" style="color: white !important;">Email</label>
                        <input type="text" class="form-control" id="email" name="email" 
                            value="<?= htmlspecialchars($filtros['email']) ?>">
                    </div>
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
                    <button type="submit" class="btn btn-filtrar" style="background-color: rgb(175, 33, 8); color: white; margin-right: 20px;">
                        <i class="fas fa-search"></i> Consultar
                    </button>
                    <a href="clientes.php" class="btn btn-filtrar" style="background-color: rgb(175, 33, 8); color: white;">
                        Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between" style="margin-left: 2%; margin-right: 2%; margin-top: 8%;">
            
            <button class="btn btn-filtrar" style="background-color: rgb(175, 33, 8); color: white;" 
                    data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">
                <i class="fas fa-plus-circle"></i> Nuevo cliente
            </button>
            <div>
                <button class="btn btn-warning btn-filtrar" id="btnModificar" onclick="modificarCliente()" disabled>
                    Modificar Cliente
                </button>
                <button class="btn btn-warning btn-filtrar" style="margin-left: 20px;" id="btnEliminar" onclick="eliminarCliente()" disabled>
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </div>
        </div>
        
        <!-- Sección de Listado Clientes -->
        <div id="tablaClientesContenedor" class="table-responsive p-4 mb-4 border border-secondary rounded bg-white shadow-sm" 
             style="max-width: 97%; max-height: 700px; margin-left: 2%; margin-right: 2%; margin-top: 3%;">
            <h5 class="mb-4" style="color:rgb(175, 33, 8);"><strong>Listado Clientes</strong></h5><br>
            <table class="table table-hover" id="tablaClientes" >
                <thead>
                    <tr>
                        <th style='color: #bd399e;'><h3>N</h3></th>
                        <th>ID cliente</th>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Localidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = "1";

                    for ($i = 0; $i < $CantidadClientes; $i++) {
                        echo "<tr class='cliente' data-id='" . $ListadoClientes[$i]['id'] . "'>
                            <td><span style='color: #bd399e;'><h3>" . $contador . "</h3></span></td>
                            <td title='Número identificador del cliente en la empresa'>" . $ListadoClientes[$i]['id'] . "</td>
                            <td>" . $ListadoClientes[$i]['documento'] . "</td>
                            <td>" . $ListadoClientes[$i]['nombre'] . "</td>
                            <td>" . $ListadoClientes[$i]['apellido'] . "</td>
                            <td>" . $ListadoClientes[$i]['email'] . "</td>
                            <td>" . $ListadoClientes[$i]['telefono'] . "</td>
                            <td>" . $ListadoClientes[$i]['direccion'] . "</td>
                            <td>" . $ListadoClientes[$i]['localidad'] . "</td>
                        </tr>";
                        $contador++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Recuadro con cantidad total de registros encontrados -->
        <style>
            .no-btn-effect {
                pointer-events: none; /* Evita que se comporte como un botón */
                box-shadow: none !important; 
                cursor: default !important; /* Hace que el cursor no cambie */
                border: none; 
            }
        </style>
        <p class="btn no-btn-effect" style="background-color: white; color: black; margin-left: 25px;">
            Total de registros encontrados: <?php echo $CantidadClientes; ?>
        </p>

        <!-- IMPRESIÓN DEL LISTADO -->

        <style>
            .btn-print {
                background-color: #FF7300; /* Naranja fuerte */
                color: white;
                font-size: 18px;
                font-weight: bold;
                margin: 50px 0 30px;
                padding: 12px 24px;
                border-radius: 8px;
                transition: all 0.3s ease-in-out;
                border: none;
                cursor: pointer;
            }

            .btn-print:hover {
                background-color: #D96000; /* Oscurece al pasar el mouse */
                transform: scale(1.1); /* Efecto de agrandamiento */
            }
        </style>

        <div class="text-center mt-4">  
            <a href="impresion-ListadoClientes.php"> <button class="btn btn-print">🖨️ Imprimir Listado PDF</button></a>
        </div>


        <!-- Estilo para el modal de registro de Nuevo Cliente -->
        <style>
            .modal-custom {
                background-color: #262626; /* Color oscuro fondo */ 
                color: white; /* Texto blanco para mayor contraste */
                border-radius: 10px;
            }
            .modal-header {
                background-color: rgb(175, 33, 8); /* Mantiene el color del resto de la página */
            }
            .modal-footer {
                background-color: #2C211B;
            }
            .modal-backdrop {
                backdrop-filter: blur(10px); /* Aplica el efecto borroso */
                background-color: rgba(0, 0, 0, 0.3) !important; /* Oscurece un poco el fondo */
            }
        </style>

        <!-- Modal para Nuevo Cliente -->
        <div class="modal fade" id="nuevoClienteModal" 
             tabindex="-1" aria-labelledby="nuevoClienteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoClienteModalLabel">Agregar Nuevo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form action="nuevo-cliente.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="documento" class="form-label" style="color: white !important;">
                                    Documento
                                </label>
                                <input type="number" step="1"
                                        title="Solo se admiten documentos con 7 a 12 dígitos"
                                        class="form-control" id="documento" name="Documento" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label" style="color: white !important;">
                                    Nombre
                                </label>
                                <input type="text" class="form-control" id="nombre" name="Nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label" style="color: white !important;">
                                    Apellido
                                </label>
                                <input type="text" class="form-control" id="apellido" name="Apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label" style="color: white !important;">
                                    Email
                                </label>
                                <input type="email" class="form-control" id="email" name="Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label" style="color: white !important;">
                                    Teléfono
                                </label>
                                <input type="number" step="1" 
                                        title="Solo se admiten números telefónicos con 8 a 12 dígitos" 
                                        class="form-control" id="telefono" name="Telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label" style="color: white !important;">
                                    Dirección
                                </label>
                                <input type="text" class="form-control" id="direccion" name="Direccion" required>
                            </div>
                            <div class="mb-3">
                                <label for="localidad" class="form-label" style="color: white !important;">
                                    Localidad
                                </label>
                                <input type="text" class="form-control" id="localidad" name="Localidad" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                                Cerrar
                            </button>
                            <button type="submit" class="btn" style="background-color: rgb(175, 33, 8); color: white;">
                                Guardar
                            </button>
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

        // Desplazamiento vertical al listado luego de consulta
        function scrollToTable() {
            localStorage.setItem('scrollToTable', 'true'); // Guardar indicador antes de enviar
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('scrollToTable') === 'true') {
                setTimeout(() => {
                    document.getElementById('tablaClientesContenedor').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    localStorage.removeItem('scrollToTable'); // Limpiar indicador después del scroll
                }, 500); 
            }
        });

        // Selección de cliente al hacer clic en una fila
        let clienteSeleccionado = null;

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

        // Función para redirigir a modificar-cliente.php con el ID del cliente seleccionado
        function modificarCliente() {
            if (clienteSeleccionado) {
                window.location.href = 'modificar-cliente.php?id=' + clienteSeleccionado;
            }
        }

        // Función para redirigir a eliminar-cliente.php con el ID del cliente seleccionado
        function eliminarCliente() {
            if (clienteSeleccionado) {
                if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
                    window.location.href = 'eliminar-cliente.php?id=' + clienteSeleccionado;
                }
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
