<?php
if($_SESSION["idUsuario"] == ''){
  Header ("location: ../../index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../../img/logo.png">
  <link rel="icon" type="image/png" href="../../img/logo.png">
  <title>Cajas Inteligentes</title>

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="../../css/material-dashboard-new.css?v1.9" rel="stylesheet" />
  <link href="../../inc/guriddoJqgrid/css/ui.jqgrid-bootstrap.css?v2" rel="stylesheet" type="text/css" >
  <link href="../../inc/switch1/css/bootstrap3/bootstrap-switch.css?v=1.0" rel="stylesheet"/> 
  <link href="../../css/fix.css?v1.4" rel="stylesheet" type="text/css" >  
  <link href="../../inc/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"  />
  
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
 
  <div id="preloader" class="loadgif" style="display: none">
    <span class="margin-bottom"><img style="width: 80px;height: 80px" src="../../img/loader.gif" alt="" /></span>
  </div>

<?php
include '../../Modulos/Utilidades/funciones.php';
include '../../Modulos/Utilidades/perfil.php'; 
include '../../Modulos/diccionario/diccionario.php';
?>

  
