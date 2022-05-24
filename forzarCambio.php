<!doctype html> 
<html lang="en">
<head> 
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="img/logo.png" />
    <link rel="icon" type="image/png" href="img/logo.png" />
    <title>La Guardiana</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/material-dashboard.css" rel="stylesheet" />
    <link href="css/demo.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
</head>  
<body> 
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="img/login.jpeg">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-6 col-md-offset-4 col-sm-offset-2">
                             <form>
                                <input type="hidden" name="_token" id="_token" value="4T4AAdD2dy5ZKFeLaUFGAHRAhfZK49xbpEuE4JXW">
                                <div class="card card-login card-hidden" style="  background: #fff;">
                                    <p class="category text-center"></p>
                                    <div class="card-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="_usu" id="_usu" value="<?php echo $_REQUEST['usu'];?>">
                                            <span class=""><h4><b>Verifique su correo electrónico</b></h4></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>
                                            <span class=""><h5>Nosotros le enviamos un código de verificación a</span>
                                            <span class=""><b><?php echo $_REQUEST['mail'];?></b></span>
                                            <span class="">. Por favor ingreselo</h5></span>
                                            </p>
                                            <p>
                                            <span class=""><h5>Algunos correos enviados por nosotros pueden haber sido bloqueados por su proveedor de correo. Si usted no ve nuestro email en su bandeja de entradas, verifique su carpeta de spam</h5></span>
                                            </p>                                            

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">vpn_key</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <input type="hidden" id="txtHash" name="txtHash" class="form-control">
                                                <label class="bmd-label-floating">Ingrese el Código</label>
                                                <input style="font-size: x-large;" type="text" id="txtCodigo" name="txtCodigo" class="form-control" value="" required autofocus>
                                            </div>
                                        </div>
                                    </div>
                                     </div>
                                    <div class="footer text-center">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button style="width: 90%;color: black" id="btnverificaCod" name="btnverificaCod" type="button" class="btn btn-warning">
                                                    Verificar
                                                </button>
                                            </div>
                                        </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <span class="">¿Esta mal su correo electrónico? por favor comuniquese con nosotros</span>
                                        </div>
                                    </div>
                                        </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

  <div class="modal fade" id="modalNueva" tabindex="-1" role="dialog" aria-labelledby="modalNueva" aria-hidden="true" style="background-color: hsl(0deg 0% 0% / 56%);">
    <div class="modal-dialog" style="max-width: 40%;">
      <div class="modal-content">
        <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-icon card-header-rose">
            <div class="card-icon">
              <i class="material-icons">vpn_key</i>
            </div>
              <small class="category">(ingresar mas de 6 carateres, incluyendo al menos 1 número y 1 mayúscula.)</small>
            </h4>
            </div>
            <div class="card-body ">
                <div class="">
                    <div class="card-content">
                        <h4 class="card-title"></h4>
                    <form id ="formPersonaSeg" name="formPersonaSeg">
                        <input type="hidden" id="idPersonaSeg" name="idPersonaSeg">
                        <input type="hidden" id="idUsuario" name="idUsuario">
                        <div class="row">
                            <div class="col-md-12">
                                 <div class="form-group label-floating">
                                    <label class="bmd-label-floating">Ingrese contraseña</label>
                                    <input style="font-size: x-large;" type="password" class="valid form-control limp" id="pass1" name="pass1" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                 <div class="form-group label-floating">
                                    <label class="bmd-label-floating">Reingrese contraseña</label>
                                    <input style="font-size: x-large;" type="password" class="valid form-control limp" id="pass2" name="pass2" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button style="width: 100%;color: black" id="btnEstablecer" type="button" class="btn btn-success">
                                    Establecer
                                </button>
                            </div>
                        </div> 
                    </form>
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


</body>
<!--   Core JS Files   -->
<script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/material.min.js" type="text/javascript"></script>
<script src="js/material-dashboard.js"></script>
<script src="js/bootbox.js"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="js/demo.js"></script>
<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();
        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });

    $('#btnverificaCod').on('click', function() { 
        cod = $('#txtCodigo').val();
        token = $('#_token').val();
        usu = $('#_usu').val();
        if (token == '4T4AAdD2dy5ZKFeLaUFGAHRAhfZK49xbpEuE4JXW'){
            $.ajax({url:'Modulos/login/Search/verificaCodigo.php',
                dataType:'json',
                type:'POST',
                data:{cod:cod,usu:usu},
                success : function(data) {
                    if (data.Success == 'true'){
                        $('#txtHash').val(data.Hash);
                        $('#modalNueva').modal('show');
                    }else{
                        bootbox.alert({ message:'Codigo incorrecto',backdrop: true});
                    }
                }});
            }
        });
$('#btnEstablecer').on('click',function(){
        usu = $('#_usu').val();
        hash = $('#txtHash').val();
        pass = $('#pass1').val();
        if (hash != ''){
            $.ajax({url:'Modulos/login/Search/cambiarClave.php',
                dataType:'json',
                type:'POST',
                data:{usu:usu,hash:hash,pass,pass},
                success : function(data) {
                    if (data.Success == 'true'){
                        $('#modalNueva').modal('hide');
                        location.href="index.php";

                    }else{
                        bootbox.alert({ message:'Codigo incorrecto, verifique su casilla de correo',backdrop: true});
                    }
                }});
            }

});

</script>

</html>