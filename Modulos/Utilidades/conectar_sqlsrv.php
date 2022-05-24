<?php

class conectarBase{

	/**
	 * (non-PHPdoc)
	 * @see conectar::ConsultaSelect()
	 * 
	 * @return Object
	 */
	public function ConsultaSelect($query){
		//$conn = mysqli_connect("iothinks.drexgen.com","admin_iothinks","Global*3522","seguridad");
		$conn = mysqli_connect("aktis.drexgen.com","admin_iothinks","Global*3522","seguridad");
		//$conn = mysqli_connect("lg.drexgen.com","admin_iothinks","Global*3522","seguridad");
		//$conn = mysqli_connect("localhost","admin_iothinks","Global*3522","seguridad");
	    if ($execquery = $conn->query($query)) {
	        $result = $execquery->fetch_all(MYSQLI_ASSOC);
	        return $result;
	    }
	}
}