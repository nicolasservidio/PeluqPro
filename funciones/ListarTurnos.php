
<?php
function Listar_Turnos($MiConexion, $filtros = []) {

    // Antes de realizar la consulta, cambio el formato de fechas ingresadas en form de consultas
    if (!empty($filtros['fechadesde'])) {

        $fechadesde = $filtros['fechadesde']; 
        $fechadesde = date("Y-m-d", strtotime($fechadesde));  
    }
    if (!empty($filtros['fechahasta'])) {

        $fechahasta = $filtros['fechahasta'];
        $fechahasta = date("Y-m-d", strtotime($fechahasta));
    }

    $query = "SELECT t.id AS idTurno, 
                    t.servicioTurno AS servicioTurno, 
                    t.fechaTurno AS fechaTurno, 
                    t.horaTurno AS horaTurno, 
                    t.idEmpleado AS tIdEmpleado , 
                    t.idCliente AS tIdCliente, 
                    t.bajaTurno AS bajaTurno,

                    e.id AS eId,
                    e.nombreEmpleado AS nombreEmpleado,
                    e.apellidoEmpleado AS apellidoEmpleado,
                    e.cuilEmpleado AS cuilEmpleado,

                    c.idCliente AS cId,
                    c.nombreCliente AS nombreCliente,
                    c.apellidoCliente AS apellidoCliente,
                    c.dniCliente AS dniCliente 
                FROM turnos t 
                INNER JOIN empleados e ON e.id = t.idEmpleado
                INNER JOIN clientes c ON c.idCliente = t.idCliente  
                WHERE t.bajaTurno = 'N' ";

    $params = [];
    $types = '';

    if (!empty($filtros['identificador'])) {
        $query .= " AND t.id = ?";
        $params[] = $filtros['identificador'];
        $types .= 'i';
    }
    if (!empty($filtros['idCliente'])) {
        $query .= " AND t.idCliente = ?";
        $params[] = $filtros['idCliente'];
        $types .= 'i';
    }
    if (!empty($filtros['idEmpleado'])) {
        $query .= " AND t.idEmpleado = ?";
        $params[] = $filtros['idEmpleado'];
        $types .= 'i';
    }
    if (!empty($filtros['servicio'])) {
        $query .= " AND t.servicioTurno LIKE ?";
        $params[] = "%" . $filtros['servicio'] . "%";
        $types .= 's';
    }

    if (!empty($fechadesde)) {
        $query .= " AND t.fechaTurno >= ?";
        $params[] = $fechadesde;
        $types .= 's';
    }
    if (!empty($fechahasta)) {
        $query .= " AND t.fechaTurno <= ?";
        $params[] = $fechahasta;
        $types .= 's';
    } 

    // Agrego el orden a la consulta sql
    $query .= " ORDER BY t.fechaTurno, t.horaTurno; "; 

    $stmt = $MiConexion->prepare($query);
    if (!$stmt) {  
        die("Error en la consulta SQL: " . $MiConexion->error);  
    }


    if ($types) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $turnos = $result->fetch_all(MYSQLI_ASSOC);

    return $turnos;
}