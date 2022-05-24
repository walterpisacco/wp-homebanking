<!doctype html> 
<html lang="en">
<head> 
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="img/logo.png" />
    <link rel="icon" type="image/png" href="img/logo.png" />
    <title>Cajas Inteligentes</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/material-dashboard.css" rel="stylesheet" />
    <link href="css/demo.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"  rel="stylesheet" type="text/css"/>
    
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
</head>  
<body> 
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="img/login.jpeg">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                             <form>
                                <input type="hidden" name="_token" value="4T4AAdD2dy5ZKFeLaUFGAHRAhfZK49xbpEuE4JXW">
                                <div class="card card-login card-hidden" style="  background: #fff;">
                                    <div class="card-header text-center" style="background:#2a2a2a;border-top-right-radius:7px;border-top-left-radius: 7px;">
                                        <h4 class="card-title">
                                            <img src="img/logo-small.png" alt="">
                                        </h4>
                                    </div>
                                    <p class="category text-center"></p>
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="bmd-label-floating">Nombre de Usuario</label>
                                                <input type="email" id="txtUsuario" class="form-control" value="Admin" required autofocus>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="bmd-label-floating">Contraseña</label>
                                               <span class="mdi mdi-eye" id="mostrar"> <span class="pwdtxt" style="cursor:pointer;">(Mostrar)</span></span>
                                                <input type="password" id="txtPassword" class="form-control " value="" required autofocus>                                         
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <button id="btnenviar" type="button" class="btn btn-rose btn-primary">
                                            Ingresar
                                        </button>

                                        </div>
                                    <!--<div align="center">o bien utiliza</div>
                                    <div class="social-line">
                                            <a href="/redirectFacebook" class="btn btn-just-icon btn-round btn-facebook">
                                                <i class="fa fa-facebook"> </i>
                                            </a>
                                            <a href="/redirect"  class="btn btn-just-icon btn-round btn-google">
                                                <i class="fa fa-google"> </i>
                                            </a>
                                        </div> -->
                                </div>
                            </form>
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
<script src="js/bootstrap-tagsinput.min.js"></script>
<script src="js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="js/material.min.js" type="text/javascript"></script>
<script src="js/material-dashboard.js"></script>
<script src="js/bootbox.js"></script>

<script src="js/demo.js"></script>
<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();
        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });

    $('#btnenviar').on('click', function() { 
        usuario = $('#txtUsuario').val();
        password = $('#txtPassword').val();
        $.ajax({url:'Modulos/login/Search/login.php',
            dataType:'json',
            type:'POST',
            data:{usuario:usuario,password:password},
            success : function(data) {
                if (data.Success == 'true' && data.forzar == 0){
                    localStorage.setItem("idCliente",data.idCliente);
                    localStorage.setItem("usuario",usuario);
                    localStorage.setItem("sesion",(Math.floor(Math.random() * 1000) + 1));
                    location.href="Modulos/panel/index.php";
                }
                if (data.Success == 'true' && data.forzar == 1){
                    location.href="forzarCambio.php?usu="+usuario+"&mail="+data.mail;
                }
                if (data.Success == 'false'){
                    bootbox.alert({ message:'Error usuario/contraseña incorrecto, intente nuevamente',backdrop: true});
                }
            }});
    });

  $('#mostrar').click(function(){
      if($(this).hasClass('mdi-eye') && ($("#password").val() != "")){
          $('#txtPassword').removeAttr('type');
          $('#mostrar').addClass('mdi-eye-off').removeClass('mdi-eye');
          $('.pwdtxt').html("(Ocultar)");
      }else{
          $('#txtPassword').attr('type','password');
          $('#mostrar').addClass('mdi-eye').removeClass('mdi-eye-off');
          $('.pwdtxt').html("(Mostrar)");
      }
    });  

  $('#txtPassword').keyup(function(e){ 
      if(e.keyCode == 13){
          $('#btnenviar').click();
      }
    });          
</script>

</html>