<?php
require_once (PATHPACKAGES.'\Authenticate\Entidad\Existe.php');
require_once (PATHPACKAGES.'\Authenticate\Authenticate.php');

$old_cvl = $_REQUEST['old_cvl'];
$new_cvl = $_REQUEST['new_cvl'];

try {
	echo json_encode(Authenticate::setNewPass($old_cvl,$new_cvl));	
} catch (Exception $e) {
	/** Devolvemos el Error **/
	$existe = new Authenticate_Entidad_Existe();
	$existe->Existe = $e->__toString();
	echo json_encode($existe);
}
?>