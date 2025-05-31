<?php 
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('conn/conexion.php');
$MiConexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'identificador' => isset($_GET['identificador']) ? strip_tags(trim($_GET['identificador'])) : '',
    'nombre' => isset($_GET['nombre']) ? strip_tags(trim($_GET['nombre'])) : '',
    'apellido' => isset($_GET['apellido']) ? strip_tags(trim($_GET['apellido'])) : '',
    'cuil' => isset($_GET['cuil']) ? strip_tags(trim($_GET['cuil'])) : '',
    'nacimientodesde' => isset($_GET['nacimientodesde']) ? strip_tags(trim($_GET['nacimientodesde'])) : '',
    'nacimientohasta' => isset($_GET['nacimientohasta']) ? strip_tags(trim($_GET['nacimientohasta'])) : '',
    'estadocivil' => isset($_GET['estadocivil']) ? strip_tags(trim($_GET['estadocivil'])) : '',

    'ingresodesde' => isset($_GET['ingresodesde']) ? strip_tags(trim($_GET['ingresodesde'])) : '',
    'ingresohasta' => isset($_GET['ingresohasta']) ? strip_tags(trim($_GET['ingresohasta'])) : '',
    'tipocontrato' => isset($_GET['tipocontrato']) ? strip_tags(trim($_GET['tipocontrato'])) : '',
    'puesto' => isset($_GET['puesto']) ? strip_tags(trim($_GET['puesto'])) : '',
    'estadocontrato' => isset($_GET['estadocontrato']) ? strip_tags(trim($_GET['estadocontrato'])) : '',
    'obrasocial' => isset($_GET['obrasocial']) ? strip_tags(trim($_GET['obrasocial'])) : '',
    'banco' => isset($_GET['banco']) ? strip_tags(trim($_GET['banco'])) : '',
    'cbu' => isset($_GET['cbu']) ? strip_tags(trim($_GET['cbu'])) : '',

    'email' => isset($_GET['email']) ? strip_tags(trim($_GET['email'])) : '',
    'telefono' => isset($_GET['telefono']) ? strip_tags(trim($_GET['telefono'])) : '',
    'direccion' => isset($_GET['direccion']) ? strip_tags(trim($_GET['direccion'])) : '',
    'localidad' => isset($_GET['localidad']) ? strip_tags(trim($_GET['localidad'])) : '',
];

// Generar consulta filtrada
include('funciones/ListarEmpleados.php');
$ListadoEmpleados = Listar_Empleados($MiConexion, $filtros);
$CantidadEmpleados = count($ListadoEmpleados);


// SELECCIONES para dropdown lists
require_once 'funciones/listar_dropdownlists.php';

$ListadoTiposDeContratos = Listar_TiposContratos($MiConexion);
$CantidadTiposContratos = count($ListadoTiposDeContratos);

$ListadoPuestos = Listar_Puestos($MiConexion);
$CantidadPuestos = count($ListadoPuestos);

$ListadoEstadosContratos = Listar_EstadosContratos($MiConexion);
$CantidadEstadosContratos = count($ListadoEstadosContratos);


include('head.php');
?>

<body style="background-color:rgb(68, 54, 47);">
    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">
        
        <?php 
        include('sidebarGOp.php');
        $tituloPagina = "EMPLEADOS";
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
            <h4 class="mb-5" style="color:rgb(175, 33, 8);"><strong>Filtrar Empleados</strong></h4>

            <!-- Formulario de filtro -->
            <form action="empleados.php" method="GET" onsubmit="scrollToTable()">

                <div class="row">
                    <p class="btn no-btn-effect" style="background-color: rgb(171, 142, 14); color: black; margin-left: 20px; width: 85%;">
                        DATOS PERSONALES
                    </p>
                </div>

                <div class="row" style="padding-top: 20px;">
                    <div class="col-md-2">
                        <label for="identificador" class="form-label" style="color: white !important;">Legajo</label>
                        <input type="number" min="1" step="1" class="form-control" id="identificador" name="identificador" 
                            value="<?= htmlspecialchars($filtros['identificador']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="nombre" class="form-label" style="color: white !important;">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                            value="<?= htmlspecialchars($filtros['nombre']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="apellido" class="form-label" style="color: white !important;">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" 
                            value="<?= htmlspecialchars($filtros['apellido']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="cuil" class="form-label" style="color: white !important;">CUIL</label>
                        <input type="text" class="form-control" id="cuil" name="cuil" 
                            value="<?= htmlspecialchars($filtros['cuil']) ?>">
                    </div>
                </div> 

                <div class="row" style="padding-top: 20px;">
                    <div class="col-md-2">
                        <label for="estadocivil" class="form-label" style="color: white !important;">Estado civil</label>
                        <input type="text" class="form-control" id="estadocivil" name="estadocivil" 
                            value="<?= htmlspecialchars($filtros['estadocivil']) ?>">
                    </div>  

                    <div class="col-md-4" title="Puede elegir un rango temporal, o un límite inferior o superior">
                        <label for="fechanacimiento" class="form-label" style="color: white !important;">
                            Fecha de nacimiento
                        </label>
                        <div class="d-flex">
                            <input type="date" id="nacimientodesde" class="form-control me-2" name="nacimientodesde"
                                value="<?= htmlspecialchars($filtros['nacimientodesde']) ?>">

                            <input type="date" id="nacimientohasta" class="form-control" name="nacimientohasta"
                                value="<?= htmlspecialchars($filtros['nacimientohasta']) ?>">
                        </div>
                    </div>                  
                </div> 

                <div class="row" style="padding-top: 70px;">
                    <p class="btn no-btn-effect" style="background-color: rgb(171, 142, 14); color: black; margin-left: 20px; width: 85%;">
                        DATOS LABORALES
                    </p>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <label for="tipocontrato" class="form-label" style="color: white !important; margin-top: 20px;">
                            Tipo de contrato
                        </label>

                        <select class="form-select form-control" aria-label="Selector" 
                                id="selectortipocontrato" name="tipocontrato">
                            <option value="" selected>Selecciona una opción</option>

                            <?php
                            // Asegurate de que $ListadoTiposDeContratos contiene datos antes de procesarlo
                            if (!empty($ListadoTiposDeContratos)) {
                                
                                $selected = '';
                                for ($i = 0; $i < $CantidadTiposContratos; $i++) { 
                                    // Primero la lógica para verificar qué registro fue seleccionado antes y autocompletar durante recargo de página
                                    $selected = (!empty($_GET['tipocontrato']) && $_GET['tipocontrato'] == $ListadoTiposDeContratos[$i]['id']) ? 'selected' : '';
                                    // luego las opciones
                                    echo "<option value='{$ListadoTiposDeContratos[$i]['id']}' $selected> {$ListadoTiposDeContratos[$i]['descripcion']} </option>";
                                }
                            } 
                            else {
                                echo "<option value=''>No se encontraron tipos de contratos registrados</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="puesto" class="form-label" style="color: white !important; margin-top: 20px;">
                            Puesto
                        </label>

                        <select class="form-select form-control" aria-label="Selector" 
                                id="selectorpuesto" name="puesto">
                            <option value="" selected>Selecciona una opción</option>

                            <?php
                            // Asegurate de que $ListadoPuestos contiene datos antes de procesarlo
                            if (!empty($ListadoPuestos)) {
                                
                                $selected = '';
                                for ($i = 0; $i < $CantidadPuestos; $i++) { 
                                    // Primero la lógica para verificar qué registro fue seleccionado antes y autocompletar durante recargo de página
                                    $selected = (!empty($_GET['puesto']) && $_GET['puesto'] == $ListadoPuestos[$i]['id']) ? 'selected' : '';
                                    // luego las opciones
                                    echo "<option value='{$ListadoPuestos[$i]['id']}' $selected> {$ListadoPuestos[$i]['descripcion']} </option>";
                                }
                            } 
                            else {
                                echo "<option value=''>No se encontraron puestos en la base de datos</option>";
                            }
                            ?>
                        </select>
                    </div> 

                    <div class="col-md-3">
                        <label for="estadocontrato" class="form-label" style="color: white !important; margin-top: 20px;">
                            Estado del contrato
                        </label>

                        <select class="form-select form-control" aria-label="Selector" 
                                id="selectorestadocontrato" name="estadocontrato">
                            <option value="" selected>Selecciona una opción</option>

                            <?php
                            // Asegurate de que $ListadoEstadosContratos contiene datos antes de procesarlo
                            if (!empty($ListadoEstadosContratos)) {
                                
                                $selected = '';
                                for ($i = 0; $i < $CantidadEstadosContratos; $i++) { 
                                    // Primero la lógica para verificar qué registro fue seleccionado antes y autocompletar durante recargo de página
                                    $selected = (!empty($_GET['estadocontrato']) && $_GET['estadocontrato'] == $ListadoEstadosContratos[$i]['id']) ? 'selected' : '';
                                    // luego las opciones
                                    echo "<option value='{$ListadoEstadosContratos[$i]['id']}' $selected> {$ListadoEstadosContratos[$i]['estado']} </option>";
                                }
                            } 
                            else {
                                echo "<option value=''>No se encontraron estados registrados en la base de datos</option>";
                            }
                            ?>
                        </select>
                    </div> 
                </div> 

                <div class="row" style="padding-top: 20px;">

                    <div class="col-md-2">
                        <label for="obrasocial" class="form-label" style="color: white !important;">Obra social</label>
                        <input type="text" class="form-control" id="obrasocial" name="obrasocial" 
                            value="<?= htmlspecialchars($filtros['obrasocial']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="banco" class="form-label" style="color: white !important;">Banco</label>
                        <input type="text" class="form-control" id="banco" name="banco" 
                            value="<?= htmlspecialchars($filtros['banco']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="cbu" class="form-label" style="color: white !important;">CBU</label>
                        <input type="text" class="form-control" id="cbu" name="cbu" 
                            value="<?= htmlspecialchars($filtros['cbu']) ?>">
                    </div>
                </div> 

                <div class="row" style="padding-top: 20px;">
                    <div class="col-md-4" title="Puede elegir un rango temporal, o un límite inferior o superior">
                        <label for="fechaingreso" class="form-label" style="color: white !important;">
                            Fecha de ingreso
                        </label>
                        <div class="d-flex">
                            <input type="date" id="ingresodesde" class="form-control me-2" name="ingresodesde"
                                value="<?= htmlspecialchars($filtros['ingresodesde']) ?>">

                            <input type="date" id="ingresohasta" class="form-control" name="ingresohasta"
                                value="<?= htmlspecialchars($filtros['ingresohasta']) ?>">
                        </div>
                    </div>
                </div> 

                <div class="row" style="padding-top: 70px;">
                    <p class="btn no-btn-effect" style="background-color: rgb(171, 142, 14); color: black; margin-left: 20px; width: 85%;">
                        INFORMACIÓN DE CONTACTO
                    </p>
                </div>

                <div class="row" style="padding-top: 20px;">
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
                    <a href="empleados.php" class="btn btn-filtrar" style="background-color: rgb(175, 33, 8); color: white;">
                        Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>

        <!-- Botones del listado -->
        <div class="d-flex justify-content-between" style="margin-left: 2%; margin-right: 2%; margin-top: 8%;">
            
            <button class="btn btn-filtrar" style="background-color: rgb(175, 33, 8); color: white;" 
                    data-bs-toggle="modal" data-bs-target="#nuevoEmpleadoModal">
                <i class="fas fa-plus-circle"></i> Nuevo empleado
            </button>
            <div>
                <button class="btn btn-warning btn-filtrar" id="btnModificar" onclick="modificarEmpleado()" disabled>
                    Modificar Empleado
                </button>
                <button class="btn btn-warning btn-filtrar" style="margin-left: 20px;" id="btnEliminar" onclick="eliminarEmpleado()" disabled>
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </div>
        </div>
        
        <!-- Sección de Listado Empleados -->
        <div id="tablaEmpleadosContenedor" class="table-responsive p-4 mb-4 border border-secondary rounded bg-white shadow-sm" 
             style="max-width: 97%; max-height: 700px; margin-left: 2%; margin-right: 2%; margin-top: 3%;">
            <h5 class="mb-4" style="color:rgb(175, 33, 8);"><strong>Listado de Empleados</strong></h5><br>
            <table class="table table-hover" id="tablaEmpleados" >
                <thead>
                    <tr>
                        <th style='color: #bd399e;'><h3>N</h3></th>
                        <th>Puesto</th>
                        <th>Tipo de Contrato</th>
                        <th>Estado del Contrato</th>
                        <th>Nombre</th>
                        <th>Legajo</th>
                        <th>Datos Personales</th>
                        <th>Obra social</th>
                        <th>Banco</th>
                        <th>Fecha Ingreso</th>
                        <th>Contacto</th>
                        <th>Residencia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = "1";
                    
                    for ($i = 0; $i < $CantidadEmpleados; $i++) {

                        $estadoContrato = $ListadoEmpleados[$i]['ecEstado'];
                        $clase = '';

                        switch ($estadoContrato) {
                            case 'Activo':
                                $clase = 'primary'; // azul
                                break;
                            case 'Licencia':
                                $clase = 'success'; // verde
                                break;
                            case 'Baja voluntaria':
                                $clase = 'danger'; // rojo
                                break;
                            case 'Despido con causa':
                                $clase = 'danger'; // rojo
                                break;
                            case 'Despido sin causa':
                                $clase = 'danger'; // rojo
                                break;
                            case 'Suspendido':
                                $clase = 'warning'; // naranja
                                break;
                            case 'Jubilado':
                                $clase = 'secondary'; // púrpura
                                break;
                            case 'Fallecido':
                                $clase = 'secondary'; // púrpura
                                break;
                            case 'Vencido':
                                $clase = 'info'; // celeste
                                break;
                            case 'Reubicado':
                                $clase = 'info'; // celeste
                                break;
                            default:
                                $clase = 'info'; // celeste
                                break;
                        }

                        echo "<tr class='empleado' data-id='" . $ListadoEmpleados[$i]['idEmpleado'] . "'>

                            <td><span style='color: #bd399e;'><h3>" . $contador . "</h3></span></td>

                            <td title='Puesto'>" . $ListadoEmpleados[$i]['cDescripcion'] . "</td>

                            <td title='Tipo de contrato'>" . $ListadoEmpleados[$i]['tcDescripcion'] . "</td>

                            <td title='Estado del Contrato'> <span class='badge badge-$clase'>" . $estadoContrato . "</span> </td>

                            <td>" . $ListadoEmpleados[$i]['apellidoEmpleado'] . " " . $ListadoEmpleados[$i]['nombreEmpleado'] . "</td>

                            <td title='Número identificador del empleado en la empresa'>" . $ListadoEmpleados[$i]['idEmpleado'] . "</td>

                            <td title='Datos personales'> <b>CUIL</b>: " . $ListadoEmpleados[$i]['cuilEmpleado'] . "<br><br> <b>Estado civil:</b> " . $ListadoEmpleados[$i]['estadocivil'] . "<br><br> <b>Nacimiento:</b> " . $ListadoEmpleados[$i]['fechanacimiento'] . "</td>

                            <td title='Obra social'>" . $ListadoEmpleados[$i]['obrasocial'] . "</td>

                            <td title='Información bancaria'> <b>Banco:</b> " . $ListadoEmpleados[$i]['banco'] . "<br><br> <b>CBU:</b> " . $ListadoEmpleados[$i]['cbu'] . "</td>

                            <td title='Fecha de ingreso a la compañía'>" . $ListadoEmpleados[$i]['fechaingreso'] . "</td>

                            <td title='Contacto'> <b>Correo:</b> " . $ListadoEmpleados[$i]['mail'] . "<br><br> <b>Tel:</b> " . $ListadoEmpleados[$i]['telefono'] . "</td>

                            <td title='Residencia'> <b>Dirección:</b> " . $ListadoEmpleados[$i]['direccion'] . "<br><br> <b>Localidad:</b> " . $ListadoEmpleados[$i]['localidad'] . "</td>

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
            Total de registros encontrados: <?php echo $CantidadEmpleados; ?>
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

        <!-- Modal para Nuevo Empleado -->
        <div class="modal fade" id="nuevoEmpleadoModal" 
             tabindex="-1" aria-labelledby="nuevoEmpleadoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoEmpleadoModalLabel">Agregar Nuevo Empleado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form action="nuevo-empleado.php" method="POST">
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="cuil-modal" class="form-label" style="color: white !important;">
                                    CUIL
                                </label>
                                <input type="number" step="1"
                                        title="Solo se admite CUIL con 7 a 12 dígitos"
                                        class="form-control" id="cuil-modal" name="Cuil" required>
                            </div>

                            <div class="mb-3">
                                <label for="nombre-modal" class="form-label" style="color: white !important;">
                                    Nombre
                                </label>
                                <input type="text" class="form-control" id="nombre-modal" name="Nombre" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="apellido-modal" class="form-label" style="color: white !important;">
                                    Apellido
                                </label>
                                <input type="text" class="form-control" id="apellido-modal" name="Apellido" required>
                            </div>

                            <div class="mb-3">
                                <label for="fechanacimiento-modal" class="form-label" style="color: white !important;">
                                    Fecha de Nacimiento
                                </label>
                                <input type="date" class="form-control" id="fechanacimiento-modal" name="FechaNacimiento" required>
                            </div>

                            <div class="mb-3">
                                <label for="estadocivil-modal" class="form-label" style="color: white !important;">
                                    Estado Civil
                                </label>
                                <input type="text" class="form-control" id="estadocivil-modal" name="EstadoCivil" required>
                            </div>

                            <div class="mb-3">
                                <label for="fechaingreso-modal" class="form-label" style="color: white !important;">
                                    Fecha de Ingreso
                                </label>
                                <input type="date" class="form-control" id="fechaingreso-modal" name="FechaIngreso" required>
                            </div>

                            <div>
                                <label for="tipocontrato-modal" class="form-label" style="color: white !important; margin-top: 20px;">
                                    Tipo de contrato
                                </label>

                                <select class="form-select form-control" aria-label="Selector" 
                                        id="tipocontrato-modal" name="tipocontrato" required>
                                    <option value="" selected>Selecciona una opción</option>

                                    <?php
                                    // Asegurate de que $ListadoTiposDeContratos contiene datos antes de procesarlo
                                    if (!empty($ListadoTiposDeContratos)) {
                                        
                                        $selected = '';
                                        for ($i = 0; $i < $CantidadTiposContratos; $i++) { 
                                            // Primero la lógica para verificar qué registro fue seleccionado antes y autocompletar durante recargo de página
                                            $selected = (!empty($_POST['tipocontrato']) && $_POST['tipocontrato'] == $ListadoTiposDeContratos[$i]['id']) ? 'selected' : '';
                                            // luego las opciones
                                            echo "<option value='{$ListadoTiposDeContratos[$i]['id']}' $selected> {$ListadoTiposDeContratos[$i]['descripcion']} </option>";
                                        }
                                    } 
                                    else {
                                        echo "<option value=''>No se encontraron tipos de contratos registrados</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div>
                                <label for="puesto-modal" class="form-label" style="color: white !important; margin-top: 20px;">
                                    Puesto
                                </label>

                                <select class="form-select form-control" aria-label="Selector" 
                                        id="puesto-modal" name="puesto" required>
                                    <option value="" selected>Selecciona una opción</option>

                                    <?php
                                    // Asegurate de que $ListadoPuestos contiene datos antes de procesarlo
                                    if (!empty($ListadoPuestos)) {
                                        
                                        $selected = '';
                                        for ($i = 0; $i < $CantidadPuestos; $i++) { 
                                            // Primero la lógica para verificar qué registro fue seleccionado antes y autocompletar durante recargo de página
                                            $selected = (!empty($_POST['puesto']) && $_POST['puesto'] == $ListadoPuestos[$i]['id']) ? 'selected' : '';
                                            // luego las opciones
                                            echo "<option value='{$ListadoPuestos[$i]['id']}' $selected> {$ListadoPuestos[$i]['descripcion']} </option>";
                                        }
                                    } 
                                    else {
                                        echo "<option value=''>No se encontraron puestos en la base de datos</option>";
                                    }
                                    ?>
                                </select>
                            </div> 

                            <div>
                                <label for="estadocontrato-modal" class="form-label" style="color: white !important; margin-top: 20px;">
                                    Estado del contrato
                                </label>

                                <select class="form-select form-control" aria-label="Selector" 
                                        id="estadocontrato-modal" name="estadocontrato" required>
                                    <option value="" selected>Selecciona una opción</option>

                                    <?php
                                    // Asegurate de que $ListadoEstadosContratos contiene datos antes de procesarlo
                                    if (!empty($ListadoEstadosContratos)) {
                                        
                                        $selected = '';
                                        for ($i = 0; $i < $CantidadEstadosContratos; $i++) { 
                                            // Primero la lógica para verificar qué registro fue seleccionado antes y autocompletar durante recargo de página
                                            $selected = (!empty($_POST['estadocontrato']) && $_POST['estadocontrato'] == $ListadoEstadosContratos[$i]['id']) ? 'selected' : '';
                                            // luego las opciones
                                            echo "<option value='{$ListadoEstadosContratos[$i]['id']}' $selected> {$ListadoEstadosContratos[$i]['estado']} </option>";
                                        }
                                    } 
                                    else {
                                        echo "<option value=''>No se encontraron estados registrados en la base de datos</option>";
                                    }
                                    ?>
                                </select>
                            </div> <br><br>

                            <div class="mb-3">
                                <label for="obrasocial-modal" class="form-label" style="color: white !important;">
                                    Obra Social
                                </label>
                                <input type="text" class="form-control" id="obrasocial-modal" name="ObraSocial" required>
                            </div>

                            <div class="mb-3">
                                <label for="banco-modal" class="form-label" style="color: white !important;">
                                    Banco
                                </label>
                                <input type="text" class="form-control" id="banco-modal" name="Banco" required>
                            </div>

                            <div class="mb-3">
                                <label for="cbu-modal" class="form-label" style="color: white !important;">
                                    CBU
                                </label>
                                <input type="text" class="form-control" id="cbu-modal" name="Cbu" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email-modal" class="form-label" style="color: white !important;">
                                    Email
                                </label>
                                <input type="email" class="form-control" id="email-modal" name="Email" required>
                            </div>

                            <div class="mb-3">
                                <label for="telefono-modal" class="form-label" style="color: white !important;">
                                    Teléfono
                                </label>
                                <input type="number" step="1" 
                                        title="Solo se admiten números telefónicos con 8 a 12 dígitos" 
                                        class="form-control" id="telefono-modal" name="Telefono" required>
                            </div>

                            <div class="mb-3">
                                <label for="direccion-modal" class="form-label" style="color: white !important;">
                                    Dirección
                                </label>
                                <input type="text" class="form-control" id="direccion-modal" name="Direccion" required>
                            </div>

                            <div class="mb-3">
                                <label for="localidad-modal" class="form-label" style="color: white !important;">
                                    Localidad
                                </label>
                                <input type="text" class="form-control" id="localidad-modal" name="Localidad" required>
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
                    document.getElementById('tablaEmpleadosContenedor').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    localStorage.removeItem('scrollToTable'); // Limpiar indicador después del scroll
                }, 500); 
            }
        });

        // Selección de cliente al hacer clic en una fila
        let empleadoSeleccionado = null;

        document.querySelectorAll('#tablaEmpleados .empleado').forEach(row => {
            row.addEventListener('click', () => {
                // Desmarcar cualquier fila previamente seleccionada
                document.querySelectorAll('.empleado').forEach(row => row.classList.remove('table-active'));
                // Marcar la fila seleccionada
                row.classList.add('table-active');
                empleadoSeleccionado = row.dataset.id;
                // Habilitar los botones
                document.getElementById('btnModificar').disabled = false;
                document.getElementById('btnEliminar').disabled = false;
            });
        });

        // Función para redirigir a modificar-empleado.php con el ID del cliente seleccionado
        
        function modificarEmpleado() {
            if (empleadoSeleccionado) {
                window.location.href = 'modificar-empleado.php?id=' + empleadoSeleccionado;
            }
        }
        

        // Función para redirigir a eliminar-empleado.php con el ID del cliente seleccionado
        function eliminarEmpleado() {
            if (empleadoSeleccionado) {
                if (confirm('¿Estás seguro de que quieres eliminar este empleado?')) {
                    window.location.href = 'eliminar-empleado.php?id=' + empleadoSeleccionado;
                }
            }
        }

    </script>
    
    <script>

        // SELECT2 para los controles tipo "select" con listas dropdown, tanto en el form de filtros como en el modal para el registro de un nuevo empleado

        $(document).ready(function () {
            let selectores = [
                { id: '#selectortipocontrato', modal: false },
                { id: '#selectorpuesto', modal: false },
                { id: '#selectorestadocontrato', modal: false },
                { id: '#selectortipocontratomodal', modal: true },
                { id: '#selectorpuestomodal', modal: true },
                { id: '#selectorestadocontratomodal', modal: true }
            ];

            selectores.forEach(selector => {
                $(selector.id).select2({
                    dropdownParent: selector.modal ? $('#nuevoEmpleadoModal') : null,
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
