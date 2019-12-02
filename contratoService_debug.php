<?php

	require_once('./_conf/constantes.php');
	require_once(CONFIG_DIR . 'variables.php');
	require_once(LIB_DIR . 'Funciones.php');
//	require_once(LIB_DIR . 'Lo_Estudiante.class.php');
	require_once(LIB_DIR . 'ClienteWebService.class.php');
	
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

    $objetos = $unCliente->objcostoService('a.soler67', 'CO');
    var_dump($objetos);

*/

    $unCliente = new ClienteWebService();
    $objetos = $unCliente->contratoService('95040605470888888');
//    $unCliente->llamadoWebServiceMatriculas();
    
    echo "<pre>";
    print_r($objetos);
    
    
?>