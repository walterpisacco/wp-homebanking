<?php 
try {
    session_start();

    require_once '../../Utilidades/ClienteDAO.php';

    $Func = new ClienteDAO();

    $idDetalle = (int) $_REQUEST['idDetalle'];

    $resultado = $Func->GetTransaccionesComposicion($idDetalle);

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
