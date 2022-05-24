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

$oPersona = new stdClass();

$oPersona->idPersona		= (int) $_REQUEST['idPersonaSeg'];
$oPersona->idUsuario		= (int) $_REQUEST['idUsuario'];
$oPersona->idCliente		= (int) $_REQUEST['cliente'];
$oPersona->nombre 			= $_REQUEST['nombre'];
$oPersona->apellido 		= $_REQUEST['apellido'];
$oPersona->mail 			= $_REQUEST['mail'];
$oPersona->usuario 			= $_REQUEST['usuario'];
$oPersona->perfil 			= $_REQUEST['perfil'];
$oPersona->estado 			= $_REQUEST['estadoSeg'];

$resultado = $Func->GuardarSeguridad($oPersona);

header("Content-type: application/json;charset=utf-8");
echo json_encode($resultado);