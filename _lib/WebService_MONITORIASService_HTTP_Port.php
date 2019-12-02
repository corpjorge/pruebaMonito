<?php
class WebService_MONITORIASService_HTTP_Port extends SOAP_Client {
	
	function WebService_MONITORIASService_HTTP_Port() {
		//$path = "http://".URL_WSDL_PI."/XISOAPAdapter/MessageServlet?senderParty=&senderService=MONITORIA_QA&receiverParty=&receiverService=&interface=MONITORIAS&interfaceNamespace=http%3A%2F%2Funiandes.edu.co%2Fmonitorias";
		$path = "http://".URL_WSDL_PI."/XISOAPAdapter/MessageServlet?senderParty=&senderService=MONITORIA_PR&receiverParty=&receiverService=&interface=MONITORIAS&interfaceNamespace=http%3A%2F%2Funiandes.edu.co%2Fmonitorias";

		$opciones = array(
				'user' => WS_USER_PI,
				'pass' => WS_PASS_PI
		);
		$this->SOAP_Client($path,0,0,$opciones);
	}
	
	//Co_Estudiante
	function &MONITORIAS_CONSULTAR_EMPLEADO($consultaInfoEmpleado)
	{
		//Pendiente
		$consultaInfoEmpleado = new SOAP_Value('{http://uniandes.edu.co/monitorias}MT_CONSULTAR_EMPLEADO', 'DT_CONSULTAR_EMPLEADO', $consultaInfoEmpleado);
		$result = $this->call('MONITORIAS_CONSULTAR_EMPLEADO',
			$v = array('MT_CONSULTAR_EMPLEADO' => $consultaInfoEmpleado),
			array('namespace' => 'http://uniandes.edu.co/monitorias',
				'soapaction' => '',
				'style' => '',
				'use' => ''
			)
		);
		return $result;
	}
	
	function &MONITORIAS_VALIDAR_CONTRATO_CIVIL($consultarCC)
	{
		$consultarCC = new SOAP_Value('{http://uniandes.edu.co/monitorias}MT_VALIDAR_CONTRATO_CIVIL', 'DT_VALIDAR_CONTRATO_CIVIL', $consultarCC);
		$result = $this->call('MONITORIAS_CONSULTAR_EMPLEADO',
			$v = array('MT_VALIDAR_CONTRATO_CIVIL' => $consultarCC),
			array('namespace' => 'http://uniandes.edu.co/monitorias',
				'soapaction' => '',
				'style' => '',
				'use' => ''
			)
		);
		return $result;
	}
	
	//Co_Convenios
	function &MONITORIAS_CONSULTAR_FONDOS_PRESUPUESTALES($parametros)
	{
		$parametros = new SOAP_Value('{http://uniandes.edu.co/monitorias}MT_CONSULTAR_FONDOS_PRESUPUESTALES', 'DT_CONSULTAR_FONDOS_PRESUPUESTALES', $parametros);
		$result = $this->call('MONITORIAS_CONSULTAR_FONDOS_PRESUPUESTALES',
			$v = array('MT_CONSULTAR_FONDOS_PRESUPUESTALES' => $parametros),
			array('namespace' => 'http://uniandes.edu.co/monitorias',
				'soapaction' => '',
				'style' => '',
				'use' => ''
			)
		);
		return $result;
	}

	function &MONITORIAS_CONSULTAR_OBJETOS_COSTO_USUARIO($parametros)
	{
		$parametros = new SOAP_Value('{http://uniandes.edu.co/monitorias}MT_CONSULTAR_OBJETOS_COSTO_USUARIO', 'DT_CONSULTAR_OBJETOS_COSTO_USUARIO', $parametros);
		$result = $this->call('MONITORIAS_CONSULTAR_OBJETOS_COSTO_USUARIO',
			$v = array('MT_CONSULTAR_OBJETOS_COSTO_USUARIO' => $parametros),
			array('namespace' => 'http://uniandes.edu.co/monitorias',
				'soapaction' => '',
				'style' => '',
				'use' => ''
			)
		);
		return $result;
	}

	function &MONITORIAS_CONSULTAR_USUARIOS_CENTRO_COSTO($parametros)
	{
		$parametros = new SOAP_Value('{http://uniandes.edu.co/monitorias}MT_CONSULTAR_USUARIOS_CENTRO_COSTO', 'DT_CONSULTAR_USUARIOS_CENTRO_COSTO', $parametros);
		$result = $this->call('MONITORIAS_CONSULTAR_USUARIOS_CENTRO_COSTO',
			$v = array('MT_CONSULTAR_USUARIOS_CENTRO_COSTO' => $parametros),
			array('namespace' => 'http://uniandes.edu.co/monitorias',
				'soapaction' => '',
				'style' => '',
				'use' => ''
			)
		);
		return $result;
	}
}
?>