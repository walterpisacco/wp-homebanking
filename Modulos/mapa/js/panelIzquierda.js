$(document).ready(function() {
    var formBuscar = $('#searchbox-events'),
        chartTransaccionDetalleComposicion = null,
    tbDatos = $("#tblDatos").jqGrid({
        styleUI : 'Bootstrap',
        responsive : true,
        datatype : 'local',
        mtype : 'POST',
        colNames: ['idTransaccion','idDetalle','Fecha','Operación','Monto','equipo'],
        colModel: [{name: 'idTransaccion',index: '1',width: 0,align: 'center',hidden: true},
                   {name: 'idDetalle',index: '5',width: 0,align: 'center',hidden: true},
                   {name: 'fecha',index: '2',width: 120,align: 'left',editable:false,editoptions:{size:20,disabled:'disabled'},search:true,formoptions:{elmsuffix:"(*)",rowpos:2}},
                   {name: 'operacion',index: '3',width: 140,stype: "select",align: 'left',search:true,searchoptions: { value: "0:Todos;1:Retiro;2:Depósito Automático;3:Depósito Manual", defaultValue:"0" },rowpos:3},
                   {name: 'monto',index: '4',width: 100,align: 'right',editable:false,editoptions:{size:20,disabled:'disabled'},search:false,formoptions:{elmsuffix:"(*)",rowpos:4}},
                   {name: 'idEquipo',index: 'idEquipo',width: 0,align: 'center',search:true,hidden: true}
                    ], 
                   pager: '#pagDatos',
        rowNum : 10,
      //  altRows: true,
        //loadonce: true,
        autowidth : true,
        height : 'auto',
        rownumbers : false,
        rowList : [ 10, 20, 30 ],
        sortname : 2,
        sortorder : 'ASC',
        viewrecords : true,
        gridview : true,
        caption : '',
        refresh : true,
        shrinkToFit : true,
        cellEdit: false,
        cmTemplate : {
            'sortable' : false,
            'resize' : true,
            'editable' : true,
            'search' : false
        },
        rowattr:function(rowData){
           if(rowData.monto.substring(0, 1) == '-') return {"style":"color: lightcoral;"};
           $('#gs_idEquipo').val(rowData.idEquipo);
          },
        loadComplete : function() {
            $("tr.jqgrow:odd").addClass('myAltRowClassEven');
            $("tr.jqgrow:even").addClass('myAltRowClassOdd');
        },
        loadError : function(xhr, st, err) {
            jQuery("#rsperror").html("Type: " + st + "; Response: "+ xhr.status + " " + xhr.statusText);
        },
        onSelectRow:showDialogDetalleTransaccion,
        gridComplete : function(){
            $('#wrapper').on('toggle-out toggle-in',
                    function(e) {
                        tbDatos.trigger('resize');
                    });
            abrirTotales();
        }
    }).navGrid('#pagDatos', {edit : false,add : false,del : false,view : false,search : false,refresh : false})
    .jqGrid('filterToolbar',{searchOnEnter:true,stringResult:true});

    tbDatos.navButtonAdd("#pagDatos", { 
    caption:'', buttonicon: 'fa fa-retweet', 
    onClickButton: function() {
        $("#tblDatos").trigger("reloadGrid");
    }, position: 'first', title: 'Refresh'} );

    $('.ui-search-clear').css('display','none');

    /** Crear Grafico de Barras de Composicion de Transaccion */    
    ctx  = document.getElementById('chartTransaccionDetalleComposicion'),
    chartTransaccionDetalleComposicion = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Composición',
                    data: [],
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
    });
    /**
     * Funcion para mostrar la composición de la transaccion
     */
    function showDialogComposicionTransaccion(){
        let idDetalle    = $(this).val() || 0;
        getTransaccionesDetalleCompisicionFromServer(idDetalle).done(setDataTransaccionesComposicion).fail(setError); //El set Error esta en mapa.js
    }

        /**
     * Funcion para poblar el dialog de detalle
     * 
     * @param {Object} data
     */
    function setDataTransaccionesComposicion(data){
        let labels  = _.pluck(data,'moneda'),
            serie   = _.pluck(data,'cantidad');
        chartTransaccionDetalleComposicion.clear();
        chartTransaccionDetalleComposicion.data.labels = labels;

		chartTransaccionDetalleComposicion.data.datasets.forEach((dataset) => {
            dataset.data = serie;
            dataset.backgroundColor = _.map(serie,getRandombackgroundColor);
            console.log(chartTransaccionDetalleComposicion.data);
		});
		
		chartTransaccionDetalleComposicion.update();
        $('#dialogTransaccionDetalleComposicion').modal('show');
    }

    /**
     * Funcion para crear los colores random
     * 
     * @return {String}
     */
    function getRandombackgroundColor(){
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        console.log(color);
        return color;
    }

    /**
     * Funcion para mostrar el detalle de la transaccion
     * @param {Object} data 
     */
    function showDialogDetalleTransaccion(rowid,iRow,iCol,e){
        getTransaccionesDetalleFromServer(rowid).done(setDataTransaccionesDetalle).fail(setError); //El set Error esta en mapa.js
    }

    /**
     * Funcion para poblar el dialog de detalle
     * 
     * @param {Object} data
     */
    function setDataTransaccionesDetalle(data){
        
        let template  = _.template($('#tplDialogMapaTransaccionDetalle').html());
        $('#dialogTransaccionDetalle .modal-content').empty().append(template(data));
        $('#dialogTransaccionDetalle').modal('show');
    }

    /**
	 * Realiza la busqueda de los datos
	 *
	 *  @param {Integer} idEquipo
     *  @return {$.Deferred}
	 *
	 **/
	function getTransaccionesDetalleFromServer(idDetalle){
        toggleGifLoad();
        return $.ajax('Search/TransaccionesDetalle_get.php?idDetalle='+idDetalle, {
             async: true,dataType: 'json'    
         }).always(toggleGifLoad);
     }

    /**
	 * Realiza la busqueda de los datos
	 *
	 *  @param {Integer} idEquipo
     *  @return {$.Deferred}
	 *
	 **/
	function getTransaccionesDetalleCompisicionFromServer(idDetalle){
        toggleGifLoad();
        return $.ajax('Search/TransaccionesDetalleComposicion_get.php?idDetalle='+idDetalle, {
             async: true,dataType: 'json'    
         }).always(toggleGifLoad);
     }

$('#btnExportarTran').on('click',function(){
      idequipo = $('#spidEquipo').text();
      equipo   = {"name":'idEquipo',"value":''+parseInt(idequipo)+''};
      var fields      = formBuscar.find(':input').serializeArray();
      fields.push(equipo);   
      var postdata = tbDatos.jqGrid('getGridParam', 'postData');//Agregar aca para que use 
      postdata.filters = formatFilter(fields);//La funcion esta en fngenerales

      $.redirect('Search/TransaccionesExportar_get.php', {'filters': postdata.filters});

      //window.open('Search/TransaccionesExportar_get.php?filters='+postdata.filters);
});

/**
 * Funcion para abrir el dialog de Transaccion y llenar la grilla con los datos
 */
function abrirTransacciones() {
  let idequipo    = $('#spidEquipo').text(),
      fields      = formBuscar.find(':input').serializeArray(),
      equipo      = {"name":'idEquipo',"value":''+parseInt(idequipo)+''};
      fields.push(equipo);

          var postdata = tbDatos.jqGrid('getGridParam', 'postData');//Agregar aca para que use el
                postdata.filters = formatFilter(fields);//La funcion esta en fngenerales
            //    console.log( postdata.filters);
                tbDatos.jqGrid('setGridParam', {
                datatype: 'json', url: 'Search/Transacciones_get.php',
                async:true,
              stringResult: true,search: true,postData: postdata,page:1
          }).trigger('reloadGrid');
        $('#dialogTransacciones').modal('show');

        //abrirTotales();

}

function abrirTotales() {
  let idequipo    = $('#spidEquipo').text();
  $.ajax({url:'Search/TransaccionesTotales_get.php',data:{idEquipo:idequipo},type:'POST',dataType:'json',async:true})
  .done(function(result){
     if (result.Success == 'true'){
          $('#spARS').text(result.ARS);
          $('#spUSD').text(result.USD);
          $('#spBRL').text(result.BRL);
          $('#spEUR').text(result.EUR);
     }
   });
  }



   //window.open('Search/TransaccionesExportar_get.php&filters='+postdata.filters);    

    /**
	 * Funcion para setear el Error
	 * @param {Object} e 
	 */
	function setError(xhr){
		let template = _.template($('#tplErrorPanelIzquierdo').html());
		$('body').append(template({msn:xhr.responseText}));
    }
    
    $('body').delegate('#AbrirTransaccionDetalleComposicion','click',showDialogComposicionTransaccion);//Al hacer click en el boton Composición Transaccion
    $('body').delegate('#btnAbrirTransacciones','click',abrirTransacciones);//Al hacer click en el boton Abrir del Equipo
}); 





