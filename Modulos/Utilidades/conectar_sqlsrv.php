<?php

class conectarBase{

	/**
	 * (non-PHPdoc)
	 * @see conectar::ConsultaSelect()
	 * 
	 * @return Object
	 */
	public function ConsultaSelect($query){
		$conn = mysqli_connect("localhost","","","");
	    if ($execquery = $conn->query($query)) {
	        $result = $execquery->fetch_all(MYSQLI_ASSOC);
	        return $result;
	    }
	}
}
