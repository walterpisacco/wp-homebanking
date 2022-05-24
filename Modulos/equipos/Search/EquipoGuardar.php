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

$oEquipo = new stdClass();
$oEquipo->idEquipo	  	= $_REQUEST['idEquipo'];
$oEquipo->tipo 			= $_REQUEST['tipo'];
$oEquipo->estado 		= $_REQUEST['estado'];
$oEquipo->serie 	  	= $_REQUEST['serie'];
$oEquipo->direccion  	= $_REQUEST['direccion'];
$oEquipo->posX 	  		= $_REQUEST['posX'];
$oEquipo->posY 	  		= $_REQUEST['posY'];

$resultado = $Func->GuardarEquipo($oEquipo);

header("Content-type: application/json;charset=utf-8");
echo json_encode($resultado);