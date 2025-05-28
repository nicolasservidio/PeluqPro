<?php

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();
$mensaje = "";

// Verificar si el ID del cliente está presente en la URL
if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];

    // Consulta para eliminar el cliente de la base de datos (baja lógica)
    $consulta = "UPDATE clientes SET bajaCliente = 'S' WHERE idCliente = ?";

    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();

    // Verificar si la eliminación fue exitosa
    if ($stmt->affected_rows > 0) {

        // Redirigir al listado de clientes con un mensaje de éxito
        $mensaje = "El cliente {$idCliente} ha sido dado de baja exitosamente.";
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'clientes.php';
            </script>";
        exit();
    } 
    else {
        // Si no se actualizó el registro efectuando baja lógica, mostrar un mensaje de error
        $mensaje = "ERROR: El cliente {$idCliente} NO fue dado de baja exitosamente.";
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'clientes.php';
            </script>";
        exit();
    }
} 
else {
    // Si no se pasó el ID por URL, redirigir al listado de clientes con un mensaje
    $mensaje = "No se encontró el cliente en la base de datos";
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'clientes.php';
        </script>";
    exit();
}

?>