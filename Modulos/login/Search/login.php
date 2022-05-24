<?php 
session_start();

ini_set('display_errors',0 );
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require_once '../../Utilidades/ClienteDAO.php';
$Func = new ClienteDAO();

$_SESSION["idUsuario"]= '';

$usuario = $_REQUEST['usuario'];
$password = $_REQUEST['password'];

$resultado = $Func->Conectar($usuario,$password);

if ($resultado->Success == 'true'){
	$_SESSION["idUsuario"]		= $resultado->idUsuario;
	$_SESSION["nombreUsuario"]  = $resultado->nombreUsuario;
	$_SESSION["idCliente"]		= $resultado->idCliente;	
	$_SESSION["cliente"]		= $resultado->cliente;
	$_SESSION["perfil"]  		= $resultado->perfil;
	$_SESSION["perfilDesc"]  	= $resultado->perfilDesc;		
}

header("Content-type: application/json;charset=utf-8");
echo json_encode($resultado);