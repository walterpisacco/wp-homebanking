<?php 
session_start();
/*
$_SESSION["idUsuario"] = '';
Header ("location: ../../../index.php");
exit();
*/
ini_set('display_errors',0 );
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require_once '../../Utilidades/ClienteDAO.php';
$Func = new ClienteDAO();

$idCliente 		= $_REQUEST['idCliente'];

$resultado = $Func->ClienteEquipo($idCliente);

header("Content-type: application/json;charset=utf-8");
echo json_encode($resultado);