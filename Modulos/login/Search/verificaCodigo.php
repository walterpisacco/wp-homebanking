<?php 
session_start();

ini_set('display_errors',0 );
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require_once '../../Utilidades/ClienteDAO.php';
$Func = new ClienteDAO();

$cod = $_REQUEST['cod'];
$usu = $_REQUEST['usu'];

$resultado = $Func->verificarCodigo($cod,$usu);

header("Content-type: application/json;charset=utf-8");
echo json_encode($resultado);