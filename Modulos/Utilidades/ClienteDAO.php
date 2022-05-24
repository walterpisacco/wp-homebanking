	<?php

require_once '../../../configini.php';
require_once '../../Utilidades/funciones.php';
include 'conectar_sqlsrv.php';
require("../../../inc/PHPMailer/class.phpmailer.php");
require("../../../inc/PHPMailer/class.smtp.php");

class ClienteDAO {

private function devolverParametros($filters){
	$param = array();
	$param[]=( !is_null($filters) && !empty($filters) && $filters != '') ? "".utf8_encode($this->SplitSql($filters))."": "' '";
	$where =  implode(",",$param);
	return $where;
}

private function SplitSql($filters){
	$result =" Where 1 = 1 and ";
	try{
		$i = 0;
		foreach ($filters as $val) {
			if($i > 0) $result.= " and ";
			if ($val->value == ''){ // solo utilizo en campo y en concatenador para el in (x,x)
				$result.= " ".$val->field." ".$val->operador;
			}else{
				$result.= " ".$val->field." ".$val->operador."'".trim(utf8_decode($val->value))."'";
			}
			$i++;
		}
	}catch (Exception $e){
		return $e;
	}
	return $result."";
}

public function Conectar($usuario,$password){	
	try {
		$con = new conectarBase();
		$query= "CALL Conectar('".$usuario."','".$password."')";
		//echo $query;
		//exit;
		$result= $con->ConsultaSelect($query);		

		$Usuario = new stdClass();
		$Usuario->Success = (string) 'false';
		foreach($result as $row){
		  	$Usuario->idUsuario 	= (int) $row['idUsuario'];
			$Usuario->idPersona 	= (int) $row['idPersona'];
			$Usuario->nombreUsuario = (string) utf8_encode($row['nombreUsuario']);
			$Usuario->idCliente 	= (int) $row['idCliente'];
			$Usuario->cliente 		= (string) utf8_encode($row['cliente']);
			$Usuario->perfil 		= (string) $row['perfil'];
			$Usuario->perfilDesc 	= (string) $row['perfilDesc'];			
			$Usuario->mail 			= (string) $row['mail'];			
			$Usuario->forzar 		= (string) $row['forzar'];			
			$Usuario->Success 		= (string) $row['success'];
		 }			
	}catch ( Exception $e ) {
		$Usuario = new stdClass();
		$Usuario->Success = (string) 'false';
	}
	return $Usuario;
}

public function verificarCodigo($cod,$usu){	
	try {
		$con = new conectarBase();
		$query= "CALL Seguridad_VerificarCod('".$cod."','".$usu."')";
		$result= $con->ConsultaSelect($query);	

		$Usuario = new stdClass();
		$Usuario->Success = (string) 'false';
		foreach($result as $row){
			$Usuario->Success 		= (string) $row['success'];
			$Usuario->Hash 		= (string) $row['hash'];
		 }			
	}catch ( Exception $e ) {
		$Usuario = new stdClass();
		$Usuario->Success = (string) 'false';
	}
	return $Usuario;
}

public function BlanquearClave($idUsuario){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$con = new conectarBase();
		$query= "CALL Seguridad_BlanquearClave(".$oUsu->Id .",'".$oUsu->Session->Ip."',".$idUsuario.")";
		$result= $con->ConsultaSelect($query);	
		
		$Usuario = new stdClass();
		$Usuario->Success = (string) 'false';
		foreach($result as $row){
			$Usuario->Success 		= (string) $row['success'];
			$Codigo 				= (string) $row['codigo'];
			$mail 					= (string) $row['mail'];
			$usuario				= (string) $row['usuario'];	
			$this->enviarMail($Codigo,$mail,$usuario);
		 }			
	}catch ( Exception $e ) {
		$Usuario = new stdClass();
		$Usuario->Success = (string) 'false';
	}
	return $Usuario;
}

private function enviarMail($codigo,$destinatario,$usuario){
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Port = 587; 
	$mail->IsHTML(true); 
	$mail->CharSet = "utf-8";

	$mail->Host = smtpHost; 
	$mail->Username = smtpUsuario; 
	$mail->Password = smtpClave;
	$mail->From = smtpFrom;
	$mail->FromName = 'La Guardiana';
	$mail->AddAddress($destinatario);
	$mail->Subject = "Restablecer Contraseña"; // Este es el titulo del email.
	$mensajeHtml = nl2br('La Guardiana');
	$mail->Body = "
	<html> 
	<body> 
	<p><h3>LA GUARDIANA</h3></p>
	<p><h4>Actualización de contraseña</h4></p>
	Dirigete al portal del sistema e ingresa con los siguientes datos:<br></br>
	dirección: ".AppURL."<br>
	usuario: <b>".$usuario."</b><br>
	contraseña: <b>".$codigo."</b><br></br>
	Copia el código que figura a continuación y sigue las instrucciones: </h4><h3><b>".$codigo."</b></h3><br></br>

	* Este es un correo automático generado por la plataforma La Guardiana, por favor no responderlo!!

	</body> 
	</html>
	<br />";
	$mail->AltBody = "Recibiste un nuevo mensaje desde el formulario de contacto \n\n "; // Texto sin formato HTML
	$mail->SMTPOptions = array(
	    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    )
	);

	$estadoEnvio = $mail->Send(); 

	//print_r($estadoEnvio);

}

public function cambiarClave($usu,$hash,$pass){	
	try {
		$con = new conectarBase();
		$query= "CALL Seguridad_CambiarClave('".$usu."','".$hash."','".$pass."',@success,@_message)";
		$result= $con->ConsultaSelect($query);	
		$Usuario = new stdClass();
		$Usuario->Success = (string) 'false';
		foreach($result as $row){
			$Usuario->Success 	= (string) $row['_success'];
			$Usuario->Hash 		= (string) $row['hash'];
		 }			
	}catch ( Exception $e ) {
		$Usuario = new stdClass();
		$Usuario->success = (string) 'false';
	}
	return $Usuario;
}

public function GetPersonasList($start, $limit, $sidx, $sord,$filters=null){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';

	$where = $this->devolverParametros($filters);

	$resp = Array();
	try {
		$con = new conectarBase();
		$query= "CALL Personas_Listar( 
         ".$oUsu->Id.",
         '".$oUsu->Session->Ip."',
		 '".$where."',
          ".$start.",
          ".$limit.",
		  ".$sidx.",
		 '".$sord."')";	
		//echo $query;
		//exit();
		$result= $con->ConsultaSelect($query);

		foreach($result as $row){
			$Usuario = new stdClass();
			$Usuario->idPersona 	= (int) $row['idPersona'];
			$Usuario->Cliente 		= (string) utf8_encode($row['cliente']);			
			$Usuario->perfil 		= (string) utf8_encode($row['perfil']);
			$Usuario->usuario 		= (string) utf8_encode($row['usuario']);
			$Usuario->apellido 		= (string) utf8_encode($row['apellido']);
			$Usuario->nombres 		= (string) utf8_encode($row['nombre']);
			$Usuario->DNI 			= (string) $row['dni'];
			$Usuario->mail 			= (string) $row['mail'];
			$Usuario->telefono 		= (string) $row['telefono'];
			$Usuario->estado 		= (string) utf8_encode($row['estado']);					
			$Usuario->Success 		= 'true';
			$Usuario->Total_Row 	= (int) $row['Total_Row'];
			$resp[]					=$Usuario;
		 }			
	}catch ( Exception $e ) {
		$Usuario = new stdClass();
		$Usuario->Success = (string) 'false';
		$resp[]=$Usuario;
	}
	return $resp;
}

public function recuperarCombo($tipo,$param='')
{
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$con = new conectarBase();
		$query= "CALL Combo_get (".$oUsu->Id.",'".$tipo."','".$param."')";
		/*
		Echo $query;
		exit();
		*/
		$result= $con->ConsultaSelect($query);
		$resp = Array();
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->Codigo 		= (string) $row['codigo'];
			$respuesta->Descripcion = (string) utf8_encode($row['descripcion']);
			$respuesta->Campo1 		= (string) utf8_encode($row['campo1']);
			$respuesta->Campo2 		= (string) utf8_encode($row['campo2']);
			$respuesta->Success		= 'true';		
			$resp[] = $respuesta;			
		 }
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success 		= 'false';
		$respuesta->Text 			=  utf8_encode($e->getMessage()) ." Se produjo un error ";
		$resp[] = $respuesta;
	}
	return $resp;
}

public function GuardarPersona($oPersona){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$idPersona 		= $oPersona->idPersona;
		$dni 			= $oPersona->dni;
		$nombre 		= utf8_decode($oPersona->nombre);
		$apellido 		= utf8_decode($oPersona->apellido);
		$estado 		= utf8_decode($oPersona->estado);
		$cuil 			= $oPersona->cuil;
		$fecNac 		= $oPersona->fecNac;
		$nacionalidad 	= $oPersona->nacionalidad;
		$genero 		= $oPersona->genero;
		$mail 			= $oPersona->mail;
		$idCliente 		= $oPersona->idCliente;
		$fecNac 		= substr($fecNac,6,4).'-'.substr($fecNac,3,2).'-'.substr($fecNac,0,2);

		$con = new conectarBase();
		$query= "CALL Persona_Guardar (
		 ".$oUsu->Id .",
		 ".$idPersona.",  
         ".$dni.",
		'".$cuil."',
		'".$apellido."',
		'".$nombre."',
		'".$fecNac."',
		 ".$nacionalidad.",
		 ".$genero.",
		 '".$mail."',		 
		 ".$estado.",
		 ".$idCliente.",@text,@_save,@success)";
		 /*
		 echo $query;
		 exit();
*/
		 $result= $con->ConsultaSelect($query);
		$Usuario->success = 'false';
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->idPersona = (int) $row['_save'];
			$respuesta->Success = $row['_success'];
			$respuesta->Text = $row['_message'];			
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function EliminarPersona($id){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$con = new conectarBase();
		$query= "CALL Persona_Eliminar( 
         ".$oUsu->Id.",
		 ".$id.",@text,@_save,@success)";

		$result= $con->ConsultaSelect($query);

		$respuesta = new stdClass();
		$respuesta->success = 'false';
		foreach($result as $row){
			$respuesta->idPersona = (int) $row['_save'];
			$respuesta->Success = $row['_success'];
			$respuesta->Text = $row['_message'];			
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function EditarPersona($id){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$con = new conectarBase();
		$query= "CALL Persona_Editar (".$oUsu->Id.",".$id.")";
		$result= $con->ConsultaSelect($query);
		$Usuario->success = 'false';
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->idPersona = $row['idPersona'];
			$respuesta->idCliente = $row['idCliente'];			
			$respuesta->dni = $row['dni'];
			$respuesta->nombre = utf8_encode($row['nombre']);
			$respuesta->apellido = utf8_encode($row['apellido']);
			$respuesta->estado = utf8_encode($row['estado']);
			$respuesta->cuil = $row['cuil'];
			if ($row['fechaNac'] != ''){
				$respuesta->fecNac = substr($row['fechaNac'],8,2).'/'.substr($row['fechaNac'],5,2).'/'.substr($row['fechaNac'],0,4);
			}
			$respuesta->nacionalidad = $row['nacionalidad'];
			$respuesta->genero = $row['genero'];
			$respuesta->mail = $row['mail'];
			$respuesta->Success = 'true';
			$respuesta->Text = 'ok';
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function GetEquiposList($start, $limit, $sidx, $sord,$filters=null){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';

	$where = $this->devolverParametros($filters);

	$resp = Array();
	try {
		$con = new conectarBase();
		$query= "CALL Equipos_Listar( 
         ".$oUsu->Id.",
         '".$oUsu->Session->Ip."',
		 '".$where."',
          ".$start.",
          ".$limit.",
		  ".$sidx.",
		 '".$sord."')";		 
/*
echo $query;
exit();
*/
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$Oresp = new stdClass();
			$Oresp->idEquipo = (int) $row['idEquipo'];
			$Oresp->serie = (string) $row['serie'];
			$Oresp->nombreCliente 	= utf8_encode($row['nombreCliente']);				
			$Oresp->direccion = (string) utf8_encode($row['direccion']);
			$Oresp->posX = (string) $row['posX'];
			$Oresp->posY = (string) $row['posY'];
			$Oresp->ultimoSinc = fechaNacional($row['ultimoSinc']);
			$Oresp->tipo = (string) utf8_encode($row['tipo']);
			$Oresp->estado = (string) utf8_encode($row['estado']);	
			$Oresp->Total_Row = (int) $row['Total_Row'];
			$Oresp->Success = 'true';
			$resp[]=$Oresp;
		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$resp[]=$Oresp;
	}
	return $resp;
}

public function GetTransaccionesList($start, $limit, $sidx, $sord,$filters=null){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';

	$where = $this->devolverParametros($filters);

	$resp = Array();
	try {
		$con = new conectarBase();
		$query= "CALL seguridad.Transacciones_Listar( 
         ".$oUsu->Id.",
         '".$oUsu->Session->Ip."',
		 '".$where."',
          ".$start.",
          ".$limit.",
		  ".$sidx.",
		 '".$sord."')";	
		 //echo $query;
		 //exit;
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$Oresp = new stdClass();
			$Oresp->idEquipo 		= (int) $row['idEquipo'];
			$Oresp->serie 			= (string) $row['serie'];
			$Oresp->idTransaccion 	= (int) $row['idTransaccion'];
			$Oresp->idDetalle 		= (int) $row['idDetalle'];
			$Oresp->fecha 			= (string) $row['fechaHora'];
			$Oresp->operacion 		= (string) $row['tipoOperacion'];
			$Oresp->monto 			= (string) $row['monto'];
			$Oresp->Success 		= 'true';
			$Oresp->Total_Row 		= (int) $row['Total_Row'];
			$resp[]=$Oresp;
		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$Oresp->Text = (string) $e->getMessage();
		$resp[]=$Oresp;
	}
	return $resp;
}

public function GuardarEquipo($oEquipo){	
	try {
		$idUsuario	= $_SESSION["idUsuario"];
		$ip = 'localhost';
		$idEquipo 	= $oEquipo->idEquipo;
		$tipo 		= $oEquipo->tipo;
		$estado 	= $oEquipo->estado;
		$serie 		= $oEquipo->serie;
		$direccion 	= utf8_decode($oEquipo->direccion);
		$posX 		= $oEquipo->posX;
		$posY 		= $oEquipo->posY;

		$con = new conectarBase();
		$query= "CALL Equipo_Guardar (
		 ".$idUsuario.",
		 '".$ip."',
		 ".$idEquipo.", 
         ".$tipo.",
		 ".$estado.",
		'".$serie."',
		'".$direccion."',
		'".$posX."',
		'".$posY."',@success,@_message,@id)";
	 
	 //echo $query;
	 //exit();
	 
		 $result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->idEquipo = (int) $row['_id'];
			$respuesta->Success = $row['_success'];
			$respuesta->Text = utf8_encode($row['_message']);			
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function EditarEquipo($idEquipo){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';
	try {
		$con = new conectarBase();
		$query= "CALL Equipo_Editar( 
         ".$oUsu->Id.",
         '".$oUsu->Session->Ip."',
		  ".$idEquipo.")";
/*
	 echo $query;
	 exit();
*/
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$Oresp = new stdClass();
			$Oresp->idEquipo = (int) $row['idEquipo'];
			$Oresp->serie = (string) $row['serie'];
			$Oresp->direccion = (string) utf8_encode($row['direccion']);
			$Oresp->posX = (string) $row['posX'];
			$Oresp->posY = (string) $row['posY'];
			$Oresp->tipo = (string) $row['tipo'];
			$Oresp->estado = (string) $row['estado'];			
			$Oresp->Success = 'true';
		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
	}
	return $Oresp;
}

public function EliminarEquipo($id){
	try {
		$idUsuario = $_SESSION["idUsuario"];
		$con = new conectarBase();
		$query= "CALL Equipo_Eliminar( 
         ".$idUsuario.",
		 ".$id.",@text,@success)";

		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->Success = $row['_success'];
			$respuesta->Text = $row['_message'];			
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function GetTransaccionesDetalle($idDetalle){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';

	try {
		$con = new conectarBase();
		$query= "CALL Transacciones_Detalle( 
         ".$oUsu->Id.",
         '".$oUsu->Session->Ip."',
		  ".$idDetalle.")";
		$Oresp = new stdClass();
		$Oresp->Success = 'false'; 
	 //echo $query;
	 //exit();
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$Oresp->fechaHora = (string) $row['fechaHora'];
			$Oresp->monto = (string) $row['monto'];
			$Oresp->cliente = (string) utf8_encode($row['cliente']);
			$Oresp->operacion = (string) $row['operacion'];
			$Oresp->transaccion = (string) $row['transaccion'];
			$Oresp->moneda = (string) utf8_encode($row['moneda']);
			$Oresp->signo = (string) $row['signo'];			
			$Oresp->Success = 'true';
			$Oresp->id = $idDetalle;
		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$Oresp->Text = (string) $e->getMessage();
	}
	return $Oresp;
}

public function GetTransaccionesComposicion($idDetalle){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';
	$resp = array();
	try {
		$con = new conectarBase();
		$query= "CALL Transacciones_Composicion( 
         ".$oUsu->Id.",
         '".$oUsu->Session->Ip."',
		  ".$idDetalle.")";
		 
		$result= $con->ConsultaSelect($query);

		foreach($result as $row){
			$Oresp = new stdClass();
			$Oresp->monto = (string) $row['valor'];
			$Oresp->cantidad = (int) $row['cantidad'];
			$Oresp->transaccion = (string) $row['transaccion'];
			$Oresp->moneda = (string) $row['moneda'];
			$Oresp->orden = (int) $row['orden'];			
			$Oresp->Success = 'true';
			$resp[] = $Oresp;

		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$Oresp->Text = (string) $e->getMessage();
		$resp[] = $Oresp;
	}
	return $resp;
}
public function EditarSeguridad($id){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$con = new conectarBase();
		$query= "CALL Seguridad_Editar (".$oUsu->Id.",'".$oUsu->Session->Ip."',".$id.")";
		$result= $con->ConsultaSelect($query);
		$respuesta = new stdClass();
		$respuesta->idPersona	= $id; 		
		$respuesta->Success 	= 'false';
		foreach($result as $row){
			$respuesta->idUsuario 	= (int) 	$row['idUsuario'];
			$respuesta->idPersona 	= (int) 	$row['idPersona'];
			$respuesta->idCliente 	= (int) 	$row['idCliente'];
			$respuesta->nombre 		= (string)  utf8_encode($row['nombre']);
			$respuesta->apellido 	= (string)  utf8_encode($row['apellido']);
			$respuesta->mail 		= (string) 	utf8_encode($row['mail']);
			$respuesta->usuario 	= (string) 	utf8_encode($row['usuario']);
			$respuesta->perfil 		= (string) 	utf8_encode($row['perfil']);
			$respuesta->estado 		= (int) 	utf8_encode($row['estado']);
			$respuesta->Success 	= 'true';
			$respuesta->Text 		= 'OK';
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}
public function GuardarSeguridad($ousuario){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$idPersona 				= $ousuario->idPersona;
		$idUsuario 				= $ousuario->idUsuario;
		$idCliente 				= $ousuario->idCliente;		
		$nombre 				= utf8_decode($ousuario->nombre);
		$apellido 				= utf8_decode($ousuario->apellido);
		$mail 					= $ousuario->mail;						
		$usuario 				= utf8_decode($ousuario->usuario);
		$perfil 				= $ousuario->perfil;
		$estado 				= $ousuario->estado;

		$con = new conectarBase();
		$query= "CALL Seguridad1_Guardar (
		 ".$oUsu->Id.",
		 '".$oUsu->Session->Ip."',
		 ".$idPersona.", 
		 ".$idUsuario.",
		 ".$idCliente.",		 
		 '".$nombre."',
		 '".$apellido."',
		 '".$mail."',
         '".$usuario."',
		 ".$perfil.",
		 ".$estado.",@success,@_message,@id)";
	 /*
	 echo $query;
	 exit();
	 */
		 $result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->idUsuario = (int) $row['_save'];
			$respuesta->Success = $row['_success'];
			$respuesta->Text = $row['_message'];
			if ((int) $idUsuario == 0){
			 	$this->BlanquearClave($respuesta->idUsuario);
			 }
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function GetClientesList($start, $limit, $sidx, $sord,$filters=null){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';
	$where = $this->devolverParametros($filters);
	$resp = Array();
	try {
		$con = new conectarBase();
		$query= "CALL Clientes_Listar( 
         ".$oUsu->Id.",
         '".$oUsu->Session->Ip."',
		 '".$where."',
          ".$start.",
          ".$limit.",
		  ".$sidx.",
		 '".$sord."')";	

		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$oRespuesta = new stdClass();
			$oRespuesta->idCliente = (int) $row['idCliente'];
			$oRespuesta->nombre = (string) utf8_encode($row['nombre']);
			$oRespuesta->razonSocial = (string) utf8_encode($row['razonSocial']);
			$oRespuesta->email = (string) $row['email'];
			$oRespuesta->telefono = (string) $row['telefono'];
			$oRespuesta->direccion = (string) utf8_encode($row['direccion']);
			$oRespuesta->cantEquipos = (int) $row['equipos'];			
			$oRespuesta->estado = (string) $row['estado'];	
			$oRespuesta->Success = 'true';
			$oRespuesta->Total_Row = (int) $row['Total_Row'];
			$resp[]=$oRespuesta;
		 }			
	}catch ( Exception $e ) {
		$oRespuesta = new stdClass();
		$oRespuesta->Success = (string) 'false';
		$resp[]=$oRespuesta;
	}
	return $resp;
}

public function GuardarCliente($oCliente){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$idCliente 		= (int) $oCliente->idCliente;
		$nombre 		= utf8_decode($oCliente->nombre);
		$razonSocial 	= utf8_decode($oCliente->razonSocial);
		$email 			= $oCliente->email;
		$telefono 		= $oCliente->telefono;
		$direccion 		= utf8_decode($oCliente->direccion);
		$estado 		= $oCliente->estado;

		$con = new conectarBase();
		$query= "CALL Cliente_Guardar (
		 ".$oUsu->Id.",
		 ".$idCliente.",  
        '".$nombre."',
		'".$razonSocial."',
		'".$email."',
		'".$telefono."',
		'".$direccion."',
		 ".$estado.",@text,@_save,@success)";
		 /*
		 echo $query;
		 exit();*/
		 $result= $con->ConsultaSelect($query);

		$respuesta = new stdClass(); 
		$respuesta->success = 'false';

		foreach($result as $row){
			$respuesta->idCliente = (int) $row['_save'];
			$respuesta->Success = $row['_success'];
			$respuesta->Text = $row['_message'];			
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function EliminarCliente($id){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$con = new conectarBase();
		$query= "CALL Cliente_Eliminar( 
         ".$oUsu->Id.",
		 ".$id.",@text,@_save,@success)";

		$result= $con->ConsultaSelect($query);

		$respuesta = new stdClass();
		$respuesta->success = 'false';
		foreach($result as $row){
			$respuesta->Success = $row['_success'];
			$respuesta->Text = $row['_message'];			
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function EditarCliente($id){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$con = new conectarBase();
		$query= "CALL Cliente_Editar (".$oUsu->Id.",".$id.")";
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->idCliente 	= $row['idCliente'];
			$respuesta->nombre 		= utf8_encode($row['nombre']);
			$respuesta->razonSocial = utf8_encode($row['razonSocial']);
			$respuesta->telefono 	= $row['telefono'];
			$respuesta->direccion 	= utf8_encode($row['direccion']);
			$respuesta->email 		= $row['email'];
			$respuesta->estado 		= $row['estado'];
			$respuesta->Success 	= 'true';
			$respuesta->Text 		= 'ok';
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function BuscarTopic($usuario,$clientBroker){
	try {
		$idUsuario = $_SESSION["idUsuario"];
		$con = new conectarBase();
		$query= "CALL Topico_Suscribir( 
         ".$idUsuario.",
		 '".$usuario."')";

		//echo $query;
		//exit();
		$result= $con->ConsultaSelect($query);

		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->Serie = $row['devices_serie'];
			$respuesta->Topico = $row['topic'];
			$respuesta->Success = 'true';
			$this->Suscribir_Topic($clientBroker,$respuesta->Topico);
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

	/** POST
	 * Metodo para subscribirse a un topico mediante API del Broker
	 * @return object
	 */
	public function Suscribir_Topic($clientBroker,$topic){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => APIServidorMQTT."clientid=".$clientBroker."&topic=".$topic,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: Basic YWRtaW46R2xvYmFsKjM1MjI="
	  ),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	echo $response;
	}


public function GetMensajesList($start, $limit, $sidx, $sord,$filters=null){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';

	$where = $this->devolverParametros($filters);

	$resp = Array();
	try {
		$con = new conectarBase();
		$query= "CALL Mensajes_Listar( 
         ".$oUsu->Id.",
         '".$oUsu->Session->Ip."',
         '".$where."',
          ".$start.",
          ".$limit.",
		  ".$sidx.",
		 '".$sord."')";
		//echo $query;
		//exit();
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$Oresp = new stdClass();
			$Oresp->idMensaje = (int) $row['idMensaje'];
			$Oresp->tipo = (string) $row['tipo'];
			$Oresp->equipo = (string) $row['equipo'];
			$Oresp->fecha = (string) $row['fecha'];
			$Oresp->descripcion = (string) utf8_encode($row['descripcion']);
			$Oresp->direccion = (string) $row['direccion'];
			$Oresp->cliente = (string) $row['cliente'];
			$Oresp->Success = 'true';
			$Oresp->Total_Row = (int) $row['Total_Row'];
			$resp[]=$Oresp;
		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$resp[]=$Oresp;
	}
	return $resp;
}

public function ClienteEquipo($idCliente){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';
	    
	    $resp = Array();
		$con = new conectarBase();
		$query= "CALL ClienteEquipos_Listar (".$oUsu->Id.",".$idCliente.")";

		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->idCliente 	= $row['idCliente'];
			$respuesta->cliente 	= utf8_encode($row['cliente']);		
			$respuesta->idEquipo 	= $row['idEquipo'];			
			$respuesta->serie 		= utf8_encode($row['serie']);
			$respuesta->tipo 		= utf8_encode($row['tipo']);
			$respuesta->estado 		= $row['estado'];
			$respuesta->Success 	= 'true';
			$respuesta->Text 		= 'ok';
			$resp[]=$respuesta;
		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$resp[]=$Oresp;
	}
	return $resp;
}

public function DesasociarEquipo($idEquipo){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';

	try {
		$con = new conectarBase();
		$query= "CALL Equipo_Desasociar( 
         ".$oUsu->Id.",
         '".$oUsu->Session->Ip."',
		  ".$idEquipo.")";
		/*
 		echo $query;
 		exit;
 		*/
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$Oresp = new stdClass();
			$Oresp->Success = 'true';
			$Oresp->Text = 'El equipo ha sido pasado a depósito';
		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$Oresp->Text = (string) $e->getMessage();
	}
	return $Oresp;
}

public function BuscarEquipo($serie){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';
	    
	    $resp = Array();
		$con = new conectarBase();
		$query= "CALL Equipo_Buscar (".$oUsu->Id.",'".$serie."')";
		/*
echo $query;
exit;
*/
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->idEquipo 	= $row['idEquipo'];
			$respuesta->Success 	= $row['Success'];
			$respuesta->Text 		= utf8_encode($row['Text']);
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}
public function AsociarEquipo($idEquipo, $idCliente){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';

	try {
		$con = new conectarBase();
		$query= "CALL Equipo_Asociar( 
         ".$oUsu->Id.",
         '".$oUsu->Session->Ip."',
          ".$idEquipo.",         
		  ".$idCliente.")";
		 
 		//echo $query;
 		//exit;
 		
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$Oresp = new stdClass();
			$Oresp->Success = 'true';
			$Oresp->Text = 'El equipo ha sido asignado con éxito';
		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$Oresp->Text = (string) $e->getMessage();
	}
	return $Oresp;
}
public function PanelBuscar($parametro){
	try {

		$idUsuario = $_SESSION["idUsuario"];

		$con = new conectarBase();
		$query= "CALL Panel_Buscar( 
         ".$idUsuario.",
    	 '".$parametro."')";
		 
 		//echo $query;
 		//exit;
 		
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
	 		$Oresp = new stdClass();
			$Oresp->Activas 			= $row['activas'];
			$Oresp->FueraLinea 			= $row['fueraLinea'];
			$Oresp->EnError 			= $row['enError'];
			$Oresp->conectadasSerie 	= $row['activasSerie'];
			$Oresp->desconectadasSerie 	= $row['fueraLineaSerie'];
			$Oresp->enerrorSerie 		= $row['enErrorSerie'];	
			$Oresp->Success 	= 'true';
		}
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$Oresp->Text = (string) $e->getMessage();
	}
	return $Oresp;
}

public function EditarPerfil($idUsuario, $idApp){	
	try {
		$con = new conectarBase();
		$query= "CALL Perfil_Editar (".$idUsuario.",".$idApp.")";
		//echo $query;
		//exit;
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->idPersona 	= $row['idPersona'];
			$respuesta->idCliente 	= $row['idCliente'];			
			$respuesta->dni 		= $row['dni'];
			$respuesta->nombre 		= utf8_encode($row['nombre']);
			$respuesta->apellido 	= utf8_encode($row['apellido']);
			$respuesta->estado 		= $row['estado'];
			$respuesta->cuil 		= $row['cuil'];
			if ($row['fechaNac'] != ''){
				$respuesta->fecNac = substr($row['fechaNac'],8,2).'/'.substr($row['fechaNac'],5,2).'/'.substr($row['fechaNac'],0,4);
			}
			$respuesta->nacionalidad 	= utf8_encode($row['nacionalidad']);
			$respuesta->genero 			= utf8_encode($row['genero']);
			$respuesta->mail 			= utf8_encode($row['mail']);
			$respuesta->telefono 		= utf8_encode($row['telefono']);
			$respuesta->usuario 		= utf8_encode($row['usuario']);			
			$respuesta->perfil 			= utf8_encode($row['perfil']);
			$respuesta->hash 			= utf8_encode($row['hash']);			
			$respuesta->nombreEmp 		= utf8_encode($row['nombreEmp']);
			$respuesta->razonEmp 		= utf8_encode($row['razonEmp']);
			$respuesta->dirEmp 			= utf8_encode($row['dirEmp']);
			$respuesta->telEmp 			= $row['telEmp'];
			$respuesta->emailEmp 		= utf8_encode($row['emailEmp']);
			$respuesta->Success 		= 'true';
			$respuesta->Text 			= 'ok';
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function GuardarPerfil($oPersona){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$idUsuario 	= $oPersona->idUsuario;
		$mail 		= $oPersona->mail;
		$telefono 	= $oPersona->telefono;
		$pass 		= $oPersona->pass;

		$con = new conectarBase();
		$query= "CALL Perfil_Guardar (
		 ".$idUsuario.",
		'".$telefono."',
		'".$pass."',		
		 '".$mail."')";
		//echo $query;
		//exit();
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->Success = $row['success'];
			$respuesta->Text 	= utf8_encode($row['texto']);			
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function GetTransaccionesTotales($idEquipo){	
	try {
		$oUsu = new stdClass();
		$oUsu->Id = $_SESSION["idUsuario"];
		$oUsu->Session = new stdClass();
		$oUsu->Session->Ip = 'localhost';

		$con = new conectarBase();
		$query= "CALL Transacciones_Total (".$oUsu->Id.",".$idEquipo.")";
		
		//echo $query;
		//exit;

		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$respuesta = new stdClass();
			$respuesta->ARS 	= (float)$row['ARS'];
			$respuesta->USD 	= (float)$row['USD'];			
			$respuesta->BRL 	= (float)$row['BRL'];
			$respuesta->EUR 	= (float)$row['EUR'];
			$respuesta->Success = 'true';
			$respuesta->Text 	= 'ok';
		 }			
	}catch ( Exception $e ) {
		$respuesta = new stdClass();
		$respuesta->Success = (string) 'false';
	}
	return $respuesta;
}

public function PanelEstadoDetalles($series){
	$idUsuario = $_SESSION["idUsuario"];
	try {
		$con = new conectarBase();
		$query= "CALL Panel_BuscarDetalle( 
         ".$idUsuario.",
         '".$series."')";
		 
 		//echo $query;
 		//exit;
 		
 		$resp = array();
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$Oresp = new stdClass();
			$Oresp->Serie 		= $row['serie'];
			$Oresp->Direccion 	= utf8_encode($row['direccion']);
			$Oresp->Estado 		= utf8_encode($row['estado']);			
			$Oresp->Success 	= 'true';
			$resp[] 			= $Oresp;
		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$Oresp->Text = (string) $e->getMessage();
		$resp = $Oresp;
	}
	return $resp;
}


public function Panel10Alertas(){
	$idUsuario = $_SESSION["idUsuario"];

	try {
		$con = new conectarBase();
		$query= "CALL Panel_buscar10Alertas(".$idUsuario.")";
		 
 		//echo $query;
 		//exit;
 		
 		$resp = array();
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
				$Oresp = new stdClass();
				$Oresp->Serie 		= $row['serie'];
				$Oresp->Direccion 	= utf8_encode($row['direccion']);
				$Oresp->Porcentaje 	= utf8_encode($row['descripcion']);
				$Oresp->Fecha 		= fechaNacional($row['fecha']);
				$Oresp->Success 	= 'true';
				$resp[]=$Oresp;
		 }
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$Oresp->Text = (string) $e->getMessage();
		$resp[]=$Oresp;
	}
	return $resp;
}

public function GetMovimientosList($start, $limit, $sidx, $sord,$filters=null){
	$idUsuario = $_SESSION["idUsuario"];
	$IP = 'localhost';

	$where = $this->devolverParametros($filters);

	$resp = Array();
	try {
		$con = new conectarBase();
		$query= "CALL seguridad.Transacciones_Listar( 
         ".$idUsuario.",
         '".$IP."',
		 '".$where."',
          ".$start.",
          ".$limit.",
		  ".$sidx.",
		 '".$sord."')";	
		 //echo $query;
		 //exit;
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
			$Oresp = new stdClass();
			$Oresp->idEquipo 				= (int) 	$row['idEquipo'];
			$Oresp->serie 					= (string) 	$row['serie'];
			$Oresp->idBolsa 				= (string) 	$row['idBolsa'];
			$Oresp->idTransaccion 			= (int) 	$row['idTransaccion'];
			$Oresp->idTransaccionMaquina 	= (int) 	$row['idTransaccionMaquina'];
			$Oresp->idDetalle 				= (int) 	$row['idDetalle'];
			$Oresp->fecha 					= (string) 	$row['fechaHora'];
			$Oresp->operacion 				= (string) 	$row['tipoOperacion'];
			$Oresp->monto 					= (string) 	$row['monto'];
			$Oresp->saldo 					= (string) 	$row['saldo'];
			$Oresp->usuario 				= (string) 	$row['idusuario'];
			$Oresp->concepto 				= (string) 	utf8_encode($row['concepto']);
			$Oresp->Success 		= 'true';
			$Oresp->Total_Row 		= (int) 	$row['Total_Row'];
			$resp[]=$Oresp;
		 }			
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$Oresp->Text = (string) $e->getMessage();
		$resp[]=$Oresp;
	}
	return $resp;
}
public function GetMovimientosExcel($start, $limit, $sidx, $sord,$filters=null){
	ini_set( 'memory_limit', '1024M' );
    ini_set( 'post_max_size', '1024M' );
    ini_set( 'upload_max_filesize', '1024M' );
    ini_set('max_execution_time', 6000);
    set_time_limit(6000);

	$idUsuario = $_SESSION["idUsuario"];
	$IP = 'localhost';

	$where = $this->devolverParametros($filters);

	$resp = Array();
	try {
		$con = new conectarBase();
		$query= "CALL seguridad.Transacciones_Listar( 
         ".$idUsuario.",
         '".$IP."',
		 '".$where."',
          ".$start.",
          ".$limit.",
		  ".$sidx.",
		 '".$sord."')";	
		 //echo $query;
		 //exit;
		$result= $con->ConsultaSelect($query);
		$Respuesta = new stdClass();
        $Respuesta->Text = 'Serie~~Bolsa~~Transaccion~~Usuario~~Fecha~~Operacion~~Concepto~~Monto~~Saldo'."\n";
		foreach($result as $row){
          $Respuesta->Text .= 
          trim($row['serie']).'~~'
          .trim($row['idBolsa']).'~~'
          .trim($row['idTransaccion']).'~~'
          .trim($row['idusuario']).'~~'
          .trim($row['fechaHora']).'~~'
          .trim($row['tipoOperacion']).'~~'
          .trim(utf8_encode($row['concepto'])).'~~'
          .trim($row['monto']).'~~'
          .trim($row['saldo'])."\n";
		 }			
	}catch ( Exception $e ) {
		$Respuesta = new stdClass();
		$Respuesta->Text = utf8_encode($e->getMessage());
	}
      $Respuesta->Text = str_replace(array(";", "&nbsp", "="), "", $Respuesta->Text);
      $Respuesta->Text = str_replace("~~", ";", $Respuesta->Text);
      return $Respuesta;
}

	public function Sincronizar_Mensajes($tipo, $parametros){
	$curl 		= curl_init();
	$Serie 		= $parametros->serie;
	$idEquipo 	= $parametros->idEquipo;
	$desde 		= $parametros->desde;
	$hasta 		= $parametros->hasta;

	$param  = 'operacion=5';
	$param  .= '&id='.$Serie;
	$param .= '&desde='.$desde;
	$param .= '&hasta='.$hasta;

	curl_setopt_array($curl, array(
	  CURLOPT_PORT => "5000",
	  CURLOPT_URL => APIServidor."event",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => $param,
	  CURLOPT_HTTPHEADER => array(
	    "cache-control: no-cache"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	$resultado5 = $this->GrabarMensajes($response);

	$param  = 'operacion=6';
	$param  .= '&id='.$Serie;
	$param .= '&desde='.$desde;
	$param .= '&hasta='.$hasta;

	curl_setopt_array($curl, array(
	  CURLOPT_PORT => "5000",
	  CURLOPT_URL => APIServidor."event",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => $param,
	  CURLOPT_HTTPHEADER => array(
	    "cache-control: no-cache"
	  ),
	));


	$response = curl_exec($curl);
	$resultado6 = $this->GrabarMensajes($response);

	$con = new conectarBase();
	$query= "update seguridad.equipos set ultimoSinc='".strftime("%Y-%m-%d %X")."' where idEquipo =".$idEquipo;
	//echo $query;
	$con->ConsultaUpdate($query);

	$resultadoTot = (int)$resultado5 + (int)$resultado6;

	return $resultadoTot;
	}

/*** STORE PARA VERSION DE FIRMWARE 100 LLAMADO DESDE SINCRONIZAR ***/
public function GrabarMensajes($mensaje){
	$oUsu = new stdClass();
	$oUsu->Id = $_SESSION["idUsuario"];
	$oUsu->Session = new stdClass();
	$oUsu->Session->Ip = 'localhost';
	try {
		$con1 = new conectarBase();
		$cantActualizados = 0;
		$Objmensaje=json_decode($mensaje,true);
		//echo '<pre>';
		//print_r($Objmensaje);
		//exit;

		foreach($Objmensaje as $row){
			$strmensaje=json_encode($row,true);
			$query= "CALL __Transaccion_Guardar('','".$strmensaje."')";	
			$result= $con1->ConsultaSelect($query);
			
			foreach($result as $row){
 				// si actualizo alguno que no existia y el idEquipo obtenido es valido
 				//print_r($row);
				if($row['_idTransaccionAnt'] == '' ){
					$cantActualizados ++;
				}				
		 	}		
		}
	}catch ( Exception $e ) {
		$cantActualizados = 0;
	}
	return $cantActualizados;
}

public function buscarAlertas(){
	$idUsuario = $_SESSION["idUsuario"];

	try {
		$con = new conectarBase();
		$query= "CALL Panel_buscarPeriodico(".$idUsuario.")";
 		//echo $query;
 		//exit;
 		$resp = array();
		$result= $con->ConsultaSelect($query);
		//print_r($result);
		//exit;
		foreach($result as $row){
			$id = $row['id'];
			$serie = utf8_encode($row['serie']);
			$fecha = fechaNacional($row['fecha']);
			$strmensaje= '{"I":'.$id.',"O":3,"T":"'.$fecha.'"}';
			$query= "CALL Transaccion_Guardar('".$serie."','".$strmensaje."')";	
 			//echo $query;
 			//exit;
			$con->ConsultaSelect($query);
		}

		$query= "CALL Panel_buscarAlertas(".$idUsuario.")";
 		//echo $query;
 		//exit;
 		$resp = array();
		$result= $con->ConsultaSelect($query);
		foreach($result as $row){
				$Oresp = new stdClass();
				$Oresp->id 			= $row['id'];
				$Oresp->serie 		= utf8_encode($row['serie']);
				$Oresp->mensaje	= utf8_encode($row['mensaje']);
				$Oresp->Fecha 		= $row['fecha'];
				$Oresp->Success 	= 'true';
				$resp[]=$Oresp;
		 }
	}catch ( Exception $e ) {
		$Oresp = new stdClass();
		$Oresp->Success = (string) 'false';
		$Oresp->Text = (string) $e->getMessage();
		$resp[]=$Oresp;
	}
	return $resp;
}

}
?>