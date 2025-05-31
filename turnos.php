<?php 
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('conn/conexion.php');
$MiConexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [

    'idCliente' => isset($_GET['cliente']) ? strip_tags(trim($_GET['cliente'])) : '',
    'idEmpleado' => isset($_GET['empleado']) ? strip_tags(trim($_GET['empleado'])) : '',
    'identificador' => isset($_GET['identificador']) ? strip_tags(trim($_GET['identificador'])) : '',
    'servicio' => isset($_GET['servicio']) ? strip_tags(trim($_GET['servicio'])) : '',
    'fechadesde' => isset($_GET['fechadesde']) ? strip_tags(trim($_GET['fechadesde'])) : '',
    'fechahasta' => isset($_GET['fechahasta']) ? strip_tags(trim($_GET['fechahasta'])) : '',
];

// Generar consulta filtrada

include('funciones/ListarTurnos.php');
$ListadoTurnos = Listar_Turnos($MiConexion, $filtros);
$CantidadTurnos = count($ListadoTurnos);


// SELECCIONES para dropdown lists

require_once 'funciones/ListarEmpleados.php';
$ListadoEmpleados = Listar_Empleados($MiConexion, $filtros);
$CantidadEmpleados = count($ListadoEmpleados);

require_once 'funciones/ListarClientes.php';
$ListadoClientes = Listar_Clientes($MiConexion, $filtros);
$CantidadClientes = count($ListadoClientes);



include('head.php');
?>

<body style="background-color:rgb(68, 54, 47);">
    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">
        
        <?php 
        include('sidebarGOp.php');
        $tituloPagina = "TURNOS";
        include('topNavBar.php');

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }
        ?>

        <!-- Algunos efectos modernos para el form de consultas ;) -->
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
            <h4 class="mb-5" style="color:rgb(175, 33, 8);"><strong>Filtrar Turnos</strong></h4>

            <!-- Formulario de filtro -->
            <form action="turnos.php" method="GET" onsubmit="scrollToTable()">

                <div class="row">
                    <p class="btn no-btn-effect" style="background-color: rgb(171, 142, 14); color: black; margin-left: 20px; width: 85%;">
                        CLIENTE
                    </p>
                </div>

                <div class="row" style="padding-top: 20px;">

                    <div class="col-md-3">
                        <label for="cliente" class="form-label" style="color: white !important; margin-top: 5px;">
                            Seleccione un cliente
                        </label>

                        <select class="form-select form-control" aria-label="Selector" 
                                id="selectorcliente" name="cliente">
                            <option value="" selected>Selecciona una opción</option>

                            <?php
                            // Asegurate de que $ListadoClientes contiene datos antes de procesarlo
                            if (!empty($ListadoClientes)) {
                                
                                $selected = '';
                                for ($i = 0; $i < $CantidadClientes; $i++) { 
                                    // Primero la lógica para verificar qué registro fue seleccionado antes y autocompletar durante recargo de página
                                    $selected = (!empty($_GET['cliente']) && $_GET['cliente'] == $ListadoClientes[$i]['id']) ? 'selected' : '';
                                    // luego las opciones
                                    echo "<option value='{$ListadoClientes[$i]['id']}' $selected> {$ListadoClientes[$i]['apellido']} {$ListadoClientes[$i]['nombre']} </option>";
                                }
                            } 
                            else {
                                echo "<option value=''>No se encontraron clientes registrados</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row" style="padding-top: 70px;">
                    <p class="btn no-btn-effect" style="background-color: rgb(171, 142, 14); color: black; margin-left: 20px; width: 85%;">
                        EMPLEADO
                    </p>
                </div>

                <div class="row" style="padding-top: 20px;">

                    <div class="col-md-3">
                        <label for="empleado" class="form-label" style="color: white !important; margin-top: 5px;">
                            Seleccione un empleado
                        </label>

                        <select class="form-select form-control" aria-label="Selector" 
                                id="selectorempleado" name="empleado">
                            <option value="" selected>Selecciona una opción</option>

                            <?php
                            // Asegurate de que $ListadoEmpleados contiene datos antes de procesarlo
                            if (!empty($ListadoEmpleados)) {
                                
                                $selected = '';
                                for ($i = 0; $i < $CantidadEmpleados; $i++) { 
                                    // Primero la lógica para verificar qué registro fue seleccionado antes y autocompletar durante recargo de página
                                    $selected = (!empty($_GET['empleado']) && $_GET['empleado'] == $ListadoEmpleados[$i]['idEmpleado']) ? 'selected' : '';
                                    // luego las opciones
                                    echo "<option value='{$ListadoEmpleados[$i]['idEmpleado']}' $selected> {$ListadoEmpleados[$i]['apellidoEmpleado']} {$ListadoEmpleados[$i]['nombreEmpleado']} </option>";
                                }
                            } 
                            else {
                                echo "<option value=''>No se encontraron empleados registrados</option>";
                            }
                            ?>
                        </select>
                    </div>

                </div>

                <div class="row" style="padding-top: 70px;">
                    <p class="btn no-btn-effect" style="background-color: rgb(171, 142, 14); color: black; margin-left: 20px; width: 85%;">
                        INFORMACIÓN DEL TURNO
                    </p>
                </div>

                <div class="row" style="padding-top: 20px;">

                    <div class="col-md-2">
                        <label for="identificador" class="form-label" style="color: white !important;">ID</label>
                        <input type="number" min="1" step="1" class="form-control" id="identificador" name="identificador" 
                            value="<?= htmlspecialchars($filtros['identificador']) ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="servicio" class="form-label" style="color: white !important;">Servicio</label>
                        <input type="text" class="form-control" id="servicio" name="servicio" 
                            value="<?= htmlspecialchars($filtros['servicio']) ?>">
                    </div>

                    <div class="col-md-4" title="Puede elegir un rango temporal, o un límite inferior o superior">
                        <label for="fechaturno" class="form-label" style="color: white !important;">
                            Fecha del turno
                        </label>
                        <div class="d-flex">
                            <input type="date" id="fechadesde" class="form-control me-2" name="fechadesde"
                                value="<?= htmlspecialchars($filtros['fechadesde']) ?>">

                            <input type="date" id="fechahasta" class="form-control" name="fechahasta"
                                value="<?= htmlspecialchars($filtros['fechahasta']) ?>">
                        </div>
                    </div>

                </div> 

                <div class="mt-3" style="padding-top: 80px; padding-bottom: 50px;">
                    <button type="submit" class="btn btn-filtrar" style="background-color: rgb(175, 33, 8); color: white; margin-right: 20px;">
                        <i class="fas fa-search"></i> Consultar
                    </button>
                    <a href="turnos.php" class="btn btn-filtrar" style="background-color: rgb(175, 33, 8); color: white;">
                        Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>

        <!-- Botones del listado -->
        <div class="d-flex justify-content-between" style="margin-left: 2%; margin-right: 2%; margin-top: 8%;">
            
            <button class="btn btn-filtrar" style="background-color: rgb(175, 33, 8); color: white;" 
                    data-bs-toggle="modal" data-bs-target="#nuevoTurnoModal">
                <i class="fas fa-plus-circle"></i> Nuevo turno
            </button>
            <div>
                <button class="btn btn-warning btn-filtrar" id="btnModificar" onclick="modificarTurno()" disabled>
                    Modificar turno
                </button>
                <button class="btn btn-warning btn-filtrar" style="margin-left: 20px;" id="btnEliminar" onclick="eliminarTurno()" disabled>
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </div>
        </div>
        
        <!-- Sección de Listado Turnos -->
        <div id="tablaTurnosContenedor" class="table-responsive p-4 mb-4 border border-secondary rounded bg-white shadow-sm" 
             style="max-width: 97%; max-height: 700px; margin-left: 2%; margin-right: 2%; margin-top: 3%;">
            <h5 class="mb-4" style="color:rgb(175, 33, 8);"><strong>Listado de Turnos</strong></h5><br>
            <table class="table table-hover" id="tablaTurnos" >
                <thead>
                    <tr>
                        <th style='color: #bd399e;'><h3>N</h3></th>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Empleado</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = "1";
                    
                    for ($i = 0; $i < $CantidadTurnos; $i++) {

                        echo "<tr class='turno' data-id='" . $ListadoTurnos[$i]['idTurno'] . "'>

                            <td><span style='color: #bd399e;'><h3>" . $contador . "</h3></span></td>

                            <td title='Identificador del turno'>" . $ListadoTurnos[$i]['idTurno'] . "</td>

                            <td title='Fecha del turno'>" . $ListadoTurnos[$i]['fechaTurno'] . "</td>

                            <td title='Hora del turno'>" . $ListadoTurnos[$i]['horaTurno'] . "</td>

                            <td title='Empleado responsable'> <span class='badge badge-success'>" . $ListadoTurnos[$i]['apellidoEmpleado'] . " " . $ListadoTurnos[$i]['nombreEmpleado'] . "</span> </td>

                            <td title='Cliente a atender'>" . $ListadoTurnos[$i]['apellidoCliente'] . " " . $ListadoTurnos[$i]['nombreCliente'] . "<br><br> <a href='clientes.php?identificador={$ListadoTurnos[$i]['tIdCliente']}&documento=&nombre=&apellido=&email=&telefono=&direccion=&localidad='> <span class='badge badge-info'><b>ID:</b> " . $ListadoTurnos[$i]['tIdCliente'] . "</span></a> </td>

                            <td title='Servicio'>" . $ListadoTurnos[$i]['servicioTurno'] . "</td>

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
            Total de registros encontrados: <?php echo $CantidadTurnos; ?>
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

        <!-- 
        <div class="text-center mt-4">  
            <a href="impresion-ListadoClientes.php"> <button class="btn btn-print">🖨️ Imprimir Listado PDF</button></a>
        </div>
        -->


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

        <!-- Modal para Nuevo Turno -->
        <div class="modal fade" id="nuevoTurnoModal" 
             tabindex="-1" aria-labelledby="nuevoTurnoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoTurnoModalLabel">Agregar Nuevo Turno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form action="nuevo-turno.php" method="POST">
                        <div class="modal-body">

                            <div class="col-md-3">
                                <label for="cliente" class="form-label" style="color: white !important; margin-top: 5px;">
                                    Seleccione un cliente
                                </label>

                                <select class="form-select form-control" aria-label="Selector" 
                                        id="selectorcliente" name="cliente" required>
                                    <option value="" selected>Selecciona una opción</option>

                                    <?php
                                    // Asegurate de que $ListadoClientes contiene datos antes de procesarlo
                                    if (!empty($ListadoClientes)) {
                                        
                                        $selected = '';
                                        for ($i = 0; $i < $CantidadClientes; $i++) { 
                                            // Primero la lógica para verificar qué registro fue seleccionado antes y autocompletar durante recargo de página
                                            $selected = (!empty($_GET['cliente']) && $_GET['cliente'] == $ListadoClientes[$i]['id']) ? 'selected' : '';
                                            // luego las opciones
                                            echo "<option value='{$ListadoClientes[$i]['id']}' $selected> {$ListadoClientes[$i]['apellido']} {$ListadoClientes[$i]['nombre']} </option>";
                                        }
                                    } 
                                    else {
                                        echo "<option value=''>No se encontraron clientes registrados</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3" style ="margin-top: 30px;">
                                <label for="fechaturno" class="form-label" style="color: white !important;">
                                    Fecha del Turno
                                </label>
                                <input type="date" class="form-control" id="fechaturno" name="fechaturno" required>
                            </div>

                            <div class="mb-3">
                                <label for="horaturno" class="form-label" style="color: white !important;">
                                    Hora del Turno
                                </label>
                                <input type="time" class="form-control" id="horaturno" name="horaturno" required>
                            </div>

                            <div class="col-md-3">
                                <label for="empleado" class="form-label" style="color: white !important; margin-top: 5px;">
                                    Seleccione un empleado
                                </label>

                                <select class="form-select form-control" aria-label="Selector" 
                                        id="selectorempleado" name="empleado" required>
                                    <option value="" selected>Selecciona una opción</option>

                                    <?php
                                    // Asegurate de que $ListadoEmpleados contiene datos antes de procesarlo
                                    if (!empty($ListadoEmpleados)) {
                                        
                                        $selected = '';
                                        for ($i = 0; $i < $CantidadEmpleados; $i++) { 
                                            // Primero la lógica para verificar qué registro fue seleccionado antes y autocompletar durante recargo de página
                                            $selected = (!empty($_GET['empleado']) && $_GET['empleado'] == $ListadoEmpleados[$i]['idEmpleado']) ? 'selected' : '';
                                            // luego las opciones
                                            echo "<option value='{$ListadoEmpleados[$i]['idEmpleado']}' $selected> {$ListadoEmpleados[$i]['apellidoEmpleado']} {$ListadoEmpleados[$i]['nombreEmpleado']} </option>";
                                        }
                                    } 
                                    else {
                                        echo "<option value=''>No se encontraron empleados registrados</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3" style ="margin-top: 30px;">
                                <label for="servicio" class="form-label" style="color: white !important;">
                                    Servicio
                                </label>
                                <input type="text" maxlength="199" class="form-control" id="servicio" name="servicio" required>
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
                    document.getElementById('tablaTurnosContenedor').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    localStorage.removeItem('scrollToTable'); // Limpiar indicador después del scroll
                }, 500); 
            }
        });

        // Selección de cliente al hacer clic en una fila
        let turnoSeleccionado = null;

        document.querySelectorAll('#tablaTurnos .turno').forEach(row => {
            row.addEventListener('click', () => {
                // Desmarcar cualquier fila previamente seleccionada
                document.querySelectorAll('.turno').forEach(row => row.classList.remove('table-active'));
                // Marcar la fila seleccionada
                row.classList.add('table-active');
                turnoSeleccionado = row.dataset.id;
                // Habilitar los botones
                document.getElementById('btnModificar').disabled = false;
                document.getElementById('btnEliminar').disabled = false;
            });
        });

        // Función para redirigir a modificar-turno.php con el ID del cliente seleccionado
        
        /*
        function modificarTurno() {
            if (turnoSeleccionado) {
                window.location.href = 'modificar-turno.php?id=' + turnoSeleccionado;
            }
        }
        */

        // Función para redirigir a eliminar-turno.php con el ID del cliente seleccionado
        function eliminarTurno() {
            if (turnoSeleccionado) {
                if (confirm('¿Estás seguro de que quieres eliminar este turno?')) {
                    window.location.href = 'eliminar-turno.php?id=' + turnoSeleccionado;
                }
            }
        }

    </script>
    
    <script>

        // SELECT2 para los controles tipo "select" con listas dropdown, tanto en el form de filtros como en el modal para el registro de un nuevo empleado

        $(document).ready(function () {
            let selectores = [
                { id: '#selectorcliente', modal: false },
                { id: '#selectorempleado', modal: false },
                { id: '#selectortipocontratomodal', modal: true },
                { id: '#selectorpuestomodal', modal: true },
                { id: '#selectorestadocontratomodal', modal: true }
            ];

            selectores.forEach(selector => {
                $(selector.id).select2({
                    dropdownParent: selector.modal ? $('#nuevoTurnoModal') : null,
                    width: '100%',
                    minimumResultsForSearch: 0
                });
            });
        });

    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Librería SELECT2 para agregar buscador a dropdown lists -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>
</html>
