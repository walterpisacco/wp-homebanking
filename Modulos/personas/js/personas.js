$(document).ready(function() {
	var formBuscar = $('#searchbox-events'),
	tbDatos = $("#tblDatos").jqGrid({
	    styleUI : 'Bootstrap',
		responsive : true,
		datatype : 'local',
		mtype : 'POST',
	    colNames: ['idPersona','Cliente','Perfil','Usuario','Apellido','Nombres', 'DNI','Email','Telefono','Estado',''],
	    colModel: [{name: 'IdPersona',index: '1',width: 0,align: 'center',hidden: true},
	               {name: 'Cliente',index: '2',width: 100,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'Perfil',index : '3',width : 60,search:true,align : 'left',editable : true,sortable:true,editoptions : {size : 20,disabled : 'disabled'},search : true,formoptions : {elmsuffix : "(*)",rowpos : 2}},
	               {name: 'Usuario',index: '4',width: 70,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'Apellido',index: '5',width: 80,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'Nombres',index: '6',width: 80,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:3}},
	               {name: 'DNI',index: '7',hidden: true,width: 150,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:4}},
	               {name: 'email',index: '8',width: 80,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'telefono',hidden: true,index: '9',width: 70,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:false,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'estado',hidden: false,index: '10',width: 70,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:false,formoptions:{elmsuffix:"(*)",rowpos:2}},
	         	   {name: 'acciones',index: '10',width: 50,align: 'left',editable:false,editoptions: {readonly: "readonly"}}], 
	               pager: '#pagDatos',
	    rowNum : 10,
	  //  altRows: true,
		autowidth : true,
		height : 'auto',
		rownumbers : false,
		rowList : [ 10, 20, 30 ],
		sortname : 2,
		sortorder : 'ASC',
		viewrecords : true,
		gridview : true,
		caption : '',
		shrinkToFit : true,
		cellEdit: false,
       	cmTemplate : {
			'sortable' : false,
			'resize' : false,
			'editable' : true,
			'search' : false
		},
		rowattr:function(rowData){
		   if(rowData.estado == "Eliminado") return {"style":"color: lightcoral;"};
	    },
		loadComplete : function() {
		    $("tr.jqgrow:odd").addClass('myAltRowClassEven');
		    $("tr.jqgrow:even").addClass('myAltRowClassOdd');
		},
		loadError : function(xhr, st, err) {
			jQuery("#rsperror").html("Type: " + st + "; Response: "+ xhr.status + " " + xhr.statusText);
		}, /**/
		gridComplete : function(){
			$('#wrapper').on('toggle-out toggle-in',
					function(e) {
						tbDatos.trigger('resize');
					});
		}
	}).navGrid('#pagDatos', {edit : false,add : false,del : false,view : false,search : false,refresh : true})
	.jqGrid('filterToolbar',{searchOnEnter:true,stringResult:true});;
	$('.ui-search-clear').css('display','none')

	function BuscarPersonas() {
		  var fields = formBuscar.find(':input').serializeArray();
	      var postdata = tbDatos.jqGrid('getGridParam', 'postData');
			    postdata.filters = formatFilter(fields);//La funcion esta en fngenerales
		        tbDatos.jqGrid('setGridParam', {
		        datatype: 'json', url: 'Search/PersonasList_get.php',
				async:true,
	          stringResult: true,search: true,postData: postdata,page:1
	      }).trigger('reloadGrid');
	}

	$.ajax({url:'../Utilidades/Search/Combo_get.php',data:{tipo:'CLIENTES',param:''},type:'POST',dataType:'json',async:true})
	.done(function(result){
		 if (result[0].Success == 'true'){
			$.each( result, function( key, value ) {
				$('#cliente').append('<option selected value="'+value.Codigo+'">'+value.Descripcion+'</option>');
			});
            $('#cliente').selectpicker('refresh');
		 }
	 });

	if(isMobile.any()) {
		$("#tblDatos").hideCol("Cliente");
		$("#tblDatos").hideCol("Perfil");
		//$("#tblDatos").hideCol("Apellido");
		$("#tblDatos").hideCol("Nombres");
		$("#tblDatos").hideCol("email");
		$("#tblDatos").hideCol("estado");
		$("#tblDatos").setGridWidth($(window).width()-70); 
	}

	BuscarPersonas();
	TraducirGrilla();	
});	

function AgregaPersona(){
	limpiar();
	$('#modalPersonaSeg').modal('show');
	$('#idUsuario').val(0);
	$('#btnRestablece').css('display','none');
	$('#btnElimina').css('display','none');
	$(".label-floating").each(function() {
	    $(this).removeClass('is-filled');
   	});
   	
}

/**
 * Funcion que guarda la edicion del ticket
 */
function EliminarPersona(id) { 
		bootbox.confirm({
	    message: messageDel,
	    locale: locale,	
		    buttons: {
		        confirm: {
		            label: 'Aceptar',
		            className: 'btn-danger'
		        },
		        cancel: {
		            label: 'Cancelar',
		            className: 'btn-default'
		        }
		    },
		    callback: function (result) {
			    if(result == true){
			    	Eliminar(id);
			    }
		    }
		});
};

function Eliminar(id){
	toggleGifLoad();
		$.ajax({url:'Search/PersonaEliminar.php',
			data : {id : id},
			type:'POST',dataType:'json',async:true})
		 .always(toggleGifLoad)
		 .done(function(result){
			 if (result.Success == 'true'){
			 	$('#tblDatos').trigger("reloadGrid");
			 	bootbox.alert({ message:TraducirFrase(result.Text),backdrop: true});
			 }
		 });
}


function cargarDetalle(data){
	$('#idPersona').val(data.idPersona);
	$('#apellido').val(data.apellido);
	$('#cuil').val(data.cuil);
	$('#dni').val(data.dni);
	$('#fechaNac').val(data.fecNac);
	
	$('#estado option[value='+data.estado+']').prop('selected', true);
	$('#select2-estado-container').text( $('#estado option:selected').text());
	$('#estado').selectpicker('refresh');

	$('#genero option[value='+data.genero+']').prop('selected', true);
	$('#select2-genero-container').text( $('#genero option:selected').text());
	$('#genero').selectpicker('refresh');	

	$('#nacionalidad option[value='+data.nacionalidad+']').prop('selected', true);
	$('#select2-nacionalidad-container').text( $('#nacionalidad option:selected').text());
	 $('#nacionalidad').selectpicker('refresh');	

	$('#mail').val(data.mail);
	$('#nombre').val(data.nombre);

	$(".label-floating").each(function() {
	    $(this).addClass('is-filled');
   	});
}

function limpiar(){
	$('.limp').val('');
	$('#idPersona').val(0);
	$('#cliente option[value=-1]').prop('selected', true);
	$('#select2-cliente-container').text( $('#cliente option:selected').text());
	 $('#cliente').selectpicker('refresh');	
}

function SeguridadPersona(id){
	toggleGifLoad();
		$.ajax({url:'Search/SeguridadEditar_get.php',
			data : {id : id},
			type:'POST',dataType:'json',async:true})
		 .always(toggleGifLoad)
		 .done(function(result){
			 	$('#modalPersonaSeg').modal('show');
			 	cargarDetalleSeg(result);
		 });
}

function cargarDetalleSeg(data){
	$('.limp').val('');
	$('#idPersonaSeg').val(data.idPersona);
	if(data.Success == 'true'){
		$('#idUsuario').val(data.idUsuario);
		$('#usuario').val(data.usuario);
		$('#nombre').val(data.nombre);
		$('#apellido').val(data.apellido);
		$('#mail').val(data.mail);

		$('#cliente option[value='+data.idCliente+']').prop('selected', true);
		$('#select2-cliente-container').text( $('#cliente option:selected').text());
		$('#cliente').selectpicker('refresh');

		$('#perfil option[value='+data.perfil+']').prop('selected', true);
		$('#select2-perfil-container').text( $('#perfil option:selected').text());
		$('#perfil').selectpicker('refresh');		

		$('#estadoSeg option[value='+data.estado+']').prop('selected', true);
		$('#select2-estadoSeg-container').text( $('#estadoSeg option:selected').text());
		$('#estadoSeg').selectpicker('refresh');
		$('#btnRestablece').css('display','');

		$(".label-floating").each(function() {
		    $(this).addClass('is-filled');
	   	});
	}
}


function guardarPersonaSeg() {
		bootbox.confirm({
	    message: messageSave,
	    locale: locale,	
		    buttons: {
		        confirm: {
		            label: 'Aceptar',
		            className: 'btn-danger'
		        },
		        cancel: {
		            label: 'Cancelar',
		            className: 'btn-default'
		        }
		    },
		    callback: function (result) {
			    if(result == true){
			    	if (validateFields($('#formPersonaSeg :input').not('button'))){
				    	bootbox.alert({ message:TraducirFrase('Los campos marcados, son obligatorios'),backdrop: true});
				    	return;
				    }				    	
			    	var dataform = {};
			    	dataform = $('#formPersonaSeg  :input').serialize().replace(/["']/g, "");
			    	GrabarSeg(dataform);
			    }
		    }
		});
};

function GrabarSeg(dataform){
	toggleGifLoad();
		$.ajax({url:'Search/SeguridadGuardar.php',
			data:dataform,
			type:'POST',dataType:'json',async:true})
		 .always(toggleGifLoad)
		 .done(function(result){
			 if (result.Success == 'true'){
			 		$('#tblDatos').trigger("reloadGrid");
			 		$('#modalPersonaSeg').modal('hide');
	 				limpiar();
					$(".label-floating").each(function() {
					    $(this).removeClass('is-filled');
				   	});	
			 	if(result.idusuario == -1){ // si edito el usuario lo cierro
					$('#modalPersonaSeg').modal('hide'); 		
			 	}
			 }
			 	bootbox.alert({ message:TraducirFrase(result.Text),backdrop: true});
		 });
}


 $('#btnRestablece').on('click',function(){
 		idUsuario = $('#idUsuario').val();
		bootbox.confirm({
	    message: messageClear,
	    locale: locale,	
		    buttons: {
		        confirm: {
		            label: 'Aceptar',
		            className: 'btn-danger'
		        },
		        cancel: {
		            label: 'Cancelar',
		            className: 'btn-default'
		        }
		    },
		    callback: function (result) {
			    if(result == true){
			    	blanquearClave(idUsuario);
			    }
		    }
		});

 });

/**
 * Funcion que marca forzar clave en 1 
 */
 function blanquearClave(idUsuario){
	toggleGifLoad();
		$.ajax({url:'../login/Search/blanquearClave.php',
			data:{idUsuario:idUsuario},
			type:'POST',dataType:'json',async:true})
		 .always(toggleGifLoad)
		 .done(function(result){
			 if (result.Success == 'true'){
			 		$('#modalPersonaSeg').modal('hide');
	 				limpiar();
					$(".label-floating").each(function() {
					    $(this).removeClass('is-filled');
				   	});	
			 }else{
			 	bootbox.alert({ message:TraducirFrase(result.Text),backdrop: true});
			 }
		 });
 }


