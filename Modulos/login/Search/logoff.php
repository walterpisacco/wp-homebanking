<?php
session_start();

$_SESSION["idUsuario"] = '';
Header ("location: ../../../index.php");
exit();

?>