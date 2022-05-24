<?php
require_once '../Utilidades/cabecera.php';
?>

  <!-- End Google Tag Manager -->
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
            <h4 class="card-title"><?php echo traducir('Usuarios'); ?>
            <button class="btn btn-sm btn-round btn-reddit" onClick="AgregaPersona();">
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

  <div class="modal fade" id="modalPersonaSeg" tabindex="-1" role="dialog" aria-labelledby="modalPersonaLabel" aria-hidden="true" style="background-color: hsl(0deg 0% 0% / 56%);">
    <div class="modal-dialog" style="min-width: 50%;">
      <div class="modal-content">
        <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-icon card-header-rose">
            <div class="card-icon">
              <i class="material-icons">perm_identity</i>
            </div>
            <h4 class="card-title"><?php echo traducir('Seguridad'); ?></h4>
            </div>
            <div class="card-body ">
                <div class="">
                    <div class="card-content">
                        <h4 class="card-title"></h4>
                    <form id ="formPersonaSeg" name="formPersonaSeg">
                        <input type="hidden" id="idPersonaSeg" name="idPersonaSeg">
                        <input type="hidden" id="idUsuario" name="idUsuario">
<?php  if(BuscarPerfil(1)){//1 Super Administrador ?>
                        <div class="row">                        
                          <div class="col-md-6">
                               <div class="form-group label-floating">
                                  <select id="cliente" name="cliente"  class="selectpicker" data-style="btn btn-info btn-round">
                                  </select>  
                              </div>
                          </div>
                        </div>  
<?php } ?>  
                        <div class="row">                        
                            <div class="col-md-3">
                                 <div class="form-group label-floating">
                                    <label class="bmd-label-floating"><?php echo traducir('Nombre'); ?></label>
                                    <input type="text" class="valid form-control limp fieldRequired" id="nombre" name="nombre" value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                 <div class="form-group label-floating">
                                    <label class="bmd-label-floating"><?php echo traducir('Apellido'); ?></label>
                                    <input type="text" class="valid form-control limp fieldRequired" id="apellido" name="apellido" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="bmd-label-floating"><?php echo traducir('Email'); ?></label>
                                    <input type="mail" class="form-control limp fieldRequired" id="mail" name="mail">
                                </div>
                            </div>
                        </div>
                        <div class="row">                        
                        <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                 <div class="form-group label-floating">
                                    <label class="bmd-label-floating"><?php echo traducir('Nombre de Usuario'); ?></label>
                                    <input type="text" class="valid form-control limp fieldRequired" id="usuario" name="usuario" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group label-floating">
                                    <select name="perfil" id="perfil" class="selectpicker" data-style="btn btn-info btn-round">
<?php  if(BuscarPerfil(1)){//1 Super Administrador ?>                                      
                                        <option value="1"><?php echo traducir('Super Administrador'); ?></option>
<?php } ?>                                          
                                        <option value="2"><?php echo traducir('Administrador Local'); ?></option>
                                        <option value="3"><?php echo traducir('Consulta'); ?></option>
                                   </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group label-floating">
                                    <select name="estadoSeg" id="estadoSeg" class="selectpicker" data-style="btn btn-info btn-round">
                                        <option value="1"><?php echo traducir('Usuario Activo'); ?></option>
                                        <option value="0"><?php echo traducir('Usuario Inactivo'); ?></option>
                                   </select>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" style="display: none" id="btnRestablece" name="btnRestablece" class="btn btn-sm btn-round btn-reddit"><?php echo traducir('REESTABLECER CLAVE'); ?></button>
                            </div>
                            <div class="col-md-6">
                                <div style="min-width:220px" id="chkLang" class="make-switch" data-text-label="Ver Categorías" data-on-label="Si" data-off-label="No">
                                <input type="checkbox" checked/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button style="display: none" id="btnElimina" name="btnElimina" class="btn btn-sm btn-round btn-danger"><?php echo traducir('Eliminar el usuario'); ?></button>
                            </div>
                        </div>                        
                    </form>
                    </div>
                </div>
            </div>
            <div class="card-footer">
              <div class="row">
                  <div class="col-md-12">
                    <a data-toggle="modal" data-target="#modalPersonaSeg" class="btn btn-sm btn-round btn-default"><?php echo traducir('Cerrar'); ?></a>
                    <span onclick="guardarPersonaSeg()" class="btn btn-sm btn-round btn-rose"><i class="fa fa-save"></i><?php echo traducir('Guardar'); ?></span>
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

 <?php
require_once '../Utilidades/pie.php';
?>
<script type="text/javascript"  src="../personas/js/personas.js?v=1.4"></script>
</body>

</html>