<?php
/**
* Pagina de inicio del proyecto
*
* @author   Edwin Lasso <elasso@uniandes.edu.co>
*/
    require_once('./_conf/constantes.php');
    require_once(CONFIG_DIR . 'variables.php');
    require_once(LIB_DIR . 'Funciones.php');
    require_once(LIB_DIR . 'Sesion.class.php');
// if($_SERVER[HTTP_CLIENT_IP] != "157.253.93.68"){
// header("Location: https://mantenimiento.uniandes.edu.co");
// die();
// }
    init();
	//Mezcle los dos arreglos por si enviamos algunos parametros por get
    if (!empty($_GET)) {
    	$_POST = array_merge($_GET, $_POST);
    }

    $unSesion = new Sesion('PHPSESSID', 'LDAP', $params, 'formaAutenticacion', TRUE);

    if ($unSesion->getAuth()) {
    	include(SCRIPTS_DIR . 'index.php');
    } else {
    	unset($_SESSION);
    }
    
?>
