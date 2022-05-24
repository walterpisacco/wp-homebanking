<?php 
session_start();

require_once '../../Utilidades/ClienteDAO.php';

$Func = new ClienteDAO();

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

$resultado = $Func->GetMovimientosExcel(1,10000,1,'asc',$rules);
/*
echo '<pre>';
print($resultado->Text);
exit;
*/
header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header("Content-Disposition: attachment; filename=movimientos.csv");
header("Pragma: no-cache");
header("Expires: 0");
echo trim($resultado->Text);
