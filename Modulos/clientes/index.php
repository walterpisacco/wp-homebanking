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

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-icon card-header-rose">
            <div class="card-icon">
              <i class="material-icons">person_outline</i>
            </div>
            <h4 class="card-title"><?php echo traducir('Clientes'); ?> 
            <button class="btn btn-sm btn-round btn-reddit" onClick="AgregaCliente();">
                  <?php echo traducir('AGREGAR'); ?>
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

  <div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="modalClienteLabel" aria-hidden="true" style="background-color: hsl(0deg 0% 0% / 56%);">
    <div class="modal-dialog" style="min-width: 90%;">
      <div class="modal-content">
        <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-icon card-header-rose">
            <div class="card-icon">
              <i class="material-icons">perm_identity</i>
            </div>
            <h4 class="card-title"><?php echo traducir('Cliente'); ?></h4>
            </div>
            <div class="card-body ">
                <div class="">
                    <div class="card-content">
                    <form id ="formCliente">
                        <input type="hidden" id="idCliente" name="idCliente">
                        <div class="row">
                            <div class="col-md-4">
                                 <div class="form-group label-floating">
                                    <label class="bmd-label-floating" for="dni"><?php echo traducir('Nombre'); ?></label>
                                    <input type="text" class=" form-control limp fieldRequired" id="nombre" name="nombre">
                                </div>
                            </div>
                            <div class="col-md-4">
                                 <div class="form-group label-floating">
                                    <label class="bmd-label-floating"><?php echo traducir('Razón Social'); ?></label>
                                    <input type="text" class="valid form-control limp" id="razon" name="razon" value="">
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>                            
                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <select name="estado" id="estado" class="selectpicker" data-style="btn btn-info btn-round">
                                        <option value="1"><?php echo traducir('Cliente Activo'); ?></option>
                                        <option value="2"><?php echo traducir('Cliente Inactivo'); ?></option>
                                   </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                 <div class="form-group label-floating">
                                    <label class="bmd-label-floating"><?php echo traducir('Dirección'); ?></label>
                                    <input type="text" class="form-control limp" id="direccion" name="direccion" value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                 <div class="form-group label-floating">
                                    <label class="bmd-label-floating"><?php echo traducir('Teléfono'); ?></label>
                                    <input type="text" class="form-control limp" id="telefono" name="telefono" value="">
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group label-floating">
                                    <label class="bmd-label-floating">Email</label>
                                    <input type="mail" class="form-control limp fieldRequired" id="mail" name="mail">
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>

                <div class="col-md-6 ml-auto mr-auto">
                  <div id="worldMap" style=""></div>
                </div>
            </div>
            <div class="card-footer">
              <div class="row">
                  <div class="col-md-12">
                    <a data-toggle="modal" data-target="#modalCliente" class="btn btn-sm btn-round btn-default"><?php echo traducir('Cerrar'); ?></a>
                    <span onclick="guardarCliente()" class="btn btn-sm btn-round btn-rose"><i class="fa fa-save"></i><?php echo traducir('Guardar'); ?></span>
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
    <div class="modal-dialog" style="max-width: 50%;">
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
                                <div class="card-text">
                                  <h4 class="card-title"><span id="spCliente" name="spCliente"></span></h4>
                                  <input type="hidden" id="txtIdCliente" name="txtIdCliente" class="limp" />
                                </div>
                              </div>
                              <div class="card-body table-responsive">
                                <div id="divBuscaSerie" name="divBuscaSerie" class="input-group no-border col-lg-6 col-md-6">
                                  <input type="text" id="txtSerie" name="txtSerie" class="form-control limp" placeholder="Buscar Nro serie para asignar...">
                                  <button type="button" id="btnBuscarCaja" name="btnBuscarCaja" class="btn btn-green btn-round btn-just-icon">
                                    <i class="material-icons">search</i>
                                    <div class="ripple-container"></div>
                                  </button>
                                </div>             
                                <table class="table table-hover">
                                  <thead class="text-warning" style="background-color: whitesmoke;">
                                    <th><?php echo traducir('Serie'); ?></th>
                                    <th><?php echo traducir('Tipo'); ?></th>
                                    <th><?php echo traducir('Estado'); ?></th>
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
                  <div class="col-md-12">
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

<?php
require_once '../Utilidades/pie.php';
?>
<script type="text/javascript"  src="../clientes/js/clientes.js?v=1.5"></script>
