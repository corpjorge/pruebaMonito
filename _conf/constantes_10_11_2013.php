<?php

/* Constantes */
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL);

// Nombre de la aplicacion
define ('APLICACION'    , 'Universidad de los Andes :: Sistema de Monitorias');

// Manejo de Errores
define ('E_PEAR'        , 0);
define ('CORREO_ERROR'  , FALSE); //USE false si no quiere recibir los correos de error
define ('MODO_PRUEBAS'  , FALSE);

// URLs
define ('URL_BASE'      , 'http://'. $_SERVER['SERVER_NAME']);
define ('URL_RELATIVA'  , '/');
define ('URL_SITIO'     , URL_BASE . URL_RELATIVA);
define ('URL_SITIO_ESC' , URL_BASE . ':8088' . URL_RELATIVA);
define ('URL_WSDL'      , URL_SITIO . 'wsdl/');

// Directorios
define ('BASE_DIR'      , '/datos/hypertext/monitorias.uniandes.edu.co.80/');
define ('TPL_DIR'       , BASE_DIR . '_tpl/');
define ('TMP_DIR'       , BASE_DIR . '_tmp/');
define ('CONFIG_DIR' 	, BASE_DIR . '_conf/');
define ('LIB_DIR' 		, BASE_DIR . '_lib/');
define ('LOG4PHP_DIR'	, LIB_DIR  . 'log4php/');
define ('LOG_DIR' 		, BASE_DIR . '_log/');
define ('JS_DIR' 		, BASE_DIR . 'js/');
define ('SCRIPTS_DIR' 	, BASE_DIR . '_scripts/');
define ('IMG_DIR' 		, BASE_DIR . 'img/');
define ('CSS_DIR' 		, BASE_DIR . 'css/');
define ('CONFIG_FILE'   , CONFIG_DIR . 'config.ini');
define ('PREFIX_DIR'    , LIB_DIR);

//Parámetros de conexión a la base de datos del sitio
define ('BD_HOST'	        , 'daimon.uniandes.edu.co');
define ('BD_USUARIO'        , 'convenios');
define ('BD_PASS'           , 'zL0_s65a');
define ('BD_NOMBRE'         , 'APPS.daimon');
define ('BD_TIPO'           , 'oci8');

define ('BD_CONEXION'       , BD_TIPO . "://"
							. BD_USUARIO . ":"
							. BD_PASS  . "@"
							. BD_HOST . "/"
							. BD_NOMBRE);

//Parametrizacion
define ('PREFIJO', 'ConEdu');

// ClienteWebService
//define('SERVIDOR_PI', 'pidev.uniandes.edu.co');
define('SERVIDOR_PI', 'pi.uniandes.edu.co:50200');
define('SERVIDOR_WL', 'appserver01.uniandes.edu.co');
//define('USUARIO_PI', 'PRUEBASUA');
//define('PASSWORD_PI', 'andes2011');
define('USUARIO_PI', 'mvargas');
define('PASSWORD_PI', 'bscon001');

// Envío correo
define ('HOST_CORREO', 'smtp.uniandes.edu.co');
define ('PORT_CORREO', 25);
define ('NOMBREREMITENTE', 'Sistema de Monitorias');
define ('CORREOREMITENTE', 'monitorias@uniandes.edu.co');
define ('ASUNTO', 'Confirmación Solicitud - Sistema de Monitorias');

//Autenticacion
// ERRORES
define ('MSG_AUTH_IDLED' 	, "Se alcanzó el tiempo máximo de inactividad,\n Por favor ingrese de nuevo");
define ('MSG_AUTH_EXPIRED' 	, "Se alcanzó el tiempo máximo de autenticación,\n Por favor ingrese de nuevo");
define ('MSG_WRONG_LOGIN' 	, "El nombre de usuario o la contraseña son inválidos,\n Por favor digítelos de nuevo"); 
define ('MSG_NO_INSCRITO' 	, 'El usuario no se encuentra inscrito en el sistema');
define ('MSG_NO_PERMISOS' 	, 'El usuario no tiene permisos asignados en el sistema');
define ('AUTH_NO_INSCRITO' 	, -7);
define ('AUTH_NO_PERMISOS' 	, -8);

// Textos Formato
define ('PDF_TXT_1', 'Teniendo conocimientos que la Universidad premia a aquellos estudiantes que sobresalen por razones de rendimiento académico, conducta ejemplar y notables condiciones humanas, y que establece en el artículo 83, Capítulo noveno, del Reglamento General de Estudiantes, comodistinción el desarrollo de monitorías que les permitirá participar en los procesos docentes o investigativos mediante actividades que contribuyan a su formación profesional y personal, YO.');
define ('PDF_TXT_2', 'Suscribo con la Universidad de los Andes este convenio a través del cual me comprometo a desarrollar las actividades de monitoría que se señalan a acontinuación :');
define ('PDF_TXT_3', 'Es claro que bajo este convenio educativo adquiero las responsabilidades derivadas de la distinción que como monitor me fue otorgada por la Universidad sin abandonar mis obligaciones académicas como estudiante.');
define ('PDF_TXT_4', 'Para constancia se firma en Bogotá D.C. a los {dia} días del mes de {mes} de {ano} por');

//Logger
define ('LOG4PHP_CONFIGURATION', CONFIG_DIR . 'log4php.xml');
//Otras
if (!defined('DB_DATAOBJECT_NO_OVERLOAD')) define ('DB_DATAOBJECT_NO_OVERLOAD', true);

//En producción debe estar habilitada
ini_set('include_path', ".:" . LIB_DIR . "pear/:" . LIB_DIR . "fpdf/font/");
?>
