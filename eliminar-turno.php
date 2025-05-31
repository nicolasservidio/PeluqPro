<?php

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();
$mensaje = "";

if (isset($_GET['id'])) {
    $idTurno = $_GET['id'];

    // Consulta para eliminar el turno de la base de datos (baja lógica)
    $consulta = "UPDATE turnos SET bajaTurno = 'S' WHERE id = ?";

    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("i", $idTurno);
    $stmt->execute();

    // Verificar si la eliminación fue exitosa
    if ($stmt->affected_rows > 0) {

        // Redirigir al listado de turnos con un mensaje de éxito
        $mensaje = "El turno de ID={$idTurno} ha sido dado de baja exitosamente.";
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'turnos.php';
            </script>";
        exit();
    } 
    else {
        // Si no se actualizó el registro efectuando baja lógica, mostrar un mensaje de error
        $mensaje = "ERROR: El turno de ID={$idTurno} NO fue dado de baja exitosamente.";
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'turnos.php?cliente=&empleado=&identificador={$idTurno}&servicio=&fechadesde=&fechahasta=';
            </script>";
        exit();
    }
} 
else {
    // Si no se pasó el ID por URL, redirigir al listado de turnos con un mensaje
    $mensaje = "No se encontró el turno en la base de datos";
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'turnos.php';
        </script>";
    exit();
}

?>