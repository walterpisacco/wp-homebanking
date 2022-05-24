<?php
require_once '../Utilidades/cabecera.php';
?>
</head>

<style type="text/css">
  .navbar.navbar-absolute {
      margin-left: 40px !important;
  }
  .marca{
      background-color: hsl(0deg 0% 77%);;
      color: #000;
      font-size: initial;
  }
</style>

<body class="">
  <div class="wrapper ">
  <?php
  require_once '../Utilidades/nav-izquierda.php';
  ?>
    <div class="main-panel">

  <?php
  require_once '../Utilidades/nav-top.php';
  ?>
<script type="text/template" id="tplError">
  <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Atenci&oacute;n!</strong> <%-msn%>
  </div>
</script>
<link rel="stylesheet" href="../../inc/leaflet/leaflet.css"/>
<link rel="stylesheet" href="../../inc/Leaflet.markercluster/MarkerCluster.css"/>
<link rel="stylesheet" href="../../inc/Leaflet.markercluster/MarkerCluster.Default.css"/>
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div id="mapa_contenedor"></div>
              </div>
            </div>
          </div>            
    </div>
  </div>
<?php
require_once '../Utilidades/pie.php';
require_once 'panelIzquierda.php';
?>
<script type="text/javascript"  src="../../inc/leaflet/leaflet.js"></script>
<script type="text/javascript"  src="../../inc/Leaflet.markercluster/leaflet.markercluster.js"></script>
<script type="text/javascript"  src="../mapa/js/mapa.js?v=1.3"></script>

