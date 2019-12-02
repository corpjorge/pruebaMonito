<?php

class WebService_ConsultarEmpleadoService_HTTP_Port extends SOAP_Client {

	function WebService_ConsultarEmpleadoService_HTTP_Port() {
		$path = 'http://' . SERVIDOR_PI .'/XISOAPAdapter/MessageServlet?senderParty=&senderService=ERD&receiverParty=&receiverService=&interface=ConsultarEmpleado&interfaceNamespace=http%3A%2F%2Funiandes.edu.co%2FConsEmpleados';
		$opciones = array(
			'user' => USUARIO_PI,
			'pass' => PASSWORD_PI
		);
		$this->SOAP_Client($path, 0, 0, $opciones);
	}
	
	function &ConsultarEmpleado($MT_ConsultarEmpleado) {
		// MT_ConsultarEmpleado is a ComplexType, refer to the WSDL for more info.
		$MT_ConsultarEmpleado = new SOAP_Value('{http://uniandes.edu.co/ConsEmpleados}MT_ConsultarEmpleado', 'DT_ConsultarEmpleado', $MT_ConsultarEmpleado);
		$result = $this->call('ConsultarEmpleado',
			$v = array('MT_ConsultarEmpleado' => $MT_ConsultarEmpleado),
			array('namespace' => 'http://uniandes.edu.co/ConsEmpleados',
				'soapaction' => '',
				'style' => '',
				'use' => ''
			)
		);
		return $result;
	}
}

?>