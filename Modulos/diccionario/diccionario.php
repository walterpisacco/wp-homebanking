<?php
session_start();

function traducir($frase){
	if($_SESSION['lenguaje'] =='br'){
		switch ($frase) {
			case 'Panel de Control':return 'Painel de Controle';break;
			case 'Mapa de Distribución':return 'Mapa de Distribuição';break;
			case 'Mensajes':return 'Postagens';break;
			case 'Máquinas':return 'Caixas';break;
			case 'Movimientos':return 'Movimentos';break;
			case 'Administración':return 'Administração';break;
			case 'Usuarios':return 'Comercial';break;
			case 'Salir':return 'Fechar';break;
			case 'Cerrar':return 'Fechar';break;
			case 'Equipos':return 'Caixas';break;
			case 'Equipo':return 'Caixa';break;
			case 'EQUIPO':return 'CAIXA';break;
			case 'Sincronizar con la Máquina':return 'Sincronizar com caixas';break;
			case 'Fecha de última sincronización':return 'Última data de sincronização';break;
			case 'Seleccione rango de fechas':return 'Selecione o intervalo de datas';break;
			case 'Equipo':return 'Caixa';break;
			case 'Serie':return 'Série';break;
			case 'Dirección de Ubicacion':return 'Endereço de localização';break;
			case 'Equipo Entregado':return 'Caixa Entregue';break;
			case 'Equipo en Depósito':return 'Caixa de Deposito';break;
			case 'Equipo de Baja':return 'Caixa Baixa';break;
			case 'Guardar':return 'Guarda';break;
			case 'Actualizado con éxito!!':return 'Atualizado com sucesso !!';break;
			case 'Movimientos':return 'Movimentos';break;
			case 'Máquinas Activas':return 'Caixas Ativas';break;
			case 'Fuera de Linea':return 'Fora de linha';break;
			case 'Máquinas en Error':return 'Caixas com erro';break;
			case 'Máquinas en Alerta':return 'Caixas em alerta';break;
			case 'Ultima actualización':return 'Última atualização';break;
			case 'DETALLES':return 'DETALHES';break;
			case 'Fecha':return 'Encontro';break;
			case 'Dirección':return 'Endereço';break;
			case 'Tipo de Equipo':return 'Tipo de caixa';break;
			case 'TRANSACCIONES':return 'TRANSAÇÕES';break;
			case 'AGREGAR':return 'ADICIONAR';break;
			case 'Nombre':return 'Nome';break;
			case 'Apellido':return 'Sobrenome';break;
			case 'Nombre de Usuario':return 'Nome de Usuário';break;
			case 'Usuario Activo':return 'Usuário Ativo';break;
			case 'Usuario Inactivo':return 'Usuário Inativo';break;
			case 'REESTABLECER CLAVE':return 'REDEFINIR SENHA';break;
			case 'Razón Social':return 'Razão social';break;
			case 'Teléfono':return 'Telefone';break;
			case 'Cliente Activo':return 'Cliente Ativo';break;
			case 'Cliente Inactivo':return 'Cliente Inativo';break;
			case 'Completa tu Perfil':return 'Complete seu perfil';break;	
			case 'Esta información nos permitirá saber mas sobre tí':return 'Essas informações nos permitirão saber mais sobre você';break;
			case 'Tus Datos':return 'Seus Dados';break;
			case 'Tu Cuenta':return 'Sua Conta';break;
			case 'Nueva Contraseña':return 'Nova Senha';break;
			case 'Repite Contraseña':return 'Repita a Senha';break;
			case 'Dejar en blanco para mantener la contraseña actual':return 'Deixe em branco para manter a senha atual';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;
			case '':return '';break;																								
		  default:return $frase;
		}
	}else{ // si es español devuelve lo que entra
		return $frase;
	}
}


?>