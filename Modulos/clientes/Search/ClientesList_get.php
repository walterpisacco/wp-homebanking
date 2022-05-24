<?php 
session_start();
/*
$_SESSION["idUsuario"] = '';
Header ("location: ../../../index.php");
exit();
*/
/*
ini_set('display_errors',0 );
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
*/
require_once '../../Utilidades/ClienteDAO.php';

$Func = new ClienteDAO();

$page = $_REQUEST['page'];

$linea = $_REQUEST['linea'];

$limit = $_REQUEST['rows'];

$rowsxpag  = $_REQUEST['rows'];

$sidx = $_REQUEST['sidx'];

$sord = $_REQUEST['sord'];

if(!$sidx) $sidx =1;

$start = $limit*$page - $limit;

if($start <0){
    $start = 0;
}else{
    $start = $start + 1;
    $limit = $limit*$page;
}

$filters = json_decode($_REQUEST['filters']);

if(is_array($filters->rules)){
    foreach($filters->rules as $rule){
        if ($rule->field == 3) { // nombre
                $field = ' nombre ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 4) { // razon social
                $field = ' razonSocial ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 5) { // email
                $field = ' email ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 6) { // telefono
                $field = ' telefono ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 7) { // direccion
                $field = ' direccion ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 8 && $rule->data != 'Todos') { // estado
                $field = ' estado ';
                $operador=' = ';
                $value = " '".$rule->data."' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }        
    }
}

/*
print_r($rules);
exit();
*/

$resultado = $Func->GetClientesList($start,$limit,$sidx,$sord,$rules);
/*
print_r($resultado);
exit();
*/
$count = (int)$resultado[0]->Total_Row;

if ($count > 0 && $limit > 0) {
    $total_pages = ceil ( $count / $rowsxpag );
} else {
    $total_pages = 0;
}
$i=0;
$responce = new stdClass();
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

$acciones = '';

if ($resultado [0]->Success == 'true') {
    foreach ( $resultado as $row ) {
    $acciones = "<a ".$class." href='Javascript:EditarCliente(".$row->idCliente.")'><img  src='../../img/editar.png'/title='Editar'>  </a>";
    if($row->cantEquipos > 0){
    $acciones .= "<a ".$class." href='Javascript:ClienteEquipos(".$row->idCliente.")'><img  src='../../img/equipos.png'/title='Con Equipos'>  </a>"; 
    }else{
    $acciones .= "<a ".$class." href='Javascript:ClienteEquipos(".$row->idCliente.")'><img  src='../../img/equiposNO.png'/title='Sin Equipos'>  </a>";         
    }
    $acciones .= "<a ".$class." href='Javascript:EliminarCliente(".$row->idCliente.")'><img  src='../../img/eliminar.png'/title='Eliminar'>  </a>";      
        $responce->rows [$i] ['id'] = $row->idCliente;
        $responce->rows [$i] ['cell'] = Array(
             $row->idCliente
            ,$row->nombre             
            ,$row->razonSocial
            ,$row->email
            ,$row->telefono
            ,$row->direccion 
            ,$row->estado  
            ,$acciones
       		);
        $i++;
    }
    
}

header("Content-type: application/json;charset=utf-8");
echo json_encode($responce);
