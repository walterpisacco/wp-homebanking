
function TraducirGrilla(){
	if(localStorage.getItem("lang") =='br'){
		 $('#jqgh_tblDatos_Equipo').text('Caixa');
		 $('#jqgh_tblDatos_Fecha').text('Data');
		 $('#jqgh_tblDatos_Descripcion').text('Descrição');
 		 $('#jqgh_tblDatos_Usuario').text('Do utilizador');
 		 $('#jqgh_tblDatos_Operacion').text('Operação');
 		 $('#jqgh_tblDatos_Monto').text('Quantia');
 		 $('#jqgh_tblDatos_Saldo').text('Equilíbrio');
 		 $('#jqgh_tblDatos_Serie').text('Série');
 		 $('#jqgh_tblDatos_Direccion').text('Endereço');
 		 $('#jqgh_tblDatos_direccion').text('Endereço');
 		 $('#jqgh_tblDatos_Apellido').text('Sobrenome');
 		 $('#jqgh_tblDatos_Nombres').text('Nomes');
 		 $('#jqgh_tblDatos_Nombre').text('Nome');
 		 $('#jqgh_tblDatos_Razon').text('Razão social');
 		 $('#jqgh_tblDatos_telefono').text('Telefone');
 		 $('#jqgh_tblDatos_').text('');
 		 $('#jqgh_tblDatos_').text('');
 		 $('#jqgh_tblDatos_').text('');

	}
}

function TraducirFrase(frase){
	if(localStorage.getItem("lang") =='br'){
		switch(frase) {
		  case 'Actualizado con exito': return 'Atualizado com sucesso';  break;
		  case 'Eliminado con exito':   return 'Removido com sucesso';    break;
		  case 'LAS CONTRASEÑAS INGRESADAS NO COINCIDEN':   return 'SENHAS INSERIDAS NÃO CORRESPONDEM';    break;
		  case 'El nombre de usuario no puede quedar en blanco':   return 'O nome de usuário não pode ser deixado em branco';    break;
		  case 'Ya existe un equipo con ese numero de serie':   return 'Já existe uma equipe com esse número de série';    break;
		  case 'Los campos marcados, son obligatorios':   return 'Os campos marcados são obrigatórios';    break;
		  case 'Ya existe una usuario con ese nombre':   return 'Já existe um usuário com esse nome';    break;
		  case 'Esta acción puede demorar, dependiendo de la cantidad de registros a procesar':   return 'Esta ação pode levar algum tempo, dependendo do número de registros a serem processados';    break;
		  case 'No se han detectado cambios':   return 'Nenhuma mudança detectada';    break;
		  case 'cantidad de transacciones procesadas:':   return 'número de transações processadas:';    break;
		  case '':   return '';    break;
		  case '':   return '';    break;
		  case '':   return '';    break;
		  case '':   return '';    break;		  			  		  		  		  		  
		  default: return frase;
		}
	}
	if(localStorage.getItem("lang") =='sp'){
		switch(frase) {
		  case '':   return '';    break;		  			  		  		  		  		  
		  default: return frase;
		}
	}

}



	 

