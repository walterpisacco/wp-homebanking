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


if(!BuscarPerfil(1)){//Si NO ES Super Administrador filtro los usuarios de su empresa
    $field = ' p.idCliente ';
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
        if ($rule->field == 2) { // cliente
                $field = ' c.nombre ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 3) { // perfil
                $field = ' sp.descripcion ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        } 
        if ($rule->field == 4) { // usuario
                $field = ' usuario ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 5) { // apellido
                $field = ' apellido ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 6) { // nombre
                $field = ' p.nombre ';
                $operador=' like ';
                $value = " '%".$rule->data."%' ";
            $filter = new stdClass();
            $filter->field = $field;
            $filter->operador = $operador;
            $filter->value = $value;
            $rules[] = $filter;                
        }
        if ($rule->field == 8) { // mail
                $field = ' mail ';
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

$resultado = $Func->GetPersonasList($start,$limit,$sidx,$sord,$rules);
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
    $acciones = "<a ".$class." href='Javascript:SeguridadPersona(".$row->idPersona.")'><img  src='../../img/seguridad.png'/title='Seguridad'>  </a>";
    $acciones .= "<a ".$class." href='Javascript:EliminarPersona(".$row->idPersona.")'><img  src='../../img/eliminar.png'/title='Eliminar'>  </a>";        
        $responce->rows [$i] ['id'] = $row->Id;
        $responce->rows [$i] ['cell'] = Array(
             $row->idPersona
            ,$row->Cliente
            ,$row->perfil 
            ,$row->usuario  
            ,$row->apellido
            ,$row->nombres
            ,$row->DNI
            ,$row->mail 
            ,$row->telefono
            ,$row->estado  
            ,$acciones
       		);
        $i++;
    }
    
}

header("Content-type: application/json;charset=utf-8");
echo json_encode($responce);
