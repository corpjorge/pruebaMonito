<?php

class WebService_erpService_erpPort extends SOAP_Client {
	
	function WebService_erpService_erpPort() {
		$path = 'http://' . SERVIDOR_WL . '/consultaTabla/erpPort';
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
	
	function &consultaFondosPresupuestales($consultaFondosPresupuestales) {
		$consultaFondosPresupuestales = new SOAP_Value('{http://ws.uniandes.edu.co/}consultaFondosPresupuestales', 'consultaFondosPresupuestales', $consultaFondosPresupuestales);
		$result = $this->call('consultaFondosPresupuestales',
			$v = array('consultaFondosPresupuestales' => $consultaFondosPresupuestales),
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