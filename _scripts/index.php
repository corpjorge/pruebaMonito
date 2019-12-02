<?php
/**
* Fachada del proyecto
* 
* La funcion principal de esta script es redireccionar al usuario 
* de acuerdo a la accion a ejecutar
* 
* @author Edwin Lasso <elasso@uniandes.edu.co>
*/

	require_once(LIB_DIR . 'Co_Usuario.class.php');
	
	//Obtiene los datos del usuario y guarda valores en la sesion si no los tiene.
	$nombreUsuario = $unSesion->obtenerVariable('nombreUsuario');

	if ($nombreUsuario === FALSE) {
		//El usuario se autentico en esta pagina
		if (isset($_POST['username'])) {

			$nombreUsuario = $_POST['username'];
			$unSesion->registrarVariable('nombreUsuario', $nombreUsuario);
			$unUsuario = new Co_Usuario();
			$existe = $unUsuario->get('nombreusuario', $nombreUsuario);


			if ($existe == 0) {
				$unSesion->reiniciarSesion(URL_SITIO . 'index.php?username=' . $nombreUsuario . '&status=-7');
			}
			$rolAdministrador = cargarArregloBD('Co_Parametro', 'nombre', 'valor', 'nombre', " NOMBRE = 'SISTEMA_ROL_ADMINISTRADOR' ");
			$usuario = $unUsuario->toArray();
			$usuario['tiporol'] = 'U';
			$arrayRolAdministrador = explode(',', $rolAdministrador['SISTEMA_ROL_ADMINISTRADOR']);
			if (in_array($unUsuario->rol, $arrayRolAdministrador)) {
				$usuario['tiporol'] = 'A';
			}
/*			
			if ($unUsuario->rol == $rolAdministrador['SISTEMA_ROL_ADMINISTRADOR']) {
				$usuario['dependencia'] = '';
			}
*/
			$unSesion->registrarVariable('usuario', $usuario);
			$usuarioPermiso = $unUsuario->obtenerPermisos();
			if (count($usuarioPermiso['S']) == 0) {
				$unSesion->reiniciarSesion(URL_SITIO . 'index.php?username=' . $nombreUsuario . '&status=-8');
			}
			$unUsuarioAct = new Co_Usuario();
			$sentencia = 'UPDATE CO_USUARIO SET ULTIMOINGRESO = SYSDATE WHERE USUARIO = ' . $unUsuario->usuario;
			$unUsuarioAct->query($sentencia);
	
			$unSesion->registrarVariable('usuarioPermiso', $usuarioPermiso);
		} else {
			//No esta en la sesion no viene por post ... terminemos el auth
			$unSesion->terminarSesion();
		}
	}
	
	$request = (isset($_POST['request']) && !empty($_POST['request'])) ? $_POST['request'] : NULL;
	$accion = empty($_POST['accion']) ? NULL : $_POST['accion'];
	
	$clase = isset($_POST['clase'])?$_POST['clase']:'';
	$controlador = isset($_POST['controlador'])?$_POST['controlador']:'';
	$metodo = isset($_POST['metodo'])?$_POST['metodo']:'';
	
	$inicio = FALSE;
	if (empty($clase) && empty($controlador) && empty($metodo)) {
		$inicio = TRUE;
	}
	
	$usuarioPermiso = $unSesion->obtenerVariable('usuarioPermiso');
	$permitido = FALSE;
	foreach ($usuarioPermiso as $vPermisoVisible) {
		foreach ($vPermisoVisible as $vPermiso) {
			if ($vPermiso['clase'] == $clase && $vPermiso['controlador'] == $controlador && $vPermiso['metodo'] == $metodo) {
				$permitido = TRUE;
				continue 2;
			}
		}
	}
	$mensaje = '';
	if (!$permitido && empty($request) && !$inicio) {
		$mensaje = 'La acción no se encuentra permitida para el usuario ' . $nombreUsuario;
		$_POST['clase'] = '';
	}
	
	//Logout es la primera opcion a revisar
   	if ($accion == 'Salir') {
        $unSesion->reiniciarSesion(URL_SITIO . 'index.php', FALSE);
    } else {
    	if (!empty($_POST) AND !empty($_POST['clase'])) {
    		$clase = ucfirst($_POST['clase']);
    		$tipoControlador = ucfirst($_POST['controlador']);
    		$metodo = ucfirst($_POST['metodo']);
    		require_once(LIB_DIR . 'Co_' . $clase . 'Controller.class.php');
			$controlador = 'Co_' . $clase . $tipoControlador . 'Controller';
    		$unControlador = new $controlador();
    		if (empty($request)) {
	    		$unControlador->$metodo($_POST);
	    		$view = $unControlador->getView();
	    		$view->tpl->parse();
    			$view->tpl->show();
    		} else {
    			echo $unControlador->$metodo($_POST);
    		}
		} else {
			mensajeInicio($mensaje);
    	}
	}
?>
