<?php

// Emitir listado de "Tipos de Contratos"
function Listar_TiposContratos($vConexion) {

    $Listado = array();

    $consulta = "SELECT id, descripcion 
                FROM tipodecontrato; ";

    $rs = mysqli_query($vConexion, $consulta);
        
    $i=0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['id'] = $data['id'];
        $Listado[$i]['descripcion'] = $data['descripcion'];
    
        $i++;
    }

    //devuelvo el listado generado en el array $Listado (podra salir vacio o con datos)..
    return $Listado;
}




// Emitir listado de "Puestos" (Cargos)
function Listar_Puestos($vConexion) {

    $Listado = array();

    $consulta = "SELECT id, descripcion 
                FROM cargo 
                WHERE descripcion != 'GERENTE_GENERAL' 
                ORDER BY descripcion; ";

    $rs = mysqli_query($vConexion, $consulta);
        
    $i=0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['id'] = $data['id'];

        if ($data['descripcion'] == "ADMINISTRADOR") {

            $Listado[$i]['descripcion'] = "Administrador";
        }
        if ($data['descripcion'] == "ENCARGADO_ADMINISTRACION") {

            $Listado[$i]['descripcion'] = "Encargado de Administración";
        } 
        if ($data['descripcion'] == "ENCARGADO_FINANZAS") {

            $Listado[$i]['descripcion'] = "Encargado de Finanzas";
        } 
        if ($data['descripcion'] == "ENCARGADO_COMPRAS") {

            $Listado[$i]['descripcion'] = "Encargado de Compras";
        }
        if ($data['descripcion'] == "ENCARGADO_RRHH") {

            $Listado[$i]['descripcion'] = "Encargado de RRHH";
        } 
        if ($data['descripcion'] == "STAFF_CONTADOR") {

            $Listado[$i]['descripcion'] = "Staff: Contador";
        } 
        if ($data['descripcion'] == "ENCARGADO_OPERACIONES") {

            $Listado[$i]['descripcion'] = "Encargado de Operaciones";
        } 
        if ($data['descripcion'] == "OPERATIVO_ESTILISTA") {

            $Listado[$i]['descripcion'] = "Operativo estilista";
        } 
        if ($data['descripcion'] == "OPERATIVO_AUXILIAR") {

            $Listado[$i]['descripcion'] = "Operativo auxiliar";
        } 
        if ($data['descripcion'] == "ENCARGADO_RECEPCION") {

            $Listado[$i]['descripcion'] = "Encargado de Recepción";
        } 
        if ($data['descripcion'] == "OPERATIVO_RECEPCIONISTA") {

            $Listado[$i]['descripcion'] = "Operativo recepcionista";
        } 
        if ($data['descripcion'] == "ENCARGADO_VENTAS") {

            $Listado[$i]['descripcion'] = "Encargado de Ventas";
        } 
        if ($data['descripcion'] == "OPERATIVO_VENDEDOR") {

            $Listado[$i]['descripcion'] = "Operativo vendedor";
        } 
        if ($data['descripcion'] == "OPERATIVO_CAJERO") {

            $Listado[$i]['descripcion'] = "Operativo cajero";
        } 
        if ($data['descripcion'] == "OPERATIVO_REPOSITOR") {

            $Listado[$i]['descripcion'] = "Operativo repositor";
        } 
        if ($data['descripcion'] == "ENCARGADO_MARKETING") {

            $Listado[$i]['descripcion'] = "Encargado de Marketing";
        } 
        if ($data['descripcion'] == "COMMUNITY_MANAGER") {

            $Listado[$i]['descripcion'] = "Community Manager";
        } 
        if ($data['descripcion'] == "STAFF_DIS_GRAFICO") {

            $Listado[$i]['descripcion'] = "Staff: Diseñador gráfico";
        } 

        $i++;
    }
    
    return $Listado;
}



// Emitir listado con todos los "Estados de Contratos"
function Listar_EstadosContratos($vConexion) {

    $Listado = array();

    $consulta = "SELECT id, estado, descripcion 
                FROM estadocontrato 
                ORDER BY estado; ";

    $rs = mysqli_query($vConexion, $consulta);
        
    $i=0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['id'] = $data['id'];
        $Listado[$i]['estado'] = $data['estado'];
        $Listado[$i]['descripcion'] = $data['descripcion'];
    
        $i++;
    }

    return $Listado;
}

?>