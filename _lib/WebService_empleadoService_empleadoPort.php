<?php

class WebService_empleadoService_empleadoPort extends SOAP_Client {
	
	function WebService_empleadoService_empleadoPort() {
		$path = 'http://' . SERVIDOR_WL . '/hcm/empleadoPort';
		$this->SOAP_Client($path, 0);
	}
	
	function &consultaInfoEmpleado($consultaInfoEmpleado) {
		$consultaInfoEmpleado = new SOAP_Value('{http://ws.uniandes.edu.co/}consultaInfoEmpleado', 'consultaInfoEmpleado', $consultaInfoEmpleado);
		$result = $this->call('consultaInfoEmpleado',
			$v = array('consultaInfoEmpleado' => $consultaInfoEmpleado),
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