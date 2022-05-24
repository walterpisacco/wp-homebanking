<?php 
session_start();

ini_set('display_errors',0 );
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

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

if(!BuscarPerfil(1)){//Si NO ES Super Administrador filtro los equipos de su empresa
    $field = ' c.idCliente ';
    $operador=' = ';
    $value = " '".$_SESSION["idCliente"]."' ";
    $filter = new stdClass();
    $filter->field = $field;
    $filter->operador = $operador;
    $filter->value = $value;
    $rules[] = $filter;    
} 

if(is_array($filters->rules)){
    foreach($filters->rules as $rule){
        if ($rule->field == 3) { // serie
                $field = ' serie ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 4) { // direccion
                $field = ' direccion ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 7 && $rule->data != 'Todos') { // tipo
                $field = ' e.tipo ';
                $operador=' = ';
                $value = " '".$rule->data."' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }  
        if ($rule->field == 8 && $rule->data != 'Todos') { // estado
                $field = ' e.estado ';
                $operador=' = ';
                $value = " '".$rule->data."' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 10) { // cliente
                $field = ' c.nombre ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
    }
}

$resultado = $Func->GetEquiposList($start,$limit,$sidx,$sord,$rules);
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
    $acciones = "<a ".$class." href='Javascript:Editar(".$row->idEquipo.")'><i class='material-icons' style='color: black;'>create</i></a>";
  //  $acciones .= "<a ".$class." href='Javascript:Sincronizar(".$row->idEquipo.")'><i class='material-icons' style='color: black;margin-left: 10px;'>autorenew</i></a>";
    $acciones .= "<a ".$class." href='Javascript:Eliminar(".$row->idEquipo.")'><i class='material-icons' style='color: red;margin-left: 10px;'>delete_forever</i></a>";        
        $responce->rows [$i] ['id'] = $row->idEquipo;
        $responce->rows [$i] ['cell'] = Array(
             $row->idEquipo
            ,$row->serie
            ,$row->nombreCliente
            ,$row->direccion            
            ,$row->tipo
            ,$row->estado  
            ,$row->posX
            ,$row->posY             
          //  ,$row->ultimoSinc 
            ,$acciones
       		);
        $i++;
    }
    
}

header("Content-type: application/json;charset=utf-8");
echo json_encode($responce);
