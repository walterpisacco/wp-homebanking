<?php 
    session_start();

    require_once '../../Utilidades/ClienteDAO.php';

    $Func = new ClienteDAO();

    $idEquipo = (int) $_REQUEST['idEquipo'];

    $resultado = $Func->GetTransaccionesTotales($idEquipo);

   header("Content-type: application/json;charset=utf-8");
   echo json_encode($resultado);
