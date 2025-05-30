<?php

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();
$mensaje = "";

if (isset($_GET['id'])) {
    $idEmpleado = $_GET['id'];

    // Consulta para eliminar el empleado de la base de datos (baja lógica)
    $consulta = "UPDATE empleados SET bajaEmpleado = 'S' WHERE id = ?";

    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("i", $idEmpleado);
    $stmt->execute();

    // Verificar si la eliminación fue exitosa
    if ($stmt->affected_rows > 0) {

        // Redirigir al listado de empleado con un mensaje de éxito
        $mensaje = "El empleado {$idEmpleado} ha sido dado de baja exitosamente.";
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'empleados.php';
            </script>";
        exit();
    } 
    else {
        // Si no se actualizó el registro efectuando baja lógica, mostrar un mensaje de error
        $mensaje = "ERROR: El empleado {$idEmpleado} NO fue dado de baja exitosamente.";
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'empleados.php';
            </script>";
        exit();
    }
} 
else {
    // Si no se pasó el ID por URL, redirigir al listado de empleados con un mensaje
    $mensaje = "No se encontró el empleado en la base de datos";
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'empleados.php';
        </script>";
    exit();
}

?>