<?php

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

if (isset($_GET['id'])) {
    $idEmpleado = $_GET['id'];

    // Recolecto datos del empleado en función del id pasado por URL, para el formulario 
    $consulta = "SELECT * FROM empleados 
                 WHERE id = ?";

    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("i", $idEmpleado);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $empleado = $resultado->fetch_assoc();
} 
else {
    // Si no se pasa un ID, redirigir al listado
    header('Location: empleados.php');
    exit();
}

// SELECCIONES para dropdown lists
require_once 'funciones/listar_dropdownlists.php';

$ListadoTiposDeContratos = Listar_TiposContratos($MiConexion);
$CantidadTiposContratos = count($ListadoTiposDeContratos);

$ListadoPuestos = Listar_Puestos($MiConexion);
$CantidadPuestos = count($ListadoPuestos);

$ListadoEstadosContratos = Listar_EstadosContratos($MiConexion);
$CantidadEstadosContratos = count($ListadoEstadosContratos);


// Capturo los datos del formulario debajo para realizar el Update 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = strip_tags(trim($_POST['nombre']));
    $apellido = strip_tags(trim($_POST['apellido']));
    $cuil = strip_tags(trim($_POST['cuil']));
    $estadocivil = strip_tags(trim($_POST['estadocivil']));    
    $obrasocial = strip_tags(trim($_POST['obrasocial']));
    $banco = strip_tags(trim($_POST['banco']));
    $cbu = strip_tags(trim($_POST['cbu']));
    $email = strip_tags(trim($_POST['email']));
    $telefono = strip_tags(trim($_POST['telefono']));
    $direccion = strip_tags(trim($_POST['direccion']));
    $localidad = strip_tags(trim($_POST['localidad']));

    $idTipoContrato = $_POST['tipocontrato'];
    $idPuesto = $_POST['puesto'];
    $idEstadoContrato = $_POST['estadocontrato'];

    $fechanacimiento = $_POST['fechanacimiento'];
    $fechaingreso = $_POST['fechaingreso'];


    // Validaciones básicas
    $errores = [];

    if (empty($cuil) || !is_numeric($cuil) || $cuil < 1000000  || $cuil > 999999999999) {
        $errores[] = "El CUIL es obligatorio y debe presentar entre 7 y 12 digitos.";
    }
    if (empty($nombre) || strlen($nombre) >= 50) {
        $errores[] = "El nombre es obligatorio y no debe presentar más de 50 caracteres.";
    }
    if (empty($apellido) || strlen($apellido) >= 50) {
        $errores[] = "El apellido es obligatorio y no debe presentar más de 50 caracteres.";
    }
    if (empty($estadocivil) || strlen($estadocivil) >= 20) {
        $errores[] = "El estado civil es obligatorio y no debe presentar más de 20 caracteres.";
    }
    if (empty($obrasocial) || strlen($obrasocial) >= 50) {
        $errores[] = "La obra social es obligatoria y no debe presentar más de 50 caracteres. Si el empleado carece de ella, especifique 'Ninguna'.";
    }
    if (empty($banco) || strlen($banco) >= 50) {
        $errores[] = "El banco es obligatorio y no debe presentar más de 20 caracteres. Si el empleado carece, especifique 'Ninguno'.";
    }
    if (empty($cbu) || strlen($cbu) >= 50) {
        $errores[] = "El CBU bancario es obligatorio y no debe presentar más de 50 caracteres. Si el empleado carece, especifique 'Ninguno'.";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido.";
    }
    if (strlen($email) >= 50) {
        $errores[] = "El email no puede presentar más de 50 caracteres.";
    }
    if (empty($telefono) || !preg_match('/^[0-9]{8,12}$/', $telefono)) {
        $errores[] = "El teléfono debe contener entre 8 y 12 dígitos.";
    }
    if (empty($direccion) || strlen($direccion) >= 50) {
        $errores[] = "La dirección es obligatoria y no puede presentar más de 50 caracteres.";
    }
    if (empty($localidad) || strlen($localidad) >= 50) {
        $errores[] = "La localidad es obligatoria y no puede presentar más de 50 caracteres.";
    }

    if (empty($fechanacimiento)) {
        $errores[] = "La fecha de nacimiento es obligatoria.";
    }
    else {
        $fechanacimiento = date("Y-m-d", strtotime($fechanacimiento)); 
    }

    if (empty($fechaingreso)) {
        $errores[] = "La fecha de ingreso es obligatoria.";
    }
    else {
        $fechaingreso = date("Y-m-d", strtotime($fechaingreso)); 
    }

    if ($fechaingreso <= $fechanacimiento) {
        $errores[] = "La fecha de ingreso no puede ser anterior a la fecha de nacimiento.";
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'empleados.php';
        </script>";
        exit();
    }


    // Actualizar los datos del empleado
    $consulta = "UPDATE empleados 
                SET nombreEmpleado = ?, 
                    apellidoEmpleado = ?, 
                    cuilEmpleado = ?,
                    fechaNacimiento = ?,
                    estadoCivil = ?,
                    fechaIngreso = ?,
                    idTipoContrato = ?,
                    idCargo = ?,
                    idEstadoContrato = ?,
                    obrasocial = ?,
                    banco = ?,
                    cbu = ?, 
                    mailEmpleado = ?, 
                    telEmpleado = ?, 
                    direccionEmpleado = ?,
                    localidadEmpleado = ?  
                WHERE id = ? ";

    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("ssssssiiissssissi", $nombre, $apellido, $cuil, $fechanacimiento, $estadocivil, $fechaingreso, $idTipoContrato, $idPuesto, $idEstadoContrato, $obrasocial, $banco, $cbu, $email, $telefono, $direccion, $localidad, $idEmpleado);
    $stmt->execute();

    // Redirigir después de la actualización
    $mensaje = "Usted ha modificado exitosamente el empleado de Legajo = {$idEmpleado}. ¡Vamos a verlo!";
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'empleados.php?identificador={$idEmpleado}&nombre=&apellido=&cuil=&estadocivil=&nacimientodesde=&nacimientohasta=&tipocontrato=&puesto=&estadocontrato=&obrasocial=&banco=&cbu=&ingresodesde=&ingresohasta=&email=&telefono=&direccion=&localidad=';
    </script>";
    exit();
}

?>

<body style="background-color:rgb(68, 54, 47);">
    <div style="min-height: 100%">
        <div class="wrapper">

            <?php 
            include('sidebarGOp.php'); 
            include('topNavBar.php'); 
            ?>
            
            <div class="p-5 mb-4 shadow-sm" 
                 style="margin-top: 10%; margin-left: 1%; max-width: 98%; border: 1px solid #444444; border-radius: 14px; background-color: #262626;">

                <h3 class="mb-4" style="color:rgb(175, 33, 8); Font-Family: Arial;">MODIFICAR EMPLEADO</h3><br>

                <!-- Formulario para modificar el empleado -->
                <form method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label" style="color: white !important;">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                value="<?php echo htmlspecialchars($empleado['nombreEmpleado']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellido" class="form-label" style="color: white !important;">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" 
                                value="<?php echo htmlspecialchars($empleado['apellidoEmpleado']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="cuil" class="form-label" style="color: white !important;">CUIL</label>
                        <input type="number" step="1" title="Solo se admite CUIL con 7 a 12 dígitos" 
                                class="form-control" id="cuil" name="cuil" 
                                value="<?php echo htmlspecialchars($empleado['cuilEmpleado']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="fechanacimiento" class="form-label" style="color: white !important;">Fecha de nacimiento</label>
                        <input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" 
                                value="<?php echo htmlspecialchars($empleado['fechaNacimiento']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="estadocivil" class="form-label" style="color: white !important;">Estado Civil</label>
                        <input type="text" class="form-control" id="estadocivil" name="estadocivil" 
                                value="<?php echo htmlspecialchars($empleado['estadoCivil']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="fechaingreso" class="form-label" style="color: white !important;">Fecha de ingreso</label>
                        <input type="date" class="form-control" id="fechaingreso" name="fechaingreso" 
                                value="<?php echo htmlspecialchars($empleado['fechaIngreso']); ?>" required>
                    </div>

                    <div class="col-md-3">
                        <label for="tipocontrato" class="form-label" style="color: white !important; margin-top: 20px;">
                            Tipo de contrato
                        </label>

                        <select class="form-select form-control" aria-label="Selector" 
                                id="tipocontrato" name="tipocontrato" required>
                            <option value="">Selecciona una opción</option>

                            <?php
                            // Asegurate de que $ListadoTiposDeContratos contiene datos antes de procesarlo
                            if (!empty($ListadoTiposDeContratos)) {
                                
                                $selected = '';
                                for ($i = 0; $i < $CantidadTiposContratos; $i++) { 
                                    // Primero la lógica para verificar qué opción pertenece al empleado y autocompletar durante recargo de página
                                    $selected = (!empty($empleado['idTipoContrato']) && $empleado['idTipoContrato'] == $ListadoTiposDeContratos[$i]['id']) ? 'selected' : '';
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
                                id="puesto" name="puesto">
                            <option value="">Selecciona una opción</option>

                            <?php
                            if (!empty($ListadoPuestos)) {
                                
                                $selected = '';
                                for ($i = 0; $i < $CantidadPuestos; $i++) { 

                                    $selected = (!empty($empleado['idCargo']) && $empleado['idCargo'] == $ListadoPuestos[$i]['id']) ? 'selected' : '';
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
                                id="estadocontrato" name="estadocontrato">
                            <option value="" selected>Selecciona una opción</option>

                            <?php
                            if (!empty($ListadoEstadosContratos)) {
                                
                                $selected = '';
                                for ($i = 0; $i < $CantidadEstadosContratos; $i++) { 

                                    $selected = (!empty($empleado['idEstadoContrato']) && $empleado['idEstadoContrato'] == $ListadoEstadosContratos[$i]['id']) ? 'selected' : '';
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

                    <div class="mb-3">
                        <label for="obrasocial" class="form-label" style="color: white !important; margin-top: 40px;">
                            Obra social
                        </label>
                        <input type="text" class="form-control" id="obrasocial" name="obrasocial" 
                                value="<?php echo htmlspecialchars($empleado['obrasocial']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="banco" class="form-label" style="color: white !important;">
                            Banco
                        </label>
                        <input type="text" class="form-control" id="banco" name="banco" 
                                value="<?php echo htmlspecialchars($empleado['banco']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="cbu" class="form-label" style="color: white !important;">
                            CBU
                        </label>
                        <input type="text" class="form-control" id="cbu" name="cbu" 
                                value="<?php echo htmlspecialchars($empleado['cbu']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: white !important;">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                                value="<?php echo htmlspecialchars($empleado['mailEmpleado']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label" style="color: white !important;">Teléfono</label>
                        <input type="number" step="1" title="Solo se admiten números telefónicos con 8 a 12 dígitos" 
                                class="form-control" id="telefono" name="telefono" 
                                value="<?php echo htmlspecialchars($empleado['telEmpleado']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label" style="color: white !important;">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" 
                                value="<?php echo htmlspecialchars($empleado['direccionEmpleado']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="localidad" class="form-label" style="color: white !important;">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad" 
                                value="<?php echo htmlspecialchars($empleado['localidadEmpleado']); ?>" required>
                    </div>

                    <br><br>
                    <button type="submit" class="btn" style="background-color: rgb(175, 33, 8); color: white;">
                        Guardar Cambios
                    </button>
                </form>
            </div>

            <div style="margin-top: 100px;">
                <?php require_once "foot.php"; ?>
            </div>

        </div>
    </div>
</body>
</html>