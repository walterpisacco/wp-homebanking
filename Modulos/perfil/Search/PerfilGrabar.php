<?php 
session_start();

require_once '../../Utilidades/ClienteDAO.php';

$Func = new ClienteDAO();

$idUsuario 	= $_SESSION["idUsuario"];

$oPersona = new stdClass();

$oPersona->idUsuario 	= $_SESSION['idUsuario'];
$oPersona->mail 		= $_REQUEST['email'];
$oPersona->telefono		= $_REQUEST['Telefono'];
$token 					= $_REQUEST['_token'];
$oPersona->pass 		= $_REQUEST['pass'];

if($token == '4T4AAdD2dy5ZKFeLaUFGAHRAhfZK49xbpEuE4JXW'){
	$resultado = $Func->GuardarPerfil($oPersona);
}else{
	$resultado = 'OPERACION NO PERMITIDA';
}

header("Content-type: application/json;charset=utf-8");
echo json_encode($resultado);