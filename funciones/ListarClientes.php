
<?php
function Listar_Clientes($MiConexion, $filtros = []) {

    $query = "SELECT idCliente AS id, 
                    dniCliente AS documento, 
                    nombreCliente AS nombre, 
                    apellidoCliente AS apellido, 
                    mailCliente AS email, 
                    telefonoCliente AS telefono, 
                    direccionCliente AS direccion,
                    localidadCliente as localidad 
                FROM clientes WHERE 1=1";

    $params = [];
    $types = '';

    if (!empty($filtros['documento'])) {
        $query .= " AND dniCliente LIKE ?";
        $params[] = "%" . $filtros['documento'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['nombre'])) {
        $query .= " AND nombreCliente LIKE ?";
        $params[] = "%" . $filtros['nombre'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['apellido'])) {
        $query .= " AND apellidoCliente LIKE ?";
        $params[] = "%" . $filtros['apellido'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['email'])) {
        $query .= " AND mailCliente LIKE ?";
        $params[] = "%" . $filtros['email'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['telefono'])) {
        $query .= " AND telefonoCliente LIKE ?";
        $params[] = "%" . $filtros['telefono'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['direccion'])) {
        $query .= " AND direccionCliente LIKE ?";
        $params[] = "%" . $filtros['direccion'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['localidad'])) {
        $query .= " AND localidadCliente LIKE ?";
        $params[] = "%" . $filtros['localidad'] . "%";
        $types .= 's';
    }

    $stmt = $MiConexion->prepare($query);

    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}