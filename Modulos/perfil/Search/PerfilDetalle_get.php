<?php
session_start();

require_once '../../Utilidades/ClienteDAO.php';

$Func = new ClienteDAO();

$idUsuario 	= $_SESSION["idUsuario"];
$idApp = idApp;

$resultado = $Func->EditarPerfil($idUsuario,$idApp);

header("Content-type: application/json;charset=utf-8");
echo json_encode($resultado);