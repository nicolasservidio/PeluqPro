
<?php
function Listar_Empleados($MiConexion, $filtros = []) {

    // Antes de realizar la consulta, cambio el formato de fechas ingresadas en form de consultas
    if (!empty($filtros['nacimientodesde'])) {

        $nacimientodesde = $filtros['nacimientodesde']; // Recibe la fecha desde el formulario (MM/DD/YYYY)
        $nacimientodesde = date("Y-m-d", strtotime($nacimientodesde));  // Convertir la fecha al formato adecuado (YYYY-MM-DD)
    }
    if (!empty($filtros['nacimientohasta'])) {

        $nacimientohasta = $filtros['nacimientohasta'];
        $nacimientohasta = date("Y-m-d", strtotime($nacimientohasta));
    }
    if (!empty($filtros['ingresodesde'])) {

        $ingresodesde = $filtros['ingresodesde'];
        $ingresodesde = date("Y-m-d", strtotime($ingresodesde));
    }
    if (!empty($filtros['ingresohasta'])) {

        $ingresohasta = $filtros['ingresohasta'];
        $ingresohasta = date("Y-m-d", strtotime($ingresohasta));
    }

    $query = "SELECT e.id AS idEmpleado, 
                    e.nombreEmpleado AS nombreEmpleado, 
                    e.apellidoEmpleado AS apellidoEmpleado, 
                    e.cuilEmpleado AS cuilEmpleado, 
                    e.fechaNacimiento AS fechanacimiento, 
                    e.estadoCivil AS estadocivil, 
                    e.fechaIngreso AS fechaingreso,
                    e.idTipoContrato AS idTipoContrato,
                    e.idCargo AS idCargo,
                    e.idEstadoContrato AS idEstadoContrato,
                    e.obrasocial AS obrasocial,
                    e.banco AS banco,
                    e.cbu AS cbu,
                    e.mailEmpleado AS mail,
                    e.telEmpleado AS telefono,
                    e.direccionEmpleado AS direccion,
                    e.localidadEmpleado AS localidad,
                    e.bajaEmpleado AS baja,

                    tc.id AS tcId,
                    tc.descripcion AS tcDescripcion,

                    c.id AS cId,
                    c.descripcion AS cDescripcion,

                    ec.id AS ecId,
                    ec.estado AS ecEstado,
                    ec.descripcion AS ecDescripcion 
                FROM empleados e 
                INNER JOIN tipodecontrato tc ON tc.id = e.idTipoContrato
                INNER JOIN cargo c ON c.id = e.idCargo  
                INNER JOIN estadocontrato ec ON ec.id = e.idEstadoContrato 
                WHERE e.bajaEmpleado = 'N' ";

    $params = [];
    $types = '';

    if (!empty($filtros['identificador'])) {
        $query .= " AND e.id = ?";
        $params[] = $filtros['identificador'];
        $types .= 'i';
    }
    if (!empty($filtros['nombre'])) {
        $query .= " AND e.nombreEmpleado LIKE ?";
        $params[] = "%" . $filtros['nombre'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['apellido'])) {
        $query .= " AND e.apellidoEmpleado LIKE ?";
        $params[] = "%" . $filtros['apellido'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['cuil'])) {
        $query .= " AND e.cuilEmpleado LIKE ?";
        $params[] = "%" . $filtros['cuil'] . "%";
        $types .= 's';
    }

    if (!empty($nacimientodesde)) {
        $query .= " AND e.fechaNacimiento >= ?";
        $params[] = $nacimientodesde;
        $types .= 's';
    }
    if (!empty($nacimientohasta)) {
        $query .= " AND e.fechaNacimiento <= ?";
        $params[] = $nacimientohasta;
        $types .= 's';
    } 

    if (!empty($filtros['estadocivil'])) {
        $query .= " AND e.estadoCivil LIKE ?";
        $params[] = "%" . $filtros['estadocivil'] . "%";
        $types .= 's';
    }

    if (!empty($ingresodesde)) {
        $query .= " AND e.fechaIngreso >= ?";
        $params[] = $ingresodesde;
        $types .= 's';
    }
    if (!empty($ingresohasta)) {
        $query .= " AND e.fechaIngreso <= ?";
        $params[] = $ingresohasta;
        $types .= 's';
    } 

    if (!empty($filtros['tipocontrato'])) {
        $query .= " AND e.idTipoContrato = ?";
        $params[] = $filtros['tipocontrato'];
        $types .= 'i';
    }
    if (!empty($filtros['puesto'])) {
        $query .= " AND e.idCargo = ?";
        $params[] = $filtros['puesto'];
        $types .= 'i';
    }
    if (!empty($filtros['estadocontrato'])) {
        $query .= " AND e.idEstadoContrato = ?";
        $params[] = $filtros['estadocontrato'];
        $types .= 'i';
    }
    if (!empty($filtros['obrasocial'])) {
        $query .= " AND e.obrasocial LIKE ?";
        $params[] = "%" . $filtros['obrasocial'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['banco'])) {
        $query .= " AND e.banco LIKE ?";
        $params[] = "%" . $filtros['banco'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['cbu'])) {
        $query .= " AND e.cbu LIKE ?";
        $params[] = "%" . $filtros['cbu'] . "%";
        $types .= 's';
    }

    if (!empty($filtros['email'])) {
        $query .= " AND e.mailEmpleado LIKE ?";
        $params[] = "%" . $filtros['email'] . "%";
        $types .= 's';
    }

    if (!empty($filtros['telefono'])) {
        $query .= " AND e.telEmpleado LIKE ?";
        $params[] = "%" . $filtros['telefono'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['direccion'])) {
        $query .= " AND e.direccionEmpleado LIKE ?";
        $params[] = "%" . $filtros['direccion'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['localidad'])) {
        $query .= " AND e.localidadEmpleado LIKE ?";
        $params[] = "%" . $filtros['localidad'] . "%";
        $types .= 's';
    }

    // Agrego el orden a la consulta sql
    $query .= " ORDER BY e.idCargo, e.idTipoContrato, e.idEstadoContrato, e.fechaIngreso, e.apellidoEmpleado, e.nombreEmpleado; "; 


    $stmt = $MiConexion->prepare($query);
    if (!$stmt) {  
        die("Error en la consulta SQL: " . $MiConexion->error);  
    }


    if ($types) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $empleados = $result->fetch_all(MYSQLI_ASSOC);

    // 🔥 Aplicar transformación en los puestos después de la consulta
    foreach ($empleados as &$empleado) {
        $empleado['cDescripcion'] = ucwords(strtolower(str_replace('_', ' ', $empleado['cDescripcion']))); // inicial en mayúscula, demás letras minúscula, y remplazo guiones bajos por espacios
    }

    return $empleados;
}