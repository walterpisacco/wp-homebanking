let provMapa = [],layerMarker;
$(document).ready(function() {
	$('#mapaequipo').css({'height': 270}); 
	
	/** Inicializar Mapa */
	provMapa = L.map('mapaequipo').setView([-34.597624,-58.455515], 13);

	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		maxZoom: 18,
		zoom:8,
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1,
		accessToken: 'pk.eyJ1Ijoid3Bpc2FjY28iLCJhIjoiY2tlYnZ4cHF0MDM2aTJ5bW9xaHlqbnZ2NSJ9.4DOXQMLber1Z3AFC4XJDSA',
		zoomControl:false,
		boxZoom:false
	}).addTo(provMapa);

	/**
	 * capturar la Latitud y longitud del click en el mapa
	 * 
	 * @param {Event} e
	 */
	provMapa.on('click', function(e) {
		//falta verificar que sea correcto el xy
		reverseGeocodingAddress(e.latlng.lat,e.latlng.lng)
		.done(function(result){
			$('#direccion').val(result.address.LongLabel).trigger('change');
			$('#posX').val(result.location.y).trigger('change');;
			$('#posY').val(result.location.x).trigger('change');;
			setMarkerAndFlyToPoint(result.location.y,result.location.x);
		}).fail(function(error){
			alert('No se pudo determinar la dirrección selecionada');
		});
	});

	$('#direccion').autocomplete({ hint: false,minLength:5,debug:true }, [{
		source: function(query, callback) {
			$.ajax({
				//url:'https://nominatim.openstreetmap.org/search',
				url:'https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/suggest',
				data:{
				'f':'json',
				'text':query,
				'countryCode':'AR',
				'category':'Street Address',
				'maxSuggestions':15,
				'outFields':''
				},
				type:'GET'
			}).then(function(answer){
				callback(answer.suggestions);
			},function(){
				callback([]);
			});
		},
		displayKey:function(suggestion){
			return suggestion.text;
		},
		templates: {
			suggestion: function(suggestion) {
				return suggestion.text;
			}
		}
		}
	]).on('autocomplete:selected',function(e,suggestion){
		//limpiar();
		findAddressCandidates(suggestion).then(function(result){
			let seleccion = _.first(result.candidates);
			$('#posX').val(seleccion.attributes.Y).trigger('change');;
			$('#posY').val(seleccion.attributes.X).trigger('change');;
			setMarkerAndFlyToPoint(seleccion.attributes.Y,seleccion.attributes.X);			
		});
	});

	/**
	 * Metodo para interactuar con la API de ESRI para obtener las coordenadas
	 * @return {Suggest} suggestion
	 *
	 * @return {$.Promise}
	 */
	function findAddressCandidates(suggestion){
		return $.ajax({
			url:'https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates',
			data:{
			'f':'json',
			'singleLine':suggestion.text,
			'forStorage':false,
			'countryCode':'AR',
			'outFields':'AddNum,City,Region,ShortLabel,StName,Subregion,X,Y',
			'magicKey':suggestion.magicKey,
			'maxSuggestions':1
			},
			type:'GET'
		});
	}

	// Resize del mapa acorde el contenedor
	$('#modalEquipo').on('shown.bs.modal',function(e){
		provMapa.invalidateSize();
	});
	

	/**
	 * Realizar la geocodificacion inversa en base a un x y
	 *
	 * @param  {Number} lat
	 * @param  {Number} lng
	 * @return {$.Deferred} 
	 */
	function reverseGeocodingAddress(lat,lng){
		return $.ajax({
			url:'https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode',
			data:{
			'location': lng+','+lat,
			'f':'json',
			'forStorage':false,
			'langCode':'AR',
			'featureTypes':'PointAddress',
			'locationType':'street',
			'preferredLabelValues':'localCity'
			},
			type:'GET'
		});
		

	}
	var pageWidth = $("#tblDatos").parent().width() - 100;	
	var formBuscar = $('#searchbox-events'),
	tbDatos = $("#tblDatos").jqGrid({
	    styleUI : 'Bootstrap',
		responsive : true,
		datatype : 'local',
		mtype : 'POST',
	    colNames: ['IdEquipo','Serie','Cliente','Dirección','Tipo','Estado', 'posX','posY',''],
	    colModel: [{name: 'IdEquipo',index: '2',width: 0,align: 'center',hidden: true},
	               {name: 'Serie',index: '3',width:(pageWidth*(20/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'Cliente',index: '10',width:(pageWidth*(20/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:3}},
	               {name: 'Direccion',index: '4',width:(pageWidth*(45/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:3}},
	               {name: 'Tipo',index: '7',width:(pageWidth*(25/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2},stype: "select",search:true,searchoptions: {value:"Todos:Todos;1:Caja Fuerte Inteligente"}},
	               {name: 'Estado',index: '8',width:(pageWidth*(20/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2},stype: "select",search:true,searchoptions: {value:"Todos:Todos;1:Entregadas;2:Depósito;3:Baja"}},
	               {name: 'posX',index: '5',hidden: true,width:(pageWidth*(30/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:false,formoptions:{elmsuffix:"(*)",rowpos:4}},
	               {name: 'posY',index: '6',hidden: true,width:(pageWidth*(30/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:false,formoptions:{elmsuffix:"(*)",rowpos:2}},
	              // {name: 'ultimoSinc',index: '7',width:(pageWidth*(20/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:false,formoptions:{elmsuffix:"(*)",rowpos:2}},
	         	   {name: 'acciones',index: '9',width:(pageWidth*(10/100)),align: 'left',editable:false,editoptions: {readonly: "readonly"}}], 
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
		   if(rowData.Estado == "Baja") return {"style":"color: lightcoral;"};
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

	function BuscarEquipos() {
		  var fields = formBuscar.find(':input').serializeArray();
	      var postdata = tbDatos.jqGrid('getGridParam', 'postData');
			    postdata.filters = formatFilter(fields);//La funcion esta en fngenerales
		        tbDatos.jqGrid('setGridParam', {
		        datatype: 'json', url: 'Search/EquiposList_get.php',
				async:true,
	          stringResult: true,search: true,postData: postdata,page:1
	      }).trigger('reloadGrid');
	}

	$.ajax({url:'../Utilidades/Search/Combo_get.php',data:{tipo:'TIPOEQUIPO',param:''},type:'POST',dataType:'json',async:true})
	.done(function(result){
		 if (result[0].Success == 'true'){
			$.each( result, function( key, value ) {
				$('#tipo').append('<option selected value="'+value.Codigo+'">'+value.Descripcion+'</option>');
			});
            $('#tipo').selectpicker('refresh');
		 }
	 });

	if(isMobile.any()) {
		$("#tblDatos").hideCol("Cliente");
		$("#tblDatos").hideCol("Direccion");
		$("#tblDatos").hideCol("Tipo");
		$("#tblDatos").hideCol("Estado");
		//$("#tblDatos").hideCol("ultimoSinc");
		$("#tblDatos").setGridWidth($(window).width()-70); 
	}	

	BuscarEquipos();
	TraducirGrilla();		

});

/**
 * Realiza un nueva marca sobre el mapa y corre la vista hasta ella
 * 
 * @param Integer x
 * @param Integer y
 */
function setMarkerAndFlyToPoint(y,x){
	if(provMapa.hasLayer(layerMarker)) provMapa.removeLayer(layerMarker);
	provMapa.flyTo([y,x], 17);
	layerMarker = L.marker([y,x]).addTo(provMapa)
				//.bindPopup(seleccion.address)
				.openPopup();
}

function AgregaEquipo(){
	limpiar();
	$('#modalEquipo').modal('show');
	
	$(".label-floating").each(function() {
	    $(this).removeClass('is-filled');
   	});
   	
}

/**
 * Funcion que guarda la edicion del ticket
 */
function guardarEquipo() { 
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
			    	if (validateFields($('#formEquipo :input').not('button'))){
				    	bootbox.alert({ message:TraducirFrase('Los campos marcados, son obligatorios'),backdrop: true});
				    	return;
				    }		
			    	var dataform = {};
			    	dataform = $('#formEquipo  :input').serialize().replace(/["']/g, "");
			    	Grabar(dataform);
			    }
		    }
		});
};

function Grabar(dataform){
	toggleGifLoad();
		$.ajax({url:'Search/EquipoGuardar.php',
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
			 	if(result.idEquipo == -1){ // si edito Equipo cierro
					$('#modalEquipo').modal('hide'); 		
			 	}
			 }else{
			 	bootbox.alert({ message:TraducirFrase(result.Text),backdrop: true});
			 }
		 });
}
/**
 * Funcion que guarda la edicion del ticket
 */
function Eliminar(id) { 
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
			    	EliminarEquipo(id);
			    }
		    }
		});
};

function EliminarEquipo(id){
	toggleGifLoad();
		$.ajax({url:'Search/EquipoEliminar.php',
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

function Editar(id){
	toggleGifLoad();
		$.ajax({url:'Search/EquipoDetalle_get.php',
			data : {id : id},
			type:'POST',dataType:'json',async:true})
		 .always(toggleGifLoad)
		 .done(function(result){
			 if (result.Success == 'true'){
			 	$('#modalEquipo').modal('show');
			 	cargarDetalle(result);
			 }
		 });
}

function Sincronizar(id){
	limpiar();
	$('#divResultado').css('display','none');
	selRowId = $("#tblDatos").jqGrid ('getGridParam', 'selrow');
    celSerie = $("#tblDatos").jqGrid ('getCell', selRowId, 'Serie');
    celidEquipo = $("#tblDatos").jqGrid ('getCell', selRowId, 'IdEquipo');
    celUltimo = $("#tblDatos").jqGrid ('getCell', selRowId, 'ultimoSinc');
    $('#txtSerie').val(celSerie);
    $('#txtIdEquipo').val(celidEquipo);
    $('#spUltimo').text(celUltimo);

	toggleGifLoad();
		$.ajax({url:'Search/EquipoDetalle_get.php',
			data : {id : id},
			type:'POST',dataType:'json',async:true})
		 .always(toggleGifLoad)
		 .done(function(result){
			 if (result.Success == 'true'){
			 	$('#modalSincronizar').modal('show');
			 }
		 });
}

function Sincronizar_Mensajes(){
	
    const desde = $('#rangofechas').data('daterangepicker').startDate.format('YYYY-MM-DD');
    const hasta = $('#rangofechas').data('daterangepicker').endDate.format('YYYY-MM-DD');
    var serie = $('#txtSerie').val();
    var idEquipo = $('#txtIdEquipo').val();
	$('#spResultado').text('');

		bootbox.confirm({
		    message: TraducirFrase("Esta acción puede demorar, dependiendo de la cantidad de registros a procesar"),
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
					toggleGifLoad();
					$.ajax({url:'Search/EquipoSincronizar.php',
						data : {desde : desde,hasta:hasta,serie:serie,idEquipo:idEquipo},
						type:'POST',dataType:'json',async:true})
					 .always(toggleGifLoad)
					 .done(function(result){
					 	$('#divResultado').css('display','');
						 if (result == 0){
							$('#spResultado').text(TraducirFrase('No se han detectado cambios'));
						 }else{
						 	$('#spResultado').text(TraducirFrase('cantidad de transacciones procesadas:')+result);
						 }
						 $("#tblDatos").jqGrid().trigger('reloadGrid');
					 });			    	
			    }
		    }
		});
}

function cargarDetalle(data){
	$('#idEquipo').val(data.idEquipo);

	$('#tipo option[value='+data.tipo+']').prop('selected', true);
	$('#select2-tipo-container').text( $('#tipo option:selected').text());
	$('#tipo').selectpicker('refresh');	

	$('#estado option[value='+data.estado+']').prop('selected', true);
	$('#select2-estado-container').text( $('#estado option:selected').text());
	$('#estado').selectpicker('refresh');	

	$('#serie').val(data.serie);
	$('#serie').prop('readonly',true);
	$('#direccion').val(data.direccion);
	$('#posX').val(data.posX);
	$('#posY').val(data.posY);

	setMarkerAndFlyToPoint(data.posX,data.posY);

	$(".label-floating").each(function() {
	    $(this).addClass('is-filled');
   	});
}

$('#rangofechas').daterangepicker({
	ranges: {
	    'Este Mes': [moment().startOf('month'), moment().endOf('month')],
	    'Mes Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
	        'month').endOf('month')],
	    'Este Año': [moment().startOf("year").toDate(), moment().endOf("year").toDate()]
	},
	"drops": "down",
	"startDate": moment().startOf("year").toDate(),
	"endDate": moment().endOf("year").toDate(),
	"locale": {
	    "format": "DD/MM/YYYY",
	    "separator": " - ",
	    "applyLabel": "Aplicar",
	    "cancelLabel": "Cancelar",
	    "fromLabel": "Desde",
	    "toLabel": "Hasta",
	    "customRangeLabel": "Personalizado",
	    "weekLabel": "W",
	    "daysOfWeek": ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
	    "monthNames": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto",
	        "Septiembre", "Octubre", "Noviembre", "Dicimbre"
	    ],
	    "firstDay": 1
	}
}).data('daterangepicker');

function limpiar(){
	$('.limp').val('');
	$('.limp').text('');
	$('#idEquipo').val(0);
	$('#serie').prop('readonly',false);
	if(provMapa.hasLayer(layerMarker)) provMapa.removeLayer(layerMarker);
}