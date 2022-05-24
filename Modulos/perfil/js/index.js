abrirPerfil();

$(document).ready(function() {
     demo.initMaterialWizard();
    setTimeout(function() {
      $('.card.card-wizard').addClass('active');
    }, 600);

    $('.card.card-wizard').bootstrapWizard({
      tabClass: 'nav nav-pills',
      onNext: function(tab, navigation, index) {
        alert('next');
        }
    });
    $('#btnNext').removeClass('disabled');
    $('#btnNext1').removeClass('disabled');

});

  function abrirPerfil(){
        $('#modalPerfil').modal('show');
      toggleGifLoad();        
        $.ajax({url:'Search/PerfilDetalle_get.php',data:{},type:'POST',dataType:'json',async:true})
        .always(toggleGifLoad)
        .done(function(result){
         if (result.Success == 'true'){
          cargarDetallePerfil(result);
         }
       });
      }

  function cargarDetallePerfil(data){
    limpiar();
    $('#Nombre').val(data.nombre);
    $('#Apellido').val(data.apellido);
    $('#email').val(data.mail);
    $('#Telefono').val(data.telefono);
    $('#spUsuario').text(data.usuario);
    $('#spPerfil').text(data.perfil);
    $('#nombreEmp').val(data.nombreEmp);
    $('#razonEmp').val(data.razonEmp);
    $('#dirEmp').val(data.dirEmp);
    $('#telEmp').val(data.telEmp);
    $('#emailEmp').val(data.emailEmp);  
  }

  $('#finish').click(function() {
    if($('#pass').val() != $('#pass1').val()){
      bootbox.alert({ message:TraducirFrase('LAS CONTRASEÑAS INGRESADAS NO COINCIDEN'),backdrop: true});
      return;
    }
      dataform = $('#frmPerfil  :input').serialize().replace(/["']/g, "");
      toggleGifLoad();
      $.ajax({url:'Search/PerfilGrabar.php',data:dataform,type:'POST',dataType:'json',async:true})
      .always(toggleGifLoad)
      .done(function(result){
       if (result.Success == 'true'){
          bootbox.alert({ message:TraducirFrase(result.Text),backdrop: true});
       }
    });

 });


function limpiar(){
	$('.limp').val('');
	$('.limp').text('');
}


