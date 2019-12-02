<?php

class WebService_Contratos_CivilesService_HTTP_Port extends SOAP_Client
{
	function WebService_Contratos_CivilesService_HTTP_Port() {
		$path = 'http://' . SERVIDOR_PI .'/XISOAPAdapter/MessageServlet?senderParty=&senderService=ERD&receiverParty=&receiverService=&interface=Contratos_Civiles&interfaceNamespace=http%3A%2F%2Funiandes.edu.co%2FContratosCivilesPrincipal';
		$opciones = array(
			'user' => USUARIO_PI,
			'pass' => PASSWORD_PI
		);
		$this->SOAP_Client($path, 0, 0, $opciones);
	}
	
	function &consultar($MT_Contrato_Req) {
		$MT_Contrato_Req = new SOAP_Value('{http://uniandes.edu.co/ContratosCiviles}MT_Contrato_Req', 'DT_Contrato_Req', $MT_Contrato_Req);
		$result = $this->call('consultar',
			$v = array('MT_Contrato_Req' => $MT_Contrato_Req),
			array('namespace' => 'http://uniandes.edu.co/ContratosCivilesPrincipal',
				'soapaction' => '',
				'style' => '',
				'use' => ''
			)
		);
		return $result;
	}
	
}

?>