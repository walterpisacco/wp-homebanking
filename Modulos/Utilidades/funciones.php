<?php	

function BuscarPerfil($perfiles){
 	$perfilUsu = $_SESSION["perfil"];
 	$perfil = explode(",",$perfiles);

 	foreach ($perfil as $val) {
 		if($perfilUsu == $val)
 			{ 
 				return true;
 			}
 	}

 	return false;
}

function fechaInternacional($fecha){
	if (strlen($fecha) >= 10){
		return $fecha = trim(substr($fecha,6,4).'-'.substr($fecha,3,2).'-'.substr($fecha,0,2).' '.substr($fecha,11,5));	
	} 
}

function fechaNacional($fecha){
	if (strlen($fecha) >= 10){
		return $fecha = trim(substr($fecha,8,2).'/'.substr($fecha,5,2).'/'.substr($fecha,0,4).' '.substr($fecha,11,5));	
	} 
}

function calcular_edad($fecha){
	if (strlen($fecha) >= 10){
		$fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); // Creo un objeto DateTime de la fecha ingresada
		$fecha_hoy =  new DateTime(date('Y/m/d',time())); // Creo un objeto DateTime de la fecha de hoy
		$edad = date_diff($fecha_hoy,$fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto
		return  $edad->format('%Y');
	}
}

function calcular_antiguedad($fecha){
	if (strlen($fecha) >= 10){
		$fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); // Creo un objeto DateTime de la fecha ingresada
		$fecha_hoy =  new DateTime(date('Y/m/d',time())); // Creo un objeto DateTime de la fecha de hoy
		$antiguedad = date_diff($fecha_hoy,$fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto
		return  $antiguedad->format('%Y').' años, '.$antiguedad->format('%m').' meses';
	}
}


?>