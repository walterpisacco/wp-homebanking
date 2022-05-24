
$(document).ready(function() {
	cargarPanel();
	// ejecuto la consulta cada 1 minuto
	setInterval(function(){ cargarPanel(); }, 60000);
})

function cargarPanel(){
	myDate = new Date();
	hours = myDate.getHours();
	minutes = myDate.getMinutes();
	seconds = myDate.getSeconds();
	if (hours < 10) hours = 0 + hours;
	if (minutes < 10) minutes = "0" + minutes;
	if (seconds < 10) seconds = "0" + seconds;
	$("#spHoraA").html('&nbsp;&nbsp;' +hours+ ":" +minutes);
	$("#spHoraE").html('&nbsp;&nbsp;' +hours+ ":" +minutes);
	$("#spHoraF").html('&nbsp;&nbsp;' +hours+ ":" +minutes);
	$("#spHoraU").html('&nbsp;&nbsp;' +hours+ ":" +minutes);

	//toggleGifLoad(); 
	$.ajax({ url:'Search/BuscarEstadoFuncionamiento.php',
	async: true,
	dataType: 'json',
	type : 'POST',
	data:{parametro:'EstadoFunc'}}
	).done(function(result){
	  	$('#spActivas').text(result.Activas);
	  	$('#spFueraLinea').text(result.FueraLinea);
	  	$('#spEnError').text(result.EnError);

	  	$('#spActivas').attr('serie',result.conectadasSerie);
	  	$('#spFueraLinea').attr('serie',result.desconectadasSerie);
	  	$('#spEnError').attr('serie',result.enerrorSerie);

	})//.always(toggleGifLoad);

	//toggleGifLoad(); 
	$.ajax({ url:'Search/Listado10Alertas.php',
	async: true,
	dataType: 'json',
	type : 'POST',
	data:{parametro:'EstadoFunc'}}
	).done(function(result){
		if(result[0] !== undefined){
			 if (result[0].Success == 'true'){
			 	cargar10Alertas(result);
			 }
		}else{
			$('#divBuscaSerie').css('display','');
		}
	})//.always(toggleGifLoad);
}

function verDetalle(tipomensaje){
	limpiar();
	if (tipomensaje == 1){series = $('#spActivas').attr('serie');}
	if (tipomensaje == 2){series = $('#spFueraLinea').attr('serie');}
	if (tipomensaje == 3){series = $('#spEnError').attr('serie');}
	toggleGifLoad();
	$.ajax({url:'Search/DetalleEstados.php',
		data : {series : series},
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
	$.each( data, function( key, value ) {
	    reg += '<tr id="trEquipo_'+value.idEquipo+'" name="trEquipo_'+value.idEquipo+'">';
        reg += '<td width="30%"><b>'+value.Serie+'</b></td>';
        reg += '<td width="70%">'+value.Direccion+'</td>';
        reg += '</tr>'; 
	});
	$('#tblDatosEq').html(reg);
}

function cargar10Alertas(data){
	var reg = '';
	$.each( data, function( key, value ) {
	    reg += '<tr id="trEquipo_'+value.idEquipo+'" name="trEquipo_'+value.idEquipo+'">';
        reg += '<td width="10%" align="center"><b>'+value.Serie+'</b></td>';
        reg += '<td width="30%" align="center">'+value.Fecha+'</td>';        
        reg += '<td width="60%" align="center">'+value.Porcentaje+'</td>';
        reg += '</tr>'; 
	});
	$('#tblDatosAlerta').html(reg);
}
