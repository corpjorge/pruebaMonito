<?php
/**
 * Clase Sesion con autenticacion basada en base de datos o LDAP
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co> 
 */

require_once "Auth/Auth.php";

Class Sesion extends Auth {
    // variables publicas
    var $id;
    var $nombre;

    /**
     * Sesion::Sesion()
     * 
     * Constructora de la clase
     * 
     * @param string $nombreSesion Nombre de la sesion
     * @param string $storageDriver Driver de acceso a la base de datos
     * @param string $options Opciones de conexion a la base de datos
     * @param string $loginFunction Funcion de validacion
     * @param boolean $showLogin Muestra la forma de autenticacion?
     * @return 
     */
    function Sesion($nombreSesion = 'PHPSESSID', $storageDriver = 'DB', $options, $loginFunction, $showLogin = true) {
    	$this->setIdle(1800);
        $this->Auth($storageDriver, $options, $loginFunction, $showLogin);
        $this->nombre = $nombreSesion;
        $this->setSessionname($nombreSesion);
        $this->start();
        $this->id = session_id();
        $this->nombre = session_name();
    } 

    /**
     * Sesion::registrarVariable()
     * 
     * registra la variable que recibe por parametro en el arreglo de la sesion
     * 
     * @param  $nombreVariable nombre de la variable
     * @param  $valor valor a registrar
     * @return 
     */
    function registrarVariable($nombreVariable, $valor) {
        $_SESSION[$nombreVariable] = $valor;
        return true;
    } 

    /**
     * Sesion::obtenerVariable()
     * 
     * recupera el valor asignado a la variable en la sesion
     * 
     * @param  $nombreVariable nombre de la variable
     * @return el valor que tenga la variable o falso si no estaba registrada
     */
    function obtenerVariable($nombreVariable) {
        if (isset($_SESSION[$nombreVariable])) {
            return $_SESSION[$nombreVariable];
        } else {
            return false;
        } 
    } 

    /**
     * Sesion::eliminarVariable()
     * 
     * Elimina la variable de la sesion
     * 
     * @param  $nombreVariable nombre de la variable
     * @return verdadero 
     */
    function eliminarVariable($nombreVariable) {
        unset($_SESSION[$nombreVariable]);
        return true;
    } 

    /**
     * Sesion::registrarVariableArreglo()
     * 
     * @param  $arreglo 
     * @param  $nombreVariable 
     * @param  $valor 
     * @return 
     */
    function registrarVariableArreglo($arreglo, $nombreVariable, $valor) {
        $_SESSION[$arreglo][$nombreVariable] = $valor;
        return true;
    } 

    /**
     * Sesion::obtenerVariableArreglo()
     * 
     * @param  $arreglo 
     * @param  $nombreVariable 
     * @return 
     */
    function obtenerVariableArreglo($arreglo, $nombreVariable) {
        if (isset($_SESSION[$arreglo][$nombreVariable])) {
            return $_SESSION[$arreglo][$nombreVariable];
        } else {
            return false;
        } 
    } 

    /**
     * Sesion::eliminarVariableArreglo()
     * 
     * @param  $arreglo 
     * @param  $nombreVariable 
     * @return 
     */
    function eliminarVariableArreglo($arreglo, $nombreVariable) {
        unset($_SESSION[$arreglo][$nombreVariable]);
        return true;
    } 

    /**
     * Sesion::obtenerArreglo()
     * 
     * @param  $arreglo 
     * @return 
     */
    function obtenerArreglo($arreglo) {
        return $_SESSION[$arreglo];
    } 

    /**
     * Sesion::adicionarID()
     * 
     * @return 
     */
    function adicionarIdUrl() {
        return $this->nombre . '=' . $this->id;
    } 

    /**
     * Sesion::imprimirHidden()
     * 
     * @return 
     */
    function imprimirHidden() {
        echo "<INPUT TYPE=\"hidden\" NAME=\"" . $this->nombre . "\" VALUE=\"" . $this->id . "\">\n";
    } 
	
    /**
     * Sesion::destruirSesion()
     * 
	 * Destruye estaticamente la sesion para el caso que se necesite salir sin tener un objeto
	 * Auth.
	 * 
     * @return 
     */	
	function destruirSesion($nombreSesion = 'PHPSESSID', $redirectURL = './index.php') {
		session_name($nombreSesion) ;
		session_start();
        session_unset();
        session_destroy();
		header("Cache-Control: no-cache, must-revalidate");
        header("Location:$redirectURL");
		exit(0);
	}

    /**
     * Sesion::terminarSesion()
     * 
     * @return 
     */
    function terminarSesion() {
        $this->logout();
        session_unset();
        session_destroy();
    } 

    /**
     * Sesion::reiniciarSesion()
     * Esta funcion reinicia la session realizando la redireccion a la pagina de
     * inicio del sistema, si mostrarMensaje es verdadero imprime un mensaje
     * informativo en el que indica que la session a expirado.
     * Si mostrarMensaje es un texto, se muestra el mensaje enviado por parametro
     * @return 
     **/
    function reiniciarSesion($redirectURL = './index.php', $mostrarMensaje = FALSE) {
        $this->terminarSesion();
        if ($mostrarMensaje === TRUE) {
        	$mensaje = 'El tiempo de sesion expiro' . "\n" .'Por favor ingrese de nuevo al sistema.';
        } else {
        	$mensaje = $mostrarMensaje;
        }
        
        if ($mostrarMensaje) {
            echo  ('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'
                 .'<HTML>'
                 .'<HEAD>'
                 .'<TITLE> Expiración de Sesión </TITLE>'
                 .'<META HTTP-EQUIV="EXPIRES" CONTENT="0">'
                 .'<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">'
                 .'<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="PRIVATE">'
                 ."\t<SCRIPT  LANGUAGE=\"JavaScript\"> alert('" . strtr($mensaje, array("\n" => "\\n")) . "'); top.location.href = '" . $redirectURL . "';</SCRIPT>"
                 .'</HEAD><BODY></BODY></HTML>'
                );
        } else {        
            header("Cache-Control: no-cache, must-revalidate");
            header("Location:$redirectURL");
        }
        exit(0);
    }
}
?>