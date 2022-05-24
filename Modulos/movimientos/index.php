<?php
require_once '../Utilidades/cabecera.php';
?>
</head>

<body class="">

  <div class="wrapper ">
  <?php
  require_once '../Utilidades/nav-izquierda.php';
  ?>
    <div class="main-panel">

  <?php
  require_once '../Utilidades/nav-top.php';
  ?>
<style type="text/css">
.algolia-autocomplete {
  width: 100%;
}
.algolia-autocomplete .aa-input, .algolia-autocomplete .aa-hint {
  width: 100%;
}
.algolia-autocomplete .aa-hint {
  color: #999;
}
.algolia-autocomplete .aa-dropdown-menu {
  width: 100%;
  background-color: #fff;
  border: 1px solid #999;
  border-top: none;
}
.algolia-autocomplete .aa-dropdown-menu .aa-suggestion {
  cursor: pointer;
  padding: 5px 4px;
}
.algolia-autocomplete .aa-dropdown-menu .aa-suggestion.aa-cursor {
  background-color: #B2D7FF;
}
.algolia-autocomplete .aa-dropdown-menu .aa-suggestion em {
  font-weight: bold;
  font-style: normal;
}

.branding {
font-size: 1.3em;
margin: 0.5em 0.2em;
}

.branding img {
  height: 1.3em;
  margin-bottom: - 0.3em;
}
.ap-input-icon {
    border: 0;
    background: transparent;
    position: absolute;
    top: -21px;
    bottom: 0;
    right: 6px;
    outline: none;
}
</style>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-icon card-header-rose">
            <div class="card-icon">
              <i class="material-icons">sync_alt</i>
            </div>
            <h4 class="card-title"><?php echo traducir('Movimientos'); ?>
            <button id="btnExportarTran" name="btnExportarTran" class="btn btn-info btn-sm btn-round">
                  <i class="material-icons">backup</i><?php echo traducir('Exportar'); ?>
                </button>
            </div>
            <div class="card-body ">
                <div class="row" >
                  <div class="col-md-12" >
                    <div id="divFiltros" name="divFiltros">
                      <table id="tblDatos"></table>
                      <div id="pagDatos" >
                      </div>
                    </div>  
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

 <?php
require_once '../Utilidades/pie.php';
?>
<script type="text/javascript" src="js/index.js?v=1.4"></script>
</body>

</html>