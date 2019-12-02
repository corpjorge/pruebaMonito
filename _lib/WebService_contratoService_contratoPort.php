<?php

class WebService_contratoService_contratoPort extends SOAP_Client {
	
	function WebService_contratoService_contratoPort() {
		$path = 'http://' . SERVIDOR_WL . '/mm/contratoPort';
		$this->SOAP_Client($path, 0);
	}
	
	function &consultar($consultar) {
		$consultar = new SOAP_Value('{http://ws.uniandes.edu.co/}consultar', 'consultar', $consultar);
		$result = $this->call('consultar',
			$v = array('consultar' => $consultar),
			array('namespace' => 'http://ws.uniandes.edu.co/',
				'soapaction' => '',
				'style' => '',
				'use' => ''
			)
		);
		return $result;
	}
}

?>