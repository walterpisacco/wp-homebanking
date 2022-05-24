<?php
session_start();
include 'Modulos/Utilidades/ClienteDAO.php';
$Func = new ClienteDAO();

$tipo = $_REQUEST['Tipo'];
$Param = $_REQUEST['Param'];

$resultado = $Func->recuperarCombo($tipo,$Param);	

header("Content-type: application/json;charset=utf-8");
echo json_encode($resultado);


