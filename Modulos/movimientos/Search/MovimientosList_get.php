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

$field = ' t.idCliente ';
$operador=' = ';
$value = " '".$_SESSION["idCliente"]."' ";
$filter = new stdClass();
$filter->field = $field;
$filter->operador = $operador;
$filter->value = $value;
$rules[] = $filter; 

// fuerzo el where porque ne l store son todos and

if(is_array($filters->rules)){
    foreach($filters->rules as $rule){
        if ($rule->field == 3) { // serie
                $field = ' e.serie ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 4) { // bolsa
                $field = ' t.idBolsa ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 5) { // transaccionMaquina
                $field = ' t.idTransaccionMaquina ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }        
        if ($rule->field == 6) { // usuario
                $field = ' idusuario ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 7) { // fecha
                $fecha = fechaInternacional($rule->data);
                $field = ' t.fechaHoraTran ';
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
        if ($rule->field == 8 && $rule->data != 'Todos') { // tipo
                $field = ' td.tipoOperacion ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 11) { // concepto
                $field = ' concepto ';
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

$resultado = $Func->GetMovimientosList($start,$limit,$sidx,$sord,$rules);
/*
echo '<pre>';
print_r($resultado);
exit;
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
        $responce->rows [$i] ['id'] = $row->idDetalle;
        $responce->rows [$i] ['cell'] = Array(
            $row->idTransaccion
            ,$row->serie
            ,$row->idBolsa
            ,$row->idTransaccionMaquina
            ,$row->usuario
            ,$row->fecha
            ,$row->operacion
            ,$row->concepto            
            ,$row->monto
            ,$row->saldo
            );
        $i++;
    }
    
}

header("Content-type: application/json;charset=utf-8");
echo json_encode($responce);
