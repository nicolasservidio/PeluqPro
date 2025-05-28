<?php
session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = strip_tags($_POST['Documento']);
    $documento = trim($documento);
    $nombre = strip_tags($_POST['Nombre']);
    $nombre = trim($nombre);
    $apellido = strip_tags($_POST['Apellido']);
    $apellido = trim($apellido);
    $email = strip_tags($_POST['Email']);
    $email = trim($email);
    $telefono = strip_tags($_POST['Telefono']);
    $telefono = trim($telefono);
    $direccion = strip_tags($_POST['Direccion']);
    $direccion = trim($direccion);
    $localidad = strip_tags($_POST['Localidad']);
    $localidad = trim($localidad);

    // Para que los clientes figuren en el listado baja = "N"
    $baja = "N";

    // Validaciones básicas
    $errores = [];

    if (empty($documento) || !is_numeric($documento) || $documento < 1000000  || $documento > 999999999999) {
        $errores[] = "Solo se admiten documentos con 7 a 12 digitos.";
    }
    if (empty($nombre) || strlen($nombre) >= 50) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($apellido) || strlen($apellido) >= 50) {
        $errores[] = "El apellido es obligatorio.";
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

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'clientes.php';
        </script>";
        exit();
    }

    // Conexión y consulta
    $MiConexion = ConexionBD();

    $query = "INSERT INTO clientes (dniCliente, nombreCliente, apellidoCliente, mailCliente, telefonoCliente, direccionCliente, localidadCliente, bajaCliente) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $MiConexion->prepare($query);

    // Vinculamos los valores en el orden correcto
    $stmt->bind_param("isssssss", $documento, $nombre, $apellido, $email, $telefono, $direccion, $localidad, $baja);

    if ($stmt->execute()) {

        // Obtener el ID del nuevo cliente
        $idCliente = $stmt->insert_id;
        
        $mensaje = "Cliente agregado exitosamente. Identificador (ID) asignado: {$idCliente}. ¡Vayamos a verlo!";
    } 
    else {

        $mensaje = "Error al agregar cliente: " . $MiConexion->error;
    }

    $stmt->close();
    $MiConexion->close();

    // Redirigir con un mensaje
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'clientes.php?identificador={$idCliente}&documento=&nombre=&apellido=&email=&telefono=&direccion=&localidad=';
        </script>";
    exit();
}

?>