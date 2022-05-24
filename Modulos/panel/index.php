<?php
require_once '../Utilidades/cabecera.php';
?>
<style>
.card {
    border: 0;
    margin-bottom: 30px;
    border-radius: 6px;
    color: #333;
    background: #fff;
    width: 100%;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
}
.main-panel > .content {
    margin-top: 30px;
}
.card [class*="card-header-"] .card-icon, .card [class*="card-header-"] .card-text {
    padding: 0px;
}
</head>
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

    <div class="content">
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="header text-center">
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="content">
                <div class="content">
                  <div class="container-fluid">
                    </div>
                    <div class="row">
                      <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                          <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                              <i class="material-icons">check_circle_outline</i>
                            </div>
                            <p class="card-category"><?php echo traducir('Máquinas Activas'); ?></p>
                           </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-3">
                                <h3 class="card-title"><b><span serie="" id="spActivas" name="spActivas">0</span></b></h3>
                              </div>
                              <div class="col-md-9">
                                <button class="btn btn-sm btn-round btn-reddit" onClick="verDetalle(1);"><?php echo traducir('DETALLES'); ?></button>
                              </div>
                            </div>
                          </div> 
                          <div class="card-footer">
                            <div class="stats">
                              <i class="material-icons">update</i><?php echo traducir('Ultima actualización'); ?><span id="spHoraA"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                          <div class="card-header card-header-danger card-header-icon">
                            <div class="card-icon">
                              <i class="material-icons">highlight_off</i>
                            </div>
                            <p class="card-category"><?php echo traducir('Máquinas en Error'); ?></p>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-3">
                                <h3 class="card-title"><b><span serie="" id="spEnError" name="spEnError">0</span></b></h3>
                              </div>
                              <div class="col-md-9">
                                <button class="btn btn-sm btn-round btn-reddit" onClick="verDetalle(3);"><?php echo traducir('DETALLES'); ?></button>
                              </div>
                            </div>
                          </div>                          
                          <div class="card-footer">
                            <div class="stats">
                              <i class="material-icons">update</i><?php echo traducir('Ultima actualización'); ?><span id="spHoraE"></span>
                            </div>
                          </div>
                        </div>
                      </div>                      
                      <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                          <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                              <i class="material-icons">history</i>
                            </div>
                            <p class="card-category"><?php echo traducir('Fuera de Linea'); ?></p>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-3">
                                <h3 class="card-title"><b><span serie="" id="spFueraLinea" name="spFueraLinea">0</span></b></h3>
                              </div>
                              <div class="col-md-9">
                                <button class="btn btn-sm btn-round btn-reddit" onClick="verDetalle(2);"><?php echo traducir('DETALLES'); ?></button>
                              </div>
                            </div>
                          </div>                           
                          <div class="card-footer">
                            <div class="stats">
                              <i class="material-icons">update</i><?php echo traducir('Ultima actualización'); ?><span id="spHoraF"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-8">
                        <div class="card card-stats">
                          <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">

                            </div>
                            <p class="card-category"><?php echo traducir('Ultimas 10 Alertas'); ?></p>
                           </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card-body table-responsive">
                                  <table class="table table-hover">
                                    <thead class="text-warning" style="background-color: whitesmoke;">
                                      <th style="text-align: center;"><?php echo traducir('Serie'); ?></th>
                                      <th style="text-align: center;"><?php echo traducir('Fecha'); ?></th>                                      
                                      <th style="text-align: center;"><?php echo traducir('Alerta'); ?></th>
                                      <th></th>
                                    </thead>
                                    <tbody id="tblDatosAlerta" name="tblDatosAlerta">
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                          </div> 
                          <div class="card-footer">
                            <div class="stats">
                              <i class="material-icons">update</i><?php echo traducir('Ultima actualización'); ?><span id="spHoraU"></span>
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
      </div>
    </div>
  </div>
</div>


  <div class="modal fade" id="modalClienteEquipo" tabindex="-1" role="dialog" aria-labelledby="modalClienteEquipoLabel" aria-hidden="true" style="background-color: hsl(0deg 0% 0% / 56%);">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-body ">
                <div class="">
                    <div class="card-content">
                        <div class="row">
                          <div class="col-lg-12 col-md-12">
                              <div class="card-header card-header-text card-header-rose">
                              </div>
                              <div class="card-body table-responsive">
                                <table class="table table-hover">
                                  <thead class="text-warning" style="background-color: whitesmoke;">
                                    <th><?php echo traducir('Serie'); ?></th>
                                    <th><?php echo traducir('Dirección'); ?></th>
                                    <th></th>
                                  </thead>
                                  <tbody id="tblDatosEq" name="tblDatosEq">
                                  </tbody>
                                </table>
                              </div>
                          </div>

                    </div>
                </div>
            </div>
            <div class="card-footer">
              <div class="row">
                  <div class="col-md-12 text-center">
                    <a data-toggle="modal" data-target="#modalClienteEquipo" class="btn btn-sm btn-round btn-default"><?php echo traducir('Cerrar'); ?></a>
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
<?php require_once '../Utilidades/pie.php'; ?>
<script type="text/javascript"  src="js/panel.js?v=1.6"></script>


