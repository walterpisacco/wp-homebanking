let provMapa = [],layerMarker;
$(document).ready(function() {
	var pageWidth = $("#tblDatos").parent().width() - 100;
	var formBuscar = $('#searchbox-events'),
	tbDatos = $("#tblDatos").jqGrid({
	    styleUI : 'Bootstrap',
		responsive : true,
		datatype : 'local',
		mtype : 'POST',
	    colNames: ['IdEquipo','Serie','Bolsa','Transacción','Usuario','Fecha','Operacion','Concepto','Monto', 'Saldo'],
	    colModel: [{name: 'IdEquipo',index: '2',width: 0,align: 'center',hidden: true},
	               {name: 'Serie',index: '3',width:(pageWidth*(20/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'Bolsa',index: '4',width:(pageWidth*(20/100)),align: 'center',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'Transaccion',index: '5',width:(pageWidth*(15/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
	         	   {name: 'Usuario',index: '6',width:(pageWidth*(15/100)),align: 'left',editable:false,search:true,editoptions: {readonly: "readonly"}},
	         	   {name: 'Fecha',index: '7',width:(pageWidth*(20/100)),align: 'left',editable:true,search:true,
	               /*{name: 'Fecha',index: '6',width: 80,align: 'left',editable:true,search:true,formatter: 'date',
					    formatoptions: {
					        newformat: 'm / d / Y'
					    },
					    formoptions: {
					        rowpos: 1,
					        colpos: 2,
					        label: 'Register Date'
					    },
					    editrules: {
					        required: true
					    },
					    editoptions: {
					        size: 20,
					        maxlengh: 10,
					        dataInit: function(element) {
					            $(element).datepicker({
					                dateFormat: 'mm / dd / yy',
					                constrainInput: false,
					                showOn: 'button',
					                buttonText: '…'
					            }).change(function() {
					                $("#tblDatos")[0].triggerToolbar();
					            })
					        }
					    },
					    sorttype: 'date',
					    searchoptions: {
					        dataInit: function(element) {
					            $(element).datepicker({
					                id: 'Register_Date_datePicker',
					                dateFormat: 'mm / dd / yy',
					                showOn: 'focus'
					            }).change(function() {
					                $("#tblDatos")[0].triggerToolbar();
					            })
					        },
					        sopt: ['cn', 'eq', 'lt', 'le', , 'gt', 'ge']
					    }
					    */
					},
	               {name: 'Operacion',index: '8',width:(pageWidth*(20/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2},stype: "select",search:true,searchoptions: {value:"Todos:Todos;1:Retiro;2:Depósito"}},
	         	   {name: 'Concepto',index: '11',width:(pageWidth*(15/100)),align: 'left',editable:false,search:true,editoptions: {readonly: "readonly"}},
	               {name: 'Monto',index: '9',width:(pageWidth*(15/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:false,formoptions:{elmsuffix:"(*)",rowpos:2}},
	               {name: 'Saldo',index: '10',width:(pageWidth*(15/100)),align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:false,formoptions:{elmsuffix:"(*)",rowpos:2}}], 
	               pager: '#pagDatos',
	    rowNum : 10,
	  //  altRows: true,
		autowidth : true,
	//	loadonce: true,
		refresh: true,
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
			'resize' : true,
			'editable' : true,
			'search' : false
		},
		rowattr:function(rowData){
		   //if(rowData.Operacion == "Retiro") return {"style":"color: lightcoral;"};
		},
		loadComplete : function(data) {

			$.each(data.rows, function (i, item) {
		        var rowId = data.rows[i].id || data.rows[i]._id_;
		   	if(item.cell[6]=='Retiro'){
		        	tbDatos.setCell(rowId, 'Monto', '', { color: 'red'});
		    	}else{
		        	tbDatos.setCell(rowId, 'Monto', '', { color: 'green'});
		    }

		    });
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
		        datatype: 'json', url: 'Search/MovimientosList_get.php',
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
		$("#tblDatos").hideCol("Bolsa");
		$("#tblDatos").hideCol("Usuario");
		$("#tblDatos").hideCol("Operacion");
		$("#tblDatos").hideCol("Concepto");
		$("#tblDatos").setGridWidth($(window).width()-70); 
	}

	BuscarEquipos();	
	TraducirGrilla();	
});

$('#btnExportarTran').on('click',function(){
    fields = $('.ui-search-toolbar').find(':input').serializeArray();
    var postdata = $("#tblDatos").jqGrid('getGridParam', 'postData');//Agregar aca para que use 
     postdata.filters = formatFilter(fields);//La funcion esta en fngenerales
    $.redirect('Search/MovimientosExportar.php', {'filters': postdata.filters});
});

function limpiar(){
	$('.limp').val('');
	$('#idEquipo').val(0);
	$('#serie').prop('readonly',false);
	if(provMapa.hasLayer(layerMarker)) provMapa.removeLayer(layerMarker);
}