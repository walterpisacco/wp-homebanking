<?php 
try {
    session_start();

    require_once '../../Utilidades/ClienteDAO.php';

    $Func = new ClienteDAO();

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

    $resultado = $Func->GetEquiposList(1,10000,1,'desc',$rules);
    if(count($resultado) > 0){
        if(!$resultado[0]->Success) throw new Exception($resultado[0]->Text, 1);
    }

    header("Content-type: application/json;charset=utf-8");
    echo json_encode($resultado);
} catch (\Throwable $th) {
    header("HTTP/1.0 404 Not Found");
    echo $th->getMessage();
    die();
}
