<?php
require_once '../Utilidades/cabecera.php';
?>

</head>

  <div class="wrapper ">
  <?php
  require_once '../Utilidades/nav-izquierda.php';
  ?>
    <div class="main-panel">

  <?php
  require_once '../Utilidades/nav-top.php';
  ?>
<meta charset="UTF-8">

   <body class="">

    <div class="content">
      <div class="body">
          <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card card-wizard" data-color="orange" id="wizardProfile">
                  <form id="frmPerfil" name="frmPerfil"  autocomplete="off">
                    <div class="card-header text-center">
                        <input type="hidden" name="_token" id="_token" value="4T4AAdD2dy5ZKFeLaUFGAHRAhfZK49xbpEuE4JXW">
                      <h3 class="card-title"><?php echo traducir('Completa tu Perfil'); ?></h3>
                      <h5 class="card-description"><?php echo traducir('Esta información nos permitirá saber mas sobre tí'); ?>.</h5>
                    </div>
                    <div class="wizard-navigation">
                      <ul class="nav nav-pills">
                        <li class="nav-item">
                          <a class="nav-link active" href="#about" data-toggle="tab" role="tab">
                            <?php echo traducir('Tus Datos'); ?>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#account" data-toggle="tab" role="tab">
                            <?php echo traducir('Tu Cuenta'); ?>
                          </a>
                        </li>                        
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="tab-pane active" id="about">
                          <div class="row">
                            <div class="col-sm-3">
                              <div class="picture-container">
                                <div class="picture">
                                  <img style="cursor: initial;" src="../../img/faces/avatar.jpg" class="picture-src" id="wizardPicturePreview" title="" />
                                  <!--input type="file" id="wizard-picture"-->
                                </div>
                                <!--h6 class="description">Elegir Foto</h6-->
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="input-group form-control-lg">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons">face</i>
                                  </span>
                                </div>
                                <div class="form-group">
                                  <label for="txtNombre" class="bmd-label-floating"><?php echo traducir('Nombre'); ?></label>
                                  <input readonly type="text" class="form-control limp" id="Nombre" name="Nombre" required>
                                </div>
                              </div>
                              <div class="input-group form-control-lg">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons">record_voice_over</i>
                                  </span>
                                </div>
                                <div class="form-group">
                                  <label for="txtApellido" class="bmd-label-floating"><?php echo traducir('Apellido'); ?></</label>
                                  <input readonly type="text" class="form-control limp" id="Apellido" name="Apellido" required>
                                </div>
                              </div>
                              <div class="input-group form-control-lg">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons">email</i>
                                  </span>
                                </div>
                                <div class="form-group">
                                  <label for="email" class="bmd-label-floating"><?php echo traducir('Email'); ?></label>
                                  <input type="email" class="form-control limp" id="email" name="email" required>
                                </div>
                              </div>                              
                            </div>
                            <div class="col-sm-4">
                              <div class="input-group form-control-lg">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons">call</i>
                                  </span>
                                </div>
                                <div class="form-group">
                                  <label for="txtNombre" class="bmd-label-floating"><?php echo traducir('Teléfono'); ?></label>
                                  <input type="text" class="form-control limp" id="Telefono" name="Telefono">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="account">
                          <div class="row justify-content-center">
                            <div class="col-lg-11">
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="choice" data-toggle="wizard-checkbox">
                                    <input type="checkbox" name="jobb" value="Design">
                                    <div class="icon">
                                      <i class="fa fa-id-badge"></i>
                                    </div>
                                    <h6><span id="spUsuario" name="spUsuario"></span></h6>
                                  </div>
                                </div>                              
                                <div class="col-sm-4">
                                  <div class="choice" data-toggle="wizard-checkbox">
                                    <input type="checkbox" name="jobb" value="Design">
                                    <div class="icon">
                                      <i class="fa fa-key"></i>
                                    </div>
                                    <h6><span id="spPerfil" name="spPerfil"></span></h6>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                              <div class="input-group form-control-lg">
                                <div class="form-group">
                                  <label for="pass" class="bmd-label-floating"> <?php echo traducir('Nueva Contraseña'); ?></label>
                                  <input type="password" class="form-control limp" id="pass" name="pass" autocomplete="new-password">
                                </div>
                              </div>
                              <div class="input-group form-control-lg">
                                <div class="form-group">
                                  <label for="exampleInput11" class="bmd-label-floating"> <?php echo traducir('Repite Contraseña'); ?></label>
                                  <input type="password" class="form-control limp" id="pass1" name="pass1" >
                                </div>
                              </div> 
                              <div class="form-control-lg">
                                 <h6 class="info-text"><?php echo traducir('Dejar en blanco para mantener la contraseña actual'); ?></h6> 
                              </div> 
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>                        
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="mr-auto">
                        <input type="button" class="btn btn-previous btn-round btn-default btn-wd disabled" name="previous" value="Anterior">
                        <input type="button" id="btnNext" class="btn btn-next btn-round btn-rose btn-wd" name="next" value="Siguiente">
                        <input type="button" class="btn btn-finish btn-round btn-rose btn-wd" id="finish" name="finish" value="Finalizar" style="display: none;">
                      </div>
                    </div>
                  </form>
                </div>
           </div>
          </div>
        </div>
      </div>
<?php
require_once '../Utilidades/pie.php';
?>
<script type="text/javascript"  src="js/index.js?v=1.0"></script>