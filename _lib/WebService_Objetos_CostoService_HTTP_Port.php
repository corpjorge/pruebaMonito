<?php

class WebService_Objetos_CostoService_HTTP_Port extends SOAP_Client
{
	function WebService_Objetos_CostoService_HTTP_Port() {
		$path = 'http://' . SERVIDOR_PI .'/XISOAPAdapter/MessageServlet?senderParty=&senderService=ERD&receiverParty=&receiverService=&interface=Objetos_Costo&interfaceNamespace=http%3A%2F%2Funiandes.edu.co%2FObjetosCosto';
		$opciones = array(
			'user' => USUARIO_PI,
			'pass' => PASSWORD_PI
		);
		$this->SOAP_Client($path, 0, 0, $opciones);
	}
	
	function &Objetos_Costo($MT_Objcostos_req) {
		$MT_Objcostos_req = new SOAP_Value('{http://uniandes.edu.co/ObjetosCosto}MT_Objcostos_req', 'DT_Objcostos_req', $MT_Objcostos_req);
		$result = $this->call('Objetos_Costo',
			$v = array('MT_Objcostos_req' => $MT_Objcostos_req),
			array('namespace' => 'http://uniandes.edu.co/ObjetosCosto',
				'soapaction' => '',
				'style' => '',
				'use' => ''
			)
		);
		return $result;
	}
	
}

?>