<?php
require_once("PEAR.php");
require_once("DB/DataObject/Cast.php");
require_once("HTML/Template/IT.php");

function formaAutenticacion($username, $status, $auth)
{
	global $_POST;
	$mensaje = null;

	if (isset($_POST['status']) && !empty($_POST['status'])) {
		$status = $_POST['status'];
	}

	// Manejamos errores de sesión y autenticación.
	if ($status < 0) {
		switch ($status) {
			case AUTH_IDLED:
				$mensaje = MSG_AUTH_IDLED;
				break;
			case AUTH_EXPIRED:
				$mensaje = MSG_AUTH_EXPIRED;
				break;
			case AUTH_WRONG_LOGIN:
				$mensaje = MSG_WRONG_LOGIN;
				break;
			case AUTH_NO_INSCRITO:
				$mensaje = MSG_NO_INSCRITO;
				break;
			case AUTH_NO_PERMISOS:
				$mensaje = MSG_NO_PERMISOS;
				break;
		} // switch
	} // if
	// Desplegamos la forma autenticación.
	$tpl = new HTML_Template_IT(TPL_DIR);
	$tpl->loadTemplatefile('frmAutenticacion.tpl', TRUE, TRUE);
	$tpl->setVariable('cabezote', cargarCabezote());
	$tpl->setVariable('pie', cargarPie());
	if (isset($_POST['username'])) {
		$tpl->setVariable('username', $username);
	}
	if (!empty($mensaje)) {
		$tpl->setCurrentBlock('MENSAJE');
		$tpl->setVariable("mensaje", $mensaje);
		$tpl->parseCurrentBlock('MENSAJE');
	}
	//    $tpl->setVariable("hiddenSession", imprimirSessionString(TRUE));
	$tpl->parse();
	$tpl->show();
}

function init()
{
	global $params;
	global $cadenaBusqueda;
	global $baseBusqueda;
	global $servidorLDAP;
	global $metodo;

	// Manipulacion de variables de configuracion del php ini
	// ini_set('variable', 'valor');
	setlocale(LC_ALL, 'es_ES');
	// Método para especificar cómo se manejarán los errores.
	//    set_error_handler("errorHandler");
	//    PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'errorHandler');

	/*$params = array(
		'host'     => $servidorLDAP,
		'port' 	   => 389,
		'basedn'   => $baseBusqueda,
		'userattr' => $cadenaBusqueda,
		'debug'    => FALSE,
		'useroc'   => '*',
		'attributes'   => array('uid', 'givenName', 'cn', 'UANumeroDocumento')
	);*/

	$params = array(
		'host'     => $servidorLDAP,
		'port' 	   => 389,
		'binddn'   => 'CN=SvcP-Sop2-Adm,OU=Service Accounts,DC=ad,DC=uniandes,DC=edu,DC=co',
		'bindpw'   => '9ur3^oQ$2qf#',
		'basedn'   => $baseBusqueda,
		'userattr' => $cadenaBusqueda,
		'debug'    => FALSE,
		'useroc'   => '*',
		'attributes'   => array('cn', 'givenName', 'displayName', 'employeeId', 'employeeNumber')
	);

	// TODO: comentariar en produccion
	require_once 'DB/DataObject.php';
	$unDataObject = new DB_DataObject();
	$db = $unDataObject->getDatabaseConnection();
	$result = $db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY'");

	if (DB::isError($result)) {
		header("Cache-Control: no-cache, must-revalidate");
		header('Location: http://inconvenientestecnicos.uniandes.edu.co');
		exit(0);
	}
}

function errorHandler($errno, $errstr = NULL, $errfile = NULL, $errline = NULL, $errcontext = NULL)
{
	$code = null;
	$mesg = null;
	$date = date("Y-m-d H:i:s (T)");
	$errorType = array(
		E_ERROR           => "Error",
		E_WARNING         => "Warning",
		E_PARSE           => "Parsing Error",
		E_NOTICE          => "Notice",
		E_CORE_ERROR      => "Core Error",
		E_CORE_WARNING    => "Core Warning",
		E_COMPILE_ERROR   => "Compile Error",
		E_COMPILE_WARNING => "Compile Warning",
		E_USER_ERROR      => "User Error",
		E_USER_WARNING    => "User Warning",
		E_USER_NOTICE     => "User Notice"
	);

	$showErrors = array(
		E_COMPILE_ERROR, E_COMPILE_WARNING, E_PARSE
	);

	$fatalErrors = array(E_COMPILE_ERROR, E_COMPILE_WARNING, E_PARSE, E_ERROR);
	$userErrors = array(E_USER_ERROR, E_USER_WARNING);

	if (PEAR::isError($errno)) {
		$mesg = $errno->getMessage();
		$code = $errno->getCode();
		echo "<div class='error'>";
		echo "$date <br />\n";
		echo "<b>PEAR Error</b> [$code] $mesg <br />\n";
		//Imprima las lineas y archivos de los llamados donde ocurrio el error
		if (is_array($errno->backtrace)) {
			foreach ($errno->backtrace as $backtrace) {
				echo "$backtrace[file] <b>linea : $backtrace[line]</b><br />\n";
			}
		}
		echo "</div>";
	} else {
		if (in_array($errno, $showErrors)) {
			echo "<div class='error'>";
			echo "$date <br />\n";
			echo "<b>$errorType[$errno]</b> [$errno] $errstr<br />\n";
			echo "$errfile <b>linea : $errline</b><br />\n";
			echo "</div>";
		}
		if (in_array($errno, $userErrors)) {
			echo "<div class='error'>";
			echo "<b>$errorType[$errno]</b> [$errno] <br />$errstr<br />\n";
			echo "</div>";
		}
		if (in_array($errno, $fatalErrors)) {
			die('Imposible continuar ...');
		}
	}
}

function imprimirSessionString($hidden = false)
{
	$idSesion = session_id();
	$nombreSesion = session_name();
	if ($hidden) {
		return  '<input type="hidden" value="' . $idSesion . '" name="' . $nombreSesion . '">';
	} else {
		return  "$nombreSesion=$idSesion";
	}
}

function imprimirOpcionesArreglo($arreglo, $relacion = '', $titulo = '-', $maxCaracteres = 50)
{
	$returnValue = ($titulo == '-') ? '' : '<OPTION VALUE="">' . $titulo . '</OPTION>' . "\n";
	foreach ($arreglo as $key => $value) {
		$selected  = ($relacion == $key) ? ' SELECTED' : '';
		$returnValue .= "<OPTION VALUE=\""
			. $key
			. "\"$selected>"
			. htmlentities(
				ucwords(
					substr($value, 0, $maxCaracteres)
				),
				ENT_QUOTES
			)
			. (strlen($value) > $maxCaracteres ? '...' : '') . "</OPTION>" . "\n";
	}
	return $returnValue;
}

function cargarArregloBD($tabla, $campoIndice, $campoValor, $order = '', $condicion = '')
{
	require_once($tabla . '.php');
	$DOTabla = 'DO' . $tabla;
	$unArreglo = new $DOTabla();

	$unArreglo->selectAdd();
	$unArreglo->selectAdd($campoIndice);
	$unArreglo->selectAdd($campoValor);
	if (!empty($condicion)) {
		$unArreglo->whereAdd($condicion);
	}
	$order = (empty($order)) ? $campoIndice : $order;
	$unArreglo->orderBy($order);
	$unArreglo->find();

	$arreglo = array();
	while ($unArreglo->fetch()) {
		$arreglo[$unArreglo->$campoIndice] = $unArreglo->$campoValor;
	}
	return $arreglo;
}

function cargarCabezote()
{
	global $unSesion;
	$sesionNombreUsuario = FALSE;
	$hiddenSession = '';
	if (isset($unSesion)) {
		$sesionNombreUsuario = $unSesion->obtenerVariable('nombreUsuario');
		$arrayUsuario = $unSesion->obtenerVariable('usuario');
		$hiddenSession = $unSesion->adicionarIdUrl();
		//		$fachada = ($unSesion->obtenerVariable('tipoUsuario') == 'E')?'index.php':'admin.php';
	}
	//$nombreUsuario = ($sesionNombreUsuario === FALSE)?'Guest User':$sesionNombreUsuario;
	$tpl = new HTML_Template_IT(TPL_DIR);
	$tpl->loadTemplatefile('cabezote.tpl', TRUE, TRUE);
	$tpl->setVariable('APLICACION', APLICACION);
	$tpl->setVariable('URL_SITIO', URL_SITIO);
	//$tpl->setVariable("nombreUsuario", $nombreUsuario);
	if ($sesionNombreUsuario === FALSE) {
		$tpl->touchBlock('SINSESION');
	} else {
		$usuarioPermiso = $unSesion->obtenerVariable('usuarioPermiso');
		$usuarioPermisoVisible = $usuarioPermiso['S'];
		$nombreModulo = '';
		foreach ($usuarioPermisoVisible as $vPermiso) {
			if ($nombreModulo != $vPermiso['nombremodulo']) {
				$tpl->setCurrentBlock('MODULO');
				$tpl->setVariable("nombremodulo", $nombreModulo);
				$tpl->parseCurrentBlock('MODULO');
				$nombreModulo = $vPermiso['nombremodulo'];
			}
			$tpl->setCurrentBlock('PERMISO');
			//			$tpl->setVariable('fachadaP', $fachada);
			$tpl->setVariable('nombrepermiso', $vPermiso['nombrepermiso']);
			$tpl->setVariable('clase', $vPermiso['clase']);
			$tpl->setVariable('controlador', $vPermiso['controlador']);
			$tpl->setVariable('metodo', $vPermiso['metodo']);
			$tpl->parseCurrentBlock('PERMISO');
		}
		$nombreModulo = isset($vPermiso['nombremodulo']) ? $vPermiso['nombremodulo'] : '';
		$tpl->setCurrentBlock('MODULO');
		$tpl->setVariable("nombremodulo", $nombreModulo);
		$tpl->parseCurrentBlock('MODULO');
		$tpl->setCurrentBlock('CONSESION');
		$tpl->setVariable("nombreusuario", $arrayUsuario['nombre']);
		//		$tpl->setVariable('fachadaC', $fachada);
		$tpl->parseCurrentBlock('CONSESION');
	}
	$tpl->parse();
	return $tpl->get();
}

function cargarPie()
{
	$tpl = new HTML_Template_IT(TPL_DIR);
	$tpl->loadTemplatefile('pie.tpl', TRUE, TRUE);
	$tpl->setVariable("anoActual", date('Y'));
	$tpl->parse();
	return $tpl->get();
}

function mensajeInicio($mensaje = '')
{
	$tpl = new HTML_Template_IT(TPL_DIR);
	$tpl->loadTemplateFile('frmInicio.tpl', true, true);
	$tpl->setVariable('cabezote', cargarCabezote());
	$tpl->setVariable('pie', cargarPie());
	$tpl->setVariable('URL_SITIO', URL_SITIO);
	if (!empty($mensaje)) {
		$tpl->setCurrentBlock('MENSAJE');
		$tpl->setVariable('mensaje', $mensaje);
		$tpl->parseCurrentBlock('MENSAJE');
	}
	$tpl->parse();
	$tpl->show();
}

function muestreRequerido()
{
	$returnValue = "<a href=\"#\" title=\"" .
		ucfirst(strtolower('Este campo es requerido')) . "\">" . "*" . "</a>&nbsp;";
	return $returnValue;
}

function muestreAlerta($mensaje)
{
	$returnValue = ("<a href=\"#\" title=\"" .
		ucfirst(strtolower($mensaje)) . "\">" . "!" . "</a>&nbsp;");
	return $returnValue;
}

$params = null;


/*$cadenaBusqueda = 'uid';
$servidorLDAP   = 'ldap.uniandes.edu.co';
$baseBusqueda   = 'ou=people,dc=uniandes,dc=edu,dc=co';*/

/*$cadenaBusqueda = 'cn';
$servidorLDAP   = '172.17.142.11';
$baseBusqueda   = 'OU=PEOPLE,DC=fundacionuniandes,DC=edu,DC=co';*/

$cadenaBusqueda = 'cn';
$servidorLDAP   = 'adua.uniandes.edu.co';
$baseBusqueda   = 'OU=PEOPLE,DC=ad,DC=uniandes,DC=edu,DC=co';