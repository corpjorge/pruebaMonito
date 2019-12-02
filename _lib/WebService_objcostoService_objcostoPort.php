<?php

class WebService_objcostoService_objcostoPort extends SOAP_Client {
	
	function WebService_objcostoService_objcostoPort() {
		$path = 'http://' . SERVIDOR_WL . '/erp/objcostoPort';
		$this->SOAP_Client($path, 0);
	}
	
	function &consultaUsuarioObjetoCosto($consultaUsuarioObjetoCosto) {
		$consultaUsuarioObjetoCosto = new SOAP_Value('{http://ws.uniandes.edu.co/}consultaUsuarioObjetoCosto', 'consultaUsuarioObjetoCosto', $consultaUsuarioObjetoCosto);
		$result = $this->call('consultaUsuarioObjetoCosto',
			$v = array('consultaUsuarioObjetoCosto' => $consultaUsuarioObjetoCosto),
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