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
        if ($rule->field == 2) { // Fecha
                $fecha = substr($rule->data,-4).'-'.substr($rule->data,3,2).'-'.substr($rule->data,0,2).'%';
                $field = ' fechaHoraTran ';
                $operador=' like ';
                $value = " '".$fecha."' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 3 && $rule->data != 0 ) { // Operacion
                $field = ' tipoOperacion ';
                $operador=' = ';
                $value = " '".$rule->data."' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 'idEquipo') { // idEquipo
                $field = ' t.idEquipo ';
                $operador=' = ';
                $value = " '".$rule->data."' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;
            $idEquipo = $rule->data;  
        }

    }
}

ob_start();    
$content="";
$normalout=true;
$content=ob_get_clean();
$normalout=false;

$resultado = $Func->GetTransaccionesList(1,10000,1,'ASC',$rules);
/*
echo '<pre>';
print_r($resultado);
exit();
*/
$tabla ='<table>
        <th>Maquina</th>
        <th>Fecha</th>
        <th>Operacion</th>
        <th>Monto</th>
        <th>Moneda</th>';

foreach ( $resultado as $row ){
    $monto = substr($row->monto,0,-7);
    $moneda = substr($row->monto,-3);
        $tabla .= '<tr>
                    <td>'.$row->serie.'</td>
                        <td>'.$row->fecha.'</td>
                        <td>'.$row->operacion.'</td>
                        <td>'.$monto.'</td>
                        <td>'.$moneda.'</td>
                     <tr>';
}

$tabla .= '<table>';

header( "Content-Type: application/vnd.ms-excel" );
header( "Content-disposition: attachment; filename=transacciones.xls" );

echo $tabla;

ob_start();

$content.=ob_get_clean();
if($normalout)
{
    echo($content);
} 