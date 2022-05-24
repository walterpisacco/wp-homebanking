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
<link rel="stylesheet" href="../../inc/leaflet/leaflet.css"/>
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
              <i class="material-icons">local_atm</i>
            </div>
            <h4 class="card-title"><?php echo traducir('Equipos'); ?> 
<?php  if(BuscarPerfil('1')){//1 Super Administrador?> 
            <button class="btn btn-sm btn-round btn-reddit" onClick="AgregaEquipo();"><?php echo traducir('Agregar'); ?> <div class="ripple-container"></div>
            </button>
<?php } ?>              
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

  <div class="modal fade" id="modalEquipo" tabindex="-1" role="dialog" aria-labelledby="modalEquipoLabel" aria-hidden="true" style="background-color: hsl(0deg 0% 0% / 56%);">
    <div class="modal-dialog" style="max-width: 90%;">
      <div class="modal-content">
        <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-icon card-header-rose">
            <div class="card-icon">
              <i class="material-icons">local_atm</i>
            </div>
            <h4 class="card-title"><?php echo traducir('Equipo'); ?> </h4>
            </div>
            <div class="card-body ">
                <div class="">
                    <div class="card-content">
                        <h4 class="card-title"></h4>
                    <form id ="formEquipo">
                        <input type="hidden" id="idEquipo" name="idEquipo">
                    <div class="row">
                      <div class="col-md-6">
                          <div class="row">
                              <div class="col-md-8">
                                  <div class="form-group label-floating">
                                      <select name="tipo" id="tipo" class="selectpicker" data-style="btn btn-info btn-round">
                                     </select>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <select name="estado" id="estado" class="selectpicker" data-style="btn btn-info btn-round">
                                            <option value="2"><?php echo traducir('Equipo en Depósito'); ?></option>
                                            <option value="1"><?php echo traducir('Equipo Entregado'); ?> </option>
                                            <option value="3"><?php echo traducir('Equipo de Baja'); ?> </option>  
                                       </select>
                                    </div>
                                </div>
                          </div>
                          <div class="row">
                              <div class="col-md-5">
                                   <div class="form-group label-floating">
                                      <label class="bmd-label-floating" for="dni"><?php echo traducir('Serie'); ?> </label>
                                      <input type="text" class=" form-control limp fieldRequired" id="serie" name="serie">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-9">
                                   <div class="form-group label-floating">
                                      <label class="bmd-label-floating"><?php echo traducir('Dirección de Ubicacion'); ?> </label>
                                      <input type="search" class="valid form-control limp" id="direccion" name="direccion" value="">
                                  </div>
                              </div>                             
                          </div>
                          <div class="row">
                              <div class="col-md-5">
                                   <div class="form-group label-floating">
                                      <label class="bmd-label-floating" for="posX"><?php echo traducir('posX'); ?> </label>
                                      <input type="text" class=" form-control limp" id="posX" name="posX">
                                  </div>
                              </div>
                              <div class="col-md-5">
                                   <div class="form-group label-floating">
                                      <label class="bmd-label-floating" for="posX"><?php echo traducir('posY'); ?> </label>
                                      <input type="text" class=" form-control limp" id="posY" name="posY">
                                  </div>
                              </div>                              
                          </div>
                      </div>
                      <div class="col-md-6">
                       <div class="row">
                         <div id="mapaequipo" name="mapaequipo" style="width: 100%;"></div>
                       </div> 
                      </div>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="card-footer">
              <div class="row">
                  <div class="col-md-3 offset-md-6">
                      <button style="width:100%" data-toggle="modal" data-target="#modalEquipo" class="btn btn-sm btn-round btn-default"><?php echo traducir('Cerrar'); ?> </button>
                  </div>
                   <div class="col-md-3">    
                      <button style="width:100%" onclick="guardarEquipo()" class="btn btn-sm btn-round btn-rose"><?php echo traducir('Guardar'); ?> </button>
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

  <div class="modal fade" id="modalSincronizar" tabindex="-1" role="dialog" aria-hidden="true" style="background-color: hsl(0deg 0% 0% / 56%);">
    <div class="modal-dialog" style="max-width: 50%;">
      <div class="modal-content">
        <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
              <div class="card-header card-header-icon card-header-rose">
              <div class="card-icon">
                <i class="material-icons">local_atm</i>
              </div>
              <h4 class="card-title"><?php echo traducir('Sincronizar con la Máquina'); ?> </h4>
              </div>            
            <div class="card-body ">
              <div class="card-content" style="height: 300px">
                  <div class="row">
                    <input type="hidden" id="txtSerie">
                    <input type="hidden" id="txtIdEquipo">
                     <p style="font-size: medium;margin-left: 20px;color: crimson;"><?php echo traducir('Fecha de última sincronización'); ?>:<span style="font-size: initial;margin-left: 20px;" class="limp" id="spUltimo" name="spUltimo"></span></p>
                    <div class="col-lg-12 col-md-12">
                        <div class="card-body table-responsive">
                          <div class="col-md-4">
                            <label class="bmd-label-floating"><?php echo traducir('Seleccione rango de fechas'); ?> </label>
                            <input value="" type="text" class="form-control datetitle" placeholder="Filtros" id="rangofechas" name="rangofechas" autocomplete="off" data-date-autoclose="true" data-date-format="dd/mm/yyyy" readonly/>
                          </div>
                          <div class="col-md-1">
                          </div>
                          <div class="col-md-4">
                            <span class="limp" id="spUltimo" name="spUltimo"></span>
                          </div>  
                              <div id="divResultado" style="margin-top: 40px;display: none;" class="alert alert-success" role="alert">
                                <span style="font-size: x-large;"><?php echo traducir('Actualizado con éxito!!'); ?> </span><br><span style="font-size: large;" class="limp" id="spResultado" name="spResultado"></span>
                              </div>
                        </div>
                    </div>
                  </div>
              </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-3 offset-md-6">
                    <button style="width:100%" data-toggle="modal" data-target="#modalSincronizar" class="btn btn-sm btn-round btn-default"><?php echo traducir('Cerrar'); ?> </button>
                </div>
                <div class="col-md-3">
                  <button style="width:100%" onclick="Sincronizar_Mensajes()" class="btn btn-sm btn-round btn-rose"><?php echo traducir('Sincronizar'); ?> </button>
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
</div>

 <?php
require_once '../Utilidades/pie.php';
?>
<script type="text/javascript" src="../../inc/autocompletejs/autocomplete.jquery.min.js"></script>
<script type="text/javascript" src="../../inc/leaflet/leaflet.js"></script>
<script type="text/javascript" src="../equipos/js/equipos.js?v=1.6"></script>
</body>

</html>