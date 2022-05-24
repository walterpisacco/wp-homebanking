	function BuscarAlertas() {
		$.ajax({url:'../Utilidades/Search/BuscarAlertas.php',
			data : {},
			type:'POST',dataType:'json',async:true})
		 	.done(function(result){
			 if (result.length > 0){
			 	for(let i=0; i< result.length; i++){
			 		notificar(result[i]);
			 	}

			}
		});
	}

	function notificar(mensaje){
	    $.notify({icon: 'add_alert',message: mensaje.mensaje},{
	      // settings
	      element: 'body',
	      position: null,
	      type: "danger",
	      allow_dismiss: true,
	      newest_on_top: false,
	      showProgressbar: false,
	      placement: {
	        from: "top",
	        align: "right"
	      },
	      offset: 20,
	      spacing: 10,
	      z_index: 1031,
	      delay: 0,
	      timer: 50000,
	     // url_target: '_blank',
	      mouse_over: null,
	      animate: {
	        enter: 'animated fadeInDown',
	        exit: 'animated fadeOutUp'
	      },
	      onShow: null,
	      onShown: null,
	      onClose: null,
	      onClosed: null,
	      icon_type: 'class',
	      template: '<div data-notify="container" class="col-xs-11 col-sm-2 alert alert-{0}" role="warning">' +
	        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
	        '<i data-notify="icon" class="material-icons">add_alert</i>' +
	        '<span data-notify="title">'+mensaje.serie+'</span> ' +
	        '<span data-notify="message">{2}</span>' +
	        '<div class="progress" data-notify="progressbar">' +
	          '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
	        '</div>' +
	        '<a href="{3}" target="{4}" data-notify="url"></a>' +
	      '</div>' 
	    }); 
	}

    BuscarAlertas();

    setInterval(BuscarAlertas, 60000);