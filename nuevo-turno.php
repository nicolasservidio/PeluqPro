<?php
session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servicio = trim(strip_tags($_POST['servicio']));
    $idCliente = $_POST['cliente'];
    $idEmpleado = $_POST['empleado'];
    $fechaturno = $_POST['fechaturno'];
    $horaturno = $_POST['horaturno'];

    // Para que los turnos figuren en el listado, baja = "N"
    $baja = "N";

    // Validaciones básicas
    $errores = [];

    if (empty($servicio) || strlen($servicio) >= 200) {
        $errores[] = "El servicio es obligatorio y no puede superar los 200 caracteres.";
    }
    if (empty($idCliente)) {
        $errores[] = "Es cliente es obligatorio.";
    }
    if (empty($idEmpleado)) {
        $errores[] = "Es empleado es obligatorio.";
    }

    if (empty($fechaturno)) {
        $errores[] = "La fecha del turno es obligatoria.";
    }
    else {
        $fechaturno = date("Y-m-d", strtotime($fechaturno)); 
    }

    if (empty($horaturno)) {
        $errores[] = "La hora del turno es obligatoria.";
    }


    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'turnos.php';
        </script>";
        exit();
    }

    // Conexión y consulta
    $MiConexion = ConexionBD();

    $query = "INSERT INTO turnos  
                                (servicioTurno, 
                                fechaTurno, 
                                horaTurno, 
                                idEmpleado, 
                                idCliente, 
                                bajaTurno) 
              VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $MiConexion->prepare($query);

    // Vinculamos los valores en el orden correcto
    $stmt->bind_param("sssiis", $servicio, $fechaturno, $horaturno, $idEmpleado, $idCliente, $baja);

    if ($stmt->execute()) {

        // Obtener el ID del nuevo turno
        $idTurno = $stmt->insert_id;
        
        $mensaje = "Turno agregado exitosamente. Identificador (ID) asignado: {$idTurno}. ¡Vayamos a verlo!";
    } 
    else {

        $mensaje = "Error al agregar el turno: " . $MiConexion->error;
    }

    $stmt->close();
    $MiConexion->close();

    // Redirigir con un mensaje
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'turnos.php?cliente=&empleado=&identificador={$idTurno}&servicio=&fechadesde=&fechahasta=';
        </script>";
    exit();
}

?>