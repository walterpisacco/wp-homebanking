<?php 
session_start();
/*
$_SESSION["idUsuario"] = '';
Header ("location: ../../../index.php");
exit();
*/

require_once '../../Utilidades/ClienteDAO.php';
$Func = new ClienteDAO();

$tipo = 'mensajes';

$parametros = new stdClass();
$parametros->desde = $_REQUEST['desde'];
$parametros->hasta = $_REQUEST['hasta'];
$parametros->serie = $_REQUEST['serie'];
$parametros->idEquipo = $_REQUEST['idEquipo'];

$resultado = $Func->Sincronizar_Mensajes($tipo,$parametros);

header("Content-type: application/json;charset=utf-8");
echo ((int)$resultado);