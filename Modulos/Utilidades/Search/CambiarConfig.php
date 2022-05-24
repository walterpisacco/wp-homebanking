<?php 
session_start();

$tipo = $_REQUEST['tipo'];
$valor = $_REQUEST['valor'];

if($tipo == 'estilo'){
	$_SESSION['css'] = $valor;	
}

if($tipo == 'lenguaje'){
	$_SESSION['lenguaje'] = $valor;
}

header("Content-type: application/json;charset=utf-8");
echo json_encode($valor);