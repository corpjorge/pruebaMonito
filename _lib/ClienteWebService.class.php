<?php
/*require_once 'SOAP/Client.php';
require_once ('WebService_ConsultarEmpleadoService_HTTP_Port.php');
require_once ('WebService_Contratos_CivilesService_HTTP_Port.php');
require_once ('WebService_Objetos_CostoService_HTTP_Port.php');
require_once ('WebService_contratoService_contratoPort.php');
require_once ('WebService_empleadoService_empleadoPort.php');
require_once ('WebService_objcostoService_objcostoPort.php');
require_once ('WebService_erpService_erpPort.php');
require_once ('WebService_MONITORIASService_HTTP_Port.php');*/

require_once ('nusoap/lib/nusoap.php');

class ClienteWebService {

	/**
	 * ClienteWebService::contratacionConsultarDatos()
	 *
	 * Consume el servicio de contratación para extraer los datos del empleado
	 *
	 * @param $documento
	 * @return
	 **/
	function contratacionConsultarDatos($documento) {

		global $soap;
		
		$parametros = array(
			'NUMERO_DOCUMENTO' => $documento
		);
	
		$proxy = $this->webServiceConnect($soap['INFOEMPLEADO']);
		$datosEmpleado = $proxy->CONSULTA_BASICA_EMPLEADO($parametros);
		
		if (!empty($datosEmpleado['ERROR']['TIPO'])) {
			return false;
		}
		return $datosEmpleado['RESULTADO'];
	}
	
	/**
	 * ClienteWebService::contratoCivilConsultar()
	 *
	 * Consume el servicio de contrato civil para consultar si el empleado tiene contrato activo
	 *
	 * @param $documento
	 * @return
	 **/
	function contratoCivilConsultar($documento){

		global $soap;

		$parametros = array(
			'DOCUMENTO' => $documento
		);
	
		$proxy = $this->webServiceConnect($soap['PI']);
		$contratoCivil = $proxy->VALIDAR_CONTRATO_CIVIL($parametros);
		if (!empty($contratoCivil->ERROR->TIPO)) {
			return false;
		}
		return $contratoCivil->ESTADO;
	}
	
	/**
	 * ClienteWebService::objetosCosto()
	 *
	 * Consume el servicio de objetos costos para obtener el listado para un usu
	 *
	 * @param $documento
	 * @return
	 **/
	function objetosCosto($usuario, $modulo){

		global $soap;

		$parametros = array(
			'USUARIO' => $usuario,
			'TIPO_OBJETO' => $modulo
		);
		
		$proxy = $this->webServiceConnect($soap['PI']);
		$objetosCosto = $proxy->CONSULTAR_OBJETOS_COSTO_USUARIO($parametros);
		if (!empty($objetosCosto['ERROR']['TIPO'])) {
			return false;
		}
		return $objetosCosto['RESULTADO'];
	}
	
	/**
	 * ClienteWebService::consultaInfoEmpleado()
	 *
	 * Consume el servicio de empleadoService (weblogic) para extraer los datos del empleado
	 *
	 * @param $documento
	 * @return
	 **/
	// PI
	function consultaInfoEmpleado($documento) {

		global $soap;

		$parametros = array(
			'NUMERO_DOCUMENTO' => $documento
		);
		
		$proxy = $this->webServiceConnect($soap['INFOEMPLEADO']);		
		$datosEmpleado = $proxy->CONSULTA_BASICA_EMPLEADO($parametros);	

		if (!empty($datosEmpleado->MENSAJES) && $datosEmpleado->MENSAJES->TIPO !=  "" ) {
			return "N";
		}
		
		if (empty($datosEmpleado->MENSAJES)){
			return false;
		} 

		return $datosEmpleado;
	}
	
	/**
	 * ClienteWebService::contratoService()
	 *
	 * Consume el servicio de contratoService (weblogic) para verificar el contrato civil
	 *
	 * @param $documento
	 * @return
	 **/
	// PI
	function contratoService($documento) {

		global $soap;

		$parametros = array(
			'DOCUMENTO' => $documento
		);
	
		$proxy = $this->webServiceConnect($soap['PI']);
		$contratoCivil = $proxy->VALIDAR_CONTRATO_CIVIL($parametros);
		if (empty($datosEmpleado->ERROR) && $datosEmpleado->ESTADO != "S") {
			return "N";
		}
		if (!empty($datosEmpleado->ERROR)){
			return false;
		} 
		return $contratoCivil->ESTADO;
	}
	
	/**
	 * ClienteWebService::objcostoService()
	 *
	 * Consume el servicio objcostoService (WebLogic) para obtener  
	 * el listado de objetos de costo por usuario y modulo
	 *
	 * @param $usuario
	 * @param $modulo
	 * @return
	 **/
	//PI
	function objcostoService($usuario, $modulo){

		global $soap;

		$parametros = array(
			'USUARIO' => $usuario,
			'TIPO_OBJETO' => $modulo
		);
		$proxy = $this->webServiceConnect($soap['PI']);
		
		$objetosCosto = $proxy->CONSULTAR_OBJETOS_COSTO_USUARIO($parametros);
	
		if (!empty($objetosCosto->ERROR->TIPO)) {
			return false;
		}
		return $objetosCosto->RESULTADO;
	}
	
	/**
	 * ClienteWebService::objcostoService()
	 *
	 * Consume el servicio erpService (WebLogic) para obtener el listado 
	 * de usuarios relacionados a un objetos de costo y un modulo
	 *
	 * @param $objetoCosto
	 * @param $modulo
	 * @return
	 **/
	//PI
	function erpServiceConsultaUsuarioObjetoCosto($objetoCosto, $modulo){

		global $soap;

		$parametros = array(
			'CENTRO_COSTO' => $objetoCosto,
			//'modulo' => $modulo
		);
	
		$proxy = $this->webServiceConnect($soap['PI']);
		$objetosCosto = $proxy->MCONSULTAR_USUARIOS_CENTRO_COSTO($parametros);
		if (!empty($objetosCosto['ERROR']['TIPO'])) {
			return false;
		}
		return $objetosCosto['RESULTADO'];
	}
	
	/**
	 * ClienteWebService::erpServiceConsultaFondosPresupuestales()
	 *
	 * Consume el servicio erpService (WebLogic) para obtener 
	 * el listado de fondos presupuestales
	 *
	 * @param 
	 * @return
	 **/
	//PI
	function erpServiceConsultaFondosPresupuestales(){

		global $soap;

		$parametros = array(
		);
	
		$proxy = $this->webServiceConnect($soap['PI']);
		$objetosCosto = $proxy->CONSULTAR_FONDOS_PRESUPUESTALES($parametros);

		if (!empty($objetosCosto->ERROR->TIPO)) {
			return false;
		}
		return $objetosCosto->FONDO_PRESUPUESTAL;
	}
	
	public function webServiceConnect($soapConf){
		// $client = new nusoap_client($soapConf['URL'], 'wsdl', '', '', '', '');
		// $err = $client->getError();
	
		// $client->setCredentials($soapConf['USER'], $soapConf['PASS'], "basic");
		
		// return $client->getProxy();
		
		$client 	= new SoapClient($soapConf['URL'] ,  array('login'          => $soapConf['USER'],
		
														   'password'       => $soapConf['PASS']));
														   
	   return $client;	
	}
	
/*
	function llamadoWebServiceMatriculas(){
	
		require_once 'SOAP/Client.php';
		require_once ('WebService_RecaudosService_HTTP_Port.php');
	
		$parametros = array(
				'IREFERENCIA' => '78789789',
				'ISITIO' => 'sdfsd'
		);
	
		$wsdl_url =
		'http://conveniospr.uniandes.edu.co/wsdl/recaudos.wsdl';
		$WSDL     = new SOAP_WSDL($wsdl_url);
	
		//echo $WSDL->generateProxyCode();
		//exit(0);
	
		$proxy = $WSDL->getProxy();
	
		//	$result = $proxy->ConsultaEstado($parametros);
		$result = $proxy->ConsultaTransaccion($parametros);
	
		//	var_dump($proxy);
		var_dump($result);
		exit(0);
	}
*/
	

}

?>