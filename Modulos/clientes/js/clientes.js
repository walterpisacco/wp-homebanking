$(document).ready(function() {
	var formBuscar = $('#searchbox-events'),
	tbDatos = $("#tblDatos").jqGrid({
	    styleUI : 'Bootstrap',
		responsive : true,
		datatype : 'local',
		mtype : 'POST',
	    colNames: ['idCliente','Nombre','Razon Social','Email', 'Teléfono','Dirección','Estado',''],
	    colModel: [{name: 'IdCliente',index: '2',width: 0,align: 'center',hidden: true},
	               {name : 'Nombre',index : '3',width : 140,align : 'left',editable : true,sortable:true,editoptions : {size : 20,disabled : 'disabled'},search : true,formoptions : {elmsuffix : "(*)",rowpos : 2}},
	               {name: 'Razon',index: '4',width: 140,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'Email',index: '5',width: 100,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:3}},
	               {name: 'telefono',index: '6',width: 80,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:4}},
	               {name: 'direccion',index: '7',width: 160,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'estado',index: '8',width: 60,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:false,formoptions:{elmsuffix:"(*)",rowpos:2},stype: "select",search:true,searchoptions: { value: "Todos:Todos;1:Activos;2:Inactivos;3:Eliminados" }},
	         	   {name: 'acciones',index: '9',width: 80,align: 'left',editable:false,editoptions: {readonly: "readonly"}}], 
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

	function BuscarClientes() {
		  var fields = formBuscar.find(':input').serializeArray();
	      var postdata = tbDatos.jqGrid('getGridParam', 'postData');
			    postdata.filters = formatFilter(fields);//La funcion esta en fngenerales
		        tbDatos.jqGrid('setGridParam', {
		        datatype: 'json', url: 'Search/ClientesList_get.php',
				async:true,
	          stringResult: true,search: true,postData: postdata,page:1
	      }).trigger('reloadGrid');
	}

	if(isMobile.any()) {
		$("#tblDatos").hideCol("Razon");
		$("#tblDatos").hideCol("Email");
		$("#tblDatos").hideCol("telefono");
		$("#tblDatos").hideCol("direccion");
		$("#tblDatos").hideCol("estado");
		$("#tblDatos").setGridWidth($(window).width()-70); 
	}

	BuscarClientes();
	TraducirGrilla();	

});	

function AgregaCliente(){
	limpiar();
	$('#modalCliente').modal('show');
	
	$(".label-floating").each(function() {
	    $(this).removeClass('is-filled');
   	});
}

/**
 * Funcion que guarda la edicion del ticket
 */
function guardarCliente() { 
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
			    	if (validateFields($('#formCliente :input').not('button'))){
				    	bootbox.alert({ message:TraducirFrase('Los campos marcados, son obligatorios'),backdrop: true});
				    	return;
				    }				    	
			    	var dataform = {};
			    	dataform = $('#formCliente  :input').serialize().replace(/["']/g, "");
			    	Grabar(dataform);
			    }
		    }
		});
};

/**
 * Funcion que guarda la edicion del ticket
 */
function EliminarCliente(id) { 
		bootbox.confirm({
		    message: "Esta seguro que desea eliminar el Cliente?",
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
		$.ajax({url:'Search/ClienteEliminar.php',
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

function Grabar(dataform){
	toggleGifLoad();
		$.ajax({url:'Search/ClienteGuardar.php',
			data:dataform,
			type:'POST',dataType:'json',async:true})
		 .always(toggleGifLoad)
		 .done(function(result){
			 if (result.Success == 'true'){
			 		$('#tblDatos').trigger("reloadGrid");
	 				limpiar();
					$(".label-floating").each(function() {
					    $(this).removeClass('is-filled');
				   	});	
			 	if(result.idCliente == -1){ // si edito Cliente cierro
					$('#modalCliente').modal('hide'); 		
			 	}
			 }
		 });
}

function EditarCliente(id){
	toggleGifLoad();
		$.ajax({url:'Search/ClienteDetalle_get.php',
			data : {id : id},
			type:'POST',dataType:'json',async:true})
		 .always(toggleGifLoad)
		 .done(function(result){
			 if (result.Success == 'true'){
			 	$('#modalCliente').modal('show');
			 	cargarDetalle(result);
			 }
		 });
}

function cargarDetalle(data){
	$('#idCliente').val(data.idCliente);
	$('#nombre').val(data.nombre);
	$('#razon').val(data.razonSocial);
	$('#telefono').val(data.telefono);
	$('#direccion').val(data.direccion);
	$('#mail').val(data.email);

	$('#estado option[value='+data.estado+']').prop('selected', true);
	$('#select2-estado-container').text( $('#estado option:selected').text() );

	$(".label-floating").each(function() {
	    $(this).addClass('is-filled');
   	});
}

function limpiar(){
	$('.limp').val('');
	$('#idCliente').val(0);
}

function ClienteEquipos(idCliente){
	limpiar();

	selRowId = $("#tblDatos").jqGrid ('getGridParam', 'selrow'),
    celNombre = $("#tblDatos").jqGrid ('getCell', selRowId, 'Nombre');
    celIdCliente = $("#tblDatos").jqGrid ('getCell', selRowId, 'IdCliente');
	$('#spCliente').text(celNombre);
	$('#txtIdCliente').val(celIdCliente);

	toggleGifLoad();
	$.ajax({url:'Search/ClienteEquipos_get.php',
		data : {idCliente : idCliente},
		type:'POST',dataType:'json',async:true})
	 .always(toggleGifLoad)
	 .done(function(result){
	 		$('#tblDatosEq').html('');
	 		$('#modalClienteEquipo').modal('show');
			if(result[0] !== undefined){
				 if (result[0].Success == 'true'){
				 	cargarDetalleEquipos(result);
				 }
			}else{
				$('#divBuscaSerie').css('display','');
			}
	 });
}

function cargarDetalleEquipos(data){
	var reg = '';
	if(data[0].idCliente == 1){
		$('#divBuscaSerie').css('display','none');
	}else{
		$('#divBuscaSerie').css('display','');
	}
	$.each( data, function( key, value ) {
	    reg += '<tr id="trEquipo_'+value.idEquipo+'" name="trEquipo_'+value.idEquipo+'">';
        reg += '<td><b>'+value.serie+'</b></td>';
        reg += '<td>'+value.tipo+'</td>';
        reg += '<td>'+value.estado+'</td>';
        reg += '<td>';
        // Si es idCliente 1 La Guardiana no tiene la opcion desasociar
        if(value.idCliente != 1){
	        reg += '<a href="Javascript:Desasociar('+value.idEquipo+')"><img  src="../../img/eliminar.png"/title="Eliminar"></a>';
        }
        reg += '</td>';
        reg += '</tr>'; 
	});
	$('#tblDatosEq').html(reg);
}


function Desasociar(id) { 
		bootbox.confirm({
		    message: "Esta seguro que desea quitar el equipo al cliente?<br>Em mismo se pasará a depósito",
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
			    	DesasociarEquipo(id);
			    }
		    }
		});
};


function DesasociarEquipo(id){
	toggleGifLoad();
		$.ajax({url:'Search/EquipoDesasociar.php',
			data : {id : id},
			type:'POST',dataType:'json',async:true})
		 .always(toggleGifLoad)
		 .done(function(result){
			 if (result.Success == 'true'){
			 		$('#trEquipo_'+id).remove();
			 		bootbox.alert({ message:TraducirFrase(result.Text),backdrop: true});
			 }
		 });
}

$('#txtSerie').keyup(function(e){ 
	if(e.keyCode == 13){
    	$('#btnBuscarCaja').click();
	}
});

$('#btnBuscarCaja').on('click',function(){
	serie = $('#txtSerie').val();
	if(serie!= ''){
			toggleGifLoad();
			$.ajax({url:'Search/EquipoBuscar.php',
			data : {serie : serie},
			type:'POST',dataType:'json',async:true})
			 .always(toggleGifLoad)
			 .done(function(result){
			if (result.Success == 'true'){
				idEquipo = result.idEquipo;
		 		bootbox.confirm({
				    message: "La caja <b>"+serie+"</b> esta disponible, desea asociarlo al cliente?",
				    buttons: {
				        confirm: {
				            label: 'Asociar',
				            className: 'btn-danger'
				        },
				        cancel: {
				            label: 'Cancelar',
				            className: 'btn-default'
				        }
				    },
				    callback: function (result) {
					    if(result == true){
					    	AsociarEquipo(idEquipo);
					    }
				    }
				});
			 }else{
			 	bootbox.alert({ message:TraducirFrase(result.Text),backdrop: true});
			 }
		 });
	}
})

function AsociarEquipo(idEquipo){
	idCliente = $('#txtIdCliente').val();
	toggleGifLoad();
		$.ajax({url:'Search/EquipoAsociar.php',
			data : {idEquipo : idEquipo,idCliente:idCliente},
			type:'POST',dataType:'json',async:true})
		 .always(toggleGifLoad)
		 .done(function(result){
			 if (result.Success == 'true'){
			 		ClienteEquipos(idCliente);
			 		bootbox.alert({ message:TraducirFrase(result.Text),backdrop: true});
			 }
		 });
}