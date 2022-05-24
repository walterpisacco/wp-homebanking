$(document).ready(function() {
	var formBuscar = $('#searchbox-events'),
	tbDatos = $("#tblDatos").jqGrid({
	    styleUI : 'Bootstrap',
		responsive : true,
		datatype : 'local',
		mtype : 'POST',
	    colNames: ['IdMensaje','Tipo','Equipo','Fecha', 'Descripcion'],
	    colModel: [{name: 'IdMensaje',index: '2',width: 0,align: 'center',hidden: true},
	               {name: 'Tipo',index: '3',width: 80,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2},stype: "select",searchoptions: {value:"Todos:Todos;E:Eventos;P:Periodicos"}},
	               {name: 'Equipo',index: '4',width:80,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:3}},
	               {name: 'Fecha',index: '5',width: 80,formatter:'date', formatoptions:{srcformat: "ISO8601Long", newformat:'d/m/Y H:i'},align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2},search:true},
	         	   {name: 'Descripcion',index: '6',width: 300,align: 'left',editable:false,editoptions: {readonly: "readonly"},search:true}], 
	               pager: '#pagDatos',
	    rowNum : 10,
	  //  altRows: true,
		autowidth : true,
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
	}).navGrid('#pagDatos', {edit : false,add : false,del : false,view : false,search : false,refresh : false})
	.jqGrid('filterToolbar',{searchOnEnter:true,stringResult:true});;
	$('.ui-search-clear').css('display','none')

	tbDatos.navButtonAdd("#pagDatos", { 
    caption:'', buttonicon: 'fa fa-retweet', 
    onClickButton: function() {
        $("#tblDatos").trigger("reloadGrid");
    }, position: 'first', title: 'Refresh'} );

	function BuscarMensajes() {
		  var fields = formBuscar.find(':input').serializeArray();
	      var postdata = tbDatos.jqGrid('getGridParam', 'postData');
			    postdata.filters = formatFilter(fields);//La funcion esta en fngenerales
		        tbDatos.jqGrid('setGridParam', {
		        datatype: 'json', url: 'Search/MensajesList_get.php',
				async:true,
	          stringResult: true,search: true,postData: postdata,page:1
	      }).trigger('reloadGrid');
	}

	if(isMobile.any()) {
		$("#tblDatos").hideCol("Tipo");
		$("#tblDatos").setGridWidth($(window).width()-70); 
	}


BuscarMensajes();
TraducirGrilla();	

});



