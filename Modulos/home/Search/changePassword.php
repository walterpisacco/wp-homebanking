<script type="text/javascript">
$(document).ready(function(){
/** Inicializamos el formulario de contactos **/
$("#content_cambio_clave").dialog({
	autoOpen: false,
	// show: "slide",
	// hide: "slide",
    stack: false,
    resizable:false,
    modal:false,
    title:"Cambiar Clave de Usuario",
    height:350,
    width:450,
    buttons:{
   			"Guardar":{ text:'Guardar', class:'btn btn-success',click:function(){setNewClave();}},
            "Cancelar":{ text:'Cancelar', class:'btn btn-danger',click:function(){$('#content_cambio_clave input').map(function(){this.value='';});$( this ).dialog( "close" );}}}
    });
    
 /** Cambio de Clave **/
 $('#changePassword').click(function(event){
 	event.preventDefault();
 	$("#content_cambio_clave").dialog('open');
 });
	
	/** Funcion para guardar la nueva clave **/
	function setNewClave(){	
		/** Primero vemos que la nueva clave cumpla las reglas **/
		if(!getValidatePass($('#new_clave').val())){
			 setError('La clave no puede ser vacia y debe cumplir con las normas de seguridad.');
			 return false;
		}
		/** Segundo vemos que la nueva clave sea igual a la repeticion **/
		if(!getComparePass($('#new_clave').val(),$('#new_clave_reingreso').val())){
			setError('La nueva clave ingresada debe ingresarse dos veces, exactamente igual.');
			return false;
		}
		/** Tercero vemos que la vieja clave y la nueva no sean iguales **/
		if(getComparePass($('#old_clave').val(),$('#new_clave').val())){
			setError('La nueva clave no puede ser igual a la anterior');
			return false;
		}
		/** Por ultimo cambiamos la clave **/
		saveNewPassword($('#old_clave').val(),$('#new_clave').val());
	}

	/**
	 * Funcion para guardar el cambio de clave
	 *
	 * @param String oldpass
	 * @param String newpass
	 **/
	function saveNewPassword(oldpass,newpass){
		$.getJSON('index.php?modulo=home&accion=saveChangePassword&ajax=true',{old_cvl:oldpass,new_cvl:newpass},function(data){
			setError(data.Existe);
		});
	}
	
	/**
	 * Funcion para la validaci�n del password
	 * @param String $value - Valor del campo
	 * @return Boolean
	 **/

	function getValidatePass(value){
	/** (Entre 8 y 10 caracteres, por lo menos un digito y un alfanum�rico, y no puede contener caracteres espaciales) **/
		var RegExPattern = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;  
	/** Comparaci�n **/
	    return ((value.match(RegExPattern)) && (value!=''))? true:false;   
	}
	/**
	 * Funcion para compara dos claves o valores
	 * @param String new_cvl
	 * @param String new_cvl_rep
	 * @return Boolean
	 **/
	function getComparePass(new_cvl,new_cvl_rep){
		/** La new_cvl debe de ser exactamente igual a la new_cvl_rep **/
	  	return(new_cvl===new_cvl_rep)? true:false;
	}

	/**
	 * Funcion para setear el error
	 * @param error
	 **/
	function setError(error){
		$("#FormErrorClave").css('display','table-row');
		$("#FormErrorClave .ui-state-error").text(error);
	}
/*
	// Sacamos los errores
	$(':input').keyup(function(){
	    if( $(this).val() != "" ){$("#FormErrorClave").fadeOut();return false;}
	});*/
});
</script>

<div id="content_cambio_clave" style="display:none;">
<form id="clave_form" name="clave_form">
<table>
	<tbody>
		<tr id="FormErrorClave" style="display: none;">
			<td colspan="4" class="ui-state-error"></td>
		</tr>
		<tr>
			<td>Clave Anterior</td>
			<td><span>*</span><input type="password" id="old_clave"	name="old_clave" size="30" class="FormElement ui-widget-content ui-corner-all" /></td>
		</tr>
		<tr>
			<td>Nueva Clave</td>
			<td><span>*</span><input type="password" id="new_clave"	name="new_clave" size="30" class="FormElement ui-widget-content ui-corner-all" /></td>
		</tr>
		<tr>
			<td>Reingresar Clave</td>
			<td><span>*</span><input type="password" id="new_clave_reingreso" name="new_clave" size="30" class="FormElement ui-widget-content ui-corner-all" /></td>
		</tr>
		<tr>
		<td></br></td>
		<tr>
			<td colspan="2" class="ui-state-highlight ui-corner-all" style="font: 8px;">
			<div style="margin: 5px;"><span>Entre 8 y 10 caracteres, al menos un
			digito y un alfanum&eacute;rico. No puede contener caracteres
			espaciales.</span>
			</div>
			</td>
		</tr>
	</tbody>
</table>
</form>
</div>
