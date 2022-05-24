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

$oCliente = new stdClass();
$oCliente->idCliente	= $_REQUEST['idCliente'];
$oCliente->nombre 		= $_REQUEST['nombre'];
$oCliente->razonSocial 	= $_REQUEST['razon'];
$oCliente->email 		= $_REQUEST['mail'];
$oCliente->telefono 	= $_REQUEST['telefono'];
$oCliente->direccion 	= $_REQUEST['direccion'];
$oCliente->estado 		= $_REQUEST['estado'];

$resultado = $Func->GuardarCliente($oCliente);

header("Content-type: application/json;charset=utf-8");
echo json_encode($resultado);