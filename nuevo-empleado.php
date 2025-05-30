<?php
session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cuil = trim(strip_tags($_POST['Cuil']));
    $nombre = trim(strip_tags($_POST['Nombre']));
    $apellido = trim(strip_tags($_POST['Apellido']));
    $estadocivil = trim(strip_tags($_POST['EstadoCivil']));
    $obrasocial = trim(strip_tags($_POST['ObraSocial']));
    $banco = trim(strip_tags($_POST['Banco']));
    $cbu = trim(strip_tags($_POST['Cbu']));
    $email = trim(strip_tags($_POST['Email']));
    $telefono = trim(strip_tags($_POST['Telefono']));
    $direccion = trim(strip_tags($_POST['Direccion']));
    $localidad = trim(strip_tags($_POST['Localidad']));

    $fechanacimiento = $_POST['FechaNacimiento'];
    $fechaingreso = $_POST['FechaIngreso'];

    $idTipoContrato = $_POST['tipocontrato'];
    $idPuesto = $_POST['puesto'];
    $idEstadoContrato = $_POST['estadocontrato'];

    // Para que los empleados figuren en el listado, baja = "N"
    $baja = "N";

    // Validaciones básicas
    $errores = [];

    if (empty($cuil) || !is_numeric($cuil) || $cuil < 1000000  || $cuil > 999999999999) {
        $errores[] = "Solo se admite un CUIL con 7 a 12 digitos.";
    }
    if (empty($nombre) || strlen($nombre) >= 50) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($apellido) || strlen($apellido) >= 50) {
        $errores[] = "El apellido es obligatorio.";
    }
    if (empty($estadocivil) || strlen($estadocivil) >= 20) {
        $errores[] = "El estado civil es obligatorio y no debe superar los 20 caracteres.";
    }
    if (empty($obrasocial) || strlen($obrasocial) >= 50) {
        $errores[] = "La obra social es obligatoria y no debe superar los 50 caracteres. Si el empleado carece de ella, especifique 'Ninguna'.";
    }
    if (empty($banco) || strlen($banco) >= 50) {
        $errores[] = "El banco es obligatorio y no debe superar los 20 caracteres. Si el empleado carece, especifique 'Ninguno'.";
    }
    if (empty($cbu) || strlen($cbu) >= 50) {
        $errores[] = "El CBU bancario es obligatorio y no debe superar los 50 caracteres. Si el empleado carece, especifique 'Ninguno'.";
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
        $errores[] = "La dirección es obligatoria.";
    }
    if (empty($localidad) || strlen($localidad) >= 50) {
        $errores[] = "La localidad es obligatoria.";
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

    // Conexión y consulta
    $MiConexion = ConexionBD();

    $query = "INSERT INTO empleados 
                                (nombreEmpleado, 
                                apellidoEmpleado, 
                                cuilEmpleado, 
                                fechaNacimiento, 
                                estadoCivil, 
                                fechaIngreso, 
                                idTipoContrato,
                                idCargo, 
                                idEstadoContrato,
                                obrasocial,
                                banco,
                                cbu,
                                mailEmpleado,
                                telEmpleado,
                                direccionEmpleado,
                                localidadEmpleado, 
                                bajaEmpleado) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $MiConexion->prepare($query);

    // Vinculamos los valores en el orden correcto
    $stmt->bind_param("ssssssiiissssisss", $nombre, $apellido, $cuil, $fechanacimiento, $estadocivil, $fechaingreso, $idTipoContrato, $idPuesto, $idEstadoContrato, $obrasocial, $banco, $cbu, $email, $telefono, $direccion, $localidad, $baja);

    if ($stmt->execute()) {

        // Obtener el ID del nuevo empleado
        $idEmpleado = $stmt->insert_id;
        
        $mensaje = "Empleado agregado exitosamente. Identificador (ID) asignado: {$idEmpleado}. ¡Vayamos a verlo!";
    } 
    else {

        $mensaje = "Error al agregar empleado: " . $MiConexion->error;
    }

    $stmt->close();
    $MiConexion->close();

    // Redirigir con un mensaje
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'empleados.php?identificador={$idEmpleado}&nombre=&apellido=&cuil=&estadocivil=&nacimientodesde=&nacimientohasta=&tipocontrato=&puesto=&estadocontrato=&obrasocial=&banco=&cbu=&ingresodesde=&ingresohasta=&email=&telefono=&direccion=&localidad=';
        </script>";
    exit();
}

?>