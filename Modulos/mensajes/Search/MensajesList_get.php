<?php 
session_start();

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
    $field = ' m.idCliente ';
    $operador=' = ';
    $value = " '".$_SESSION["idCliente"]."' ";
    $filter = new stdClass();
    $filter->field = $field;
    $filter->operador = $operador;
    $filter->value = $value;
    $rules[] = $filter;    
} 

    $field = ' m.descripcion ';
    $operador=' <> ';
    $value = " '[No_Event]' ";
    $filter = new stdClass();
    $filter->field = $field;
    $filter->operador = $operador;
    $filter->value = $value;
    $rules[] = $filter;   

if(is_array($filters->rules)){
    foreach($filters->rules as $rule){
        if ($rule->field == 3 && $rule->data != 'Todos') { // tipo
                $field = ' tm.id ';
                $operador=' = ';
                $value = " '".$rule->data."' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 4) { // serie
                $field = ' e.serie ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 5) { // fecha
                $fecha = fechaInternacional($rule->data);
                $field = ' fechaUpdate ';
                $operador=' >= ';
                $value = " '".substr($fecha,0,10)." 00:00:00' "; // tomo sin la hora
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;

            $operador=' <= ';
            $value = " '".substr($fecha,0,10)." 23:59:59' "; // tomo sin la hora
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;
        }        
        if ($rule->field == 6) { // descripcion
                $field = ' m.descripcion ';
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
/*
print_r($rules);
exit();
*/
$resultado = $Func->GetMensajesList($start,$limit,$sidx,$sord,$rules);
/*
;
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
        $responce->rows [$i] ['id'] = $row->IdMensaje;
        $responce->rows [$i] ['cell'] = Array(
             $row->idMensaje
            ,$row->tipo
            ,$row->equipo            
            ,$row->fecha
            ,$row->descripcion  
       		);
        $i++;
    }
    
}

header("Content-type: application/json;charset=utf-8");
echo json_encode($responce);
