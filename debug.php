<?php

	ini_set('display_errors',1);
	ini_set('error_reporting',"E_ALL");
	error_reporting(E_ALL);
	ini_set("memory_limit","512M");
	require_once('./_conf/constantes.php');
	require_once(CONFIG_DIR . 'variables.php');
	require_once(LIB_DIR . 'Funciones.php');
	//require_once(LIB_DIR . 'Lo_Estudiante.class.php');
require_once(LIB_DIR . 'ClienteWebService.class.php');
require_once 'SOAP/Client.php';
require_once (LIB_DIR .'WebService_ConsultarEmpleadoService_HTTP_Port.php');
require_once (LIB_DIR .'WebService_Contratos_CivilesService_HTTP_Port.php');
require_once (LIB_DIR .'WebService_Objetos_CostoService_HTTP_Port.php');
require_once (LIB_DIR .'WebService_contratoService_contratoPort.php');
require_once (LIB_DIR .'WebService_empleadoService_empleadoPort.php');
require_once (LIB_DIR .'WebService_objcostoService_objcostoPort.php');
require_once (LIB_DIR .'WebService_erpService_erpPort.php');

	
    init();
	//Mezcle los dos arreglos por si enviamos algunos parametros por get
    if (!empty($_GET)) {
    	$_POST = array_merge($_GET, $_POST);
    }
/*
    $codigo = 201214613;
    $unEstudiante = new Lo_Estudiante();
	$datosEstudiante = $unEstudiante->cargarDatosBasicosBanner($codigo);
	var_dump($codigo);
	var_dump($datosEstudiante);
*/
/*
    $unCliente = new ClienteWebService();
    $objetos = $unCliente->erpModServiceModificarTelefonos('1010221317', '5555555', '5555555555');
    var_dump($objetos);
*/
    /*
	$unEstudiante = new Lo_Estudiante();
	$unEstudiante->documento = '1010221317';
	$unEstudiante->telefono = '6666666';
	$unEstudiante->celular = '6666666666';
	$modif = $unEstudiante->modificarTelefonosSAP();
	var_dump($modif);*/
	
	 $unEmpleado = new ClienteWebService();
	 //$datosEmpleado =  consultaInfoEmpleado("1026573700");
	 //$datosCivil 	=  contratoService("1026573700 ");
	 //$centroCostosElvis = objcostoService("ea.heredia20", 'CO');
	 // $centroCostosMlagos = objcostoService("mlagos", 'CO');
	 $login = "adgonzal";
	 
	 $objcostoServicedebu = objcostoServicedebu($login, 'CC');
	 $objcostoService = objcostoService($login,'CO');
	 //$datosEmpleado2 = $unEmpleado->contratacionConsultarDatos("1032444239");
	echo "<pre> Login: ".$login ;
	//print_r($datosEmpleado);
	//print_r($datosCivil);
	echo '<pre>';
	print_r($objcostoServicedebu);
	// print_r($objcostoService);
	echo '</pre>';
	exit;

	
	
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
	function objcostoServicedebu($usuario, $modulo){
		$parametros = array(
			'login' => $usuario,
			'modulo' => $modulo
		);
	
		$urlWSDL = URL_WSDL . 'old_pi.wsdl';
		error_reporting(E_ALL ^ E_NOTICE);
		$WSDL = new SOAP_WSDL($urlWSDL);
		error_reporting(E_ALL);
	
		$proxy = $WSDL->getProxy();
		$objetosCosto = $proxy->consultaUsuarioObjetoCosto($parametros);
		if (PEAR::isError($objetosCosto)) {
			return FALSE;
		}
		return $objetosCosto;
	}
	
	
	
	
	
	function objcostoService($usuario, $modulo){
		$parametros = array(
				'login' => $usuario,
				'modulo' => $modulo
		);
	
		$urlWSDL = URL_WSDL . 'objcostoservice.wsdl';
		error_reporting(E_ALL ^ E_NOTICE);
		$WSDL = new SOAP_WSDL($urlWSDL);
		error_reporting(E_ALL);
	
		$proxy = $WSDL->getProxy();
		$objetosCosto = $proxy->consultaUsuarioObjetoCosto($parametros);
		if (PEAR::isError($objetosCosto)) {
			return FALSE;
		}
		return $objetosCosto;
	}
    
?>
