<?php

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];

    // Recolecto datos del cliente en función del id pasado por URL, para el formulario 
    $consulta = "SELECT * FROM clientes WHERE idCliente = ?";

    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $cliente = $resultado->fetch_assoc();
} 
else {
    // Si no se pasa un ID, redirigir al listado
    header('Location: clientes.php');
    exit();
}

// Capturo los datos del formulario debajo para realizar el Update 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = strip_tags(trim($_POST['nombre']));
    $apellido = strip_tags(trim($_POST['apellido']));
    $email = strip_tags(trim($_POST['email']));
    $telefono = strip_tags(trim($_POST['telefono']));
    $direccion = strip_tags(trim($_POST['direccion']));
    $localidad = strip_tags(trim($_POST['localidad']));

    // Validaciones básicas
    $errores = [];

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


    // Actualizar los datos del cliente
    $consulta = "UPDATE clientes 
                SET nombreCliente = ?, 
                    apellidoCliente = ?, 
                    mailCliente = ?, 
                    telefonoCliente = ?, 
                    direccionCliente = ?,
                    localidadCliente = ?  
                WHERE idCliente = ? ";

    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("ssssssi", $nombre, $apellido, $email, $telefono, $direccion, $localidad, $idCliente);
    $stmt->execute();

    // Redirigir después de la actualización
    $mensaje = "Usted ha modificado exitosamente el cliente de ID={$idCliente}. ¡Vamos a verlo!";
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'clientes.php?identificador={$idCliente}&documento=&nombre=&apellido=&email=&telefono=&direccion=&localidad=';
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

                <h3 class="mb-4" style="color:rgb(175, 33, 8); Font-Family: Arial;">MODIFICAR CLIENTE</h3><br>

                <!-- Formulario para modificar el cliente -->
                <form method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label" style="color: white !important;">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                value="<?php echo htmlspecialchars($cliente['nombreCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellido" class="form-label" style="color: white !important;">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" 
                                value="<?php echo htmlspecialchars($cliente['apellidoCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: white !important;">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                                value="<?php echo htmlspecialchars($cliente['mailCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label" style="color: white !important;">Teléfono</label>
                        <input type="number" step="1" title="Solo se admiten números telefónicos con 8 a 12 dígitos" 
                                class="form-control" id="telefono" name="telefono" 
                                value="<?php echo htmlspecialchars($cliente['telefonoCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label" style="color: white !important;">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" 
                                value="<?php echo htmlspecialchars($cliente['direccionCliente']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="localidad" class="form-label" style="color: white !important;">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad" 
                                value="<?php echo htmlspecialchars($cliente['localidadCliente']); ?>" required>
                    </div>

                    <br><br>
                    <button type="submit" class="btn" style="background-color: rgb(175, 33, 8); color: white;">
                        Guardar Cambios
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>