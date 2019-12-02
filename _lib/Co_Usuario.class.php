<?php

require_once("Co_Usuario.php");
require_once("Validacion.class.php");
 
/*
 * Co_Usuario
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_Usuario extends DOCo_Usuario {

	var $validacion;
	var $validacionCampos;
	
    /**
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_Usuario() {
		$this->validacionCampos = array (
		);
		$this->validacion =& new Validacion($this);
    } 

    /**
     * Co_Usuario::insertar()
     * 
     * @return 
     */
    function insertar() {
        $this->insert();

		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['insertarUsuario'] = 'Se produjo un error insertando el Usuario';
			return FALSE;
		} else {
			return TRUE;
		}
	} // end insertar  
	
    /**
     * Co_Usuario::actualizar()
     * 
     * @return 
     */
    function actualizar() {
        $clon = Co_Usuario::staticGet($this->usuario);
		
		if ($clon) {
			$rows = $this->update($clon);
        }
		
		//Manejamos errores.
		if ($rows == 0 
			||
			( $this->_lastError && $this->_lastError->getCode() == DB_DATAOBJECT_ERROR_NODATA)
			) {
		    	$this->validacion->acumuladoErrores['actualizarUsuario'] = 'No se encontro el Usuario a Actualizar';
				return FALSE;
		} elseif ($this->_lastError) {
		    $this->validacion->acumuladoErrores['actualizarUsuario'] = 'No se pudo actualizar el Usuario';
			return FALSE;
		} else {
			return TRUE;
		}

    } // end actualizar

    /**
     * Co_Usuario::eliminar()
     * 
     * @param  $id
     * @return 
     */
    function eliminar($id) {
        $this->usuario = $id;
        $rows = $this->delete();
		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['eliminarUsuario'] = 'No se pudo eliminar el Usuario';
			return FALSE;
		} else {
			if ($rows === FALSE || $rows == 0) {
		    	$this->validacion->acumuladoErrores['eliminarUsuario'] = 'No se encontro el Usuario a Eliminar';
				return FALSE;
			} else {
				return TRUE;
			}
		}
    } // end eliminar

    /**
     * Co_Usuario::buscar()
     * 
     * @param  $campoValorOperador 
     * @return 
     */
    function buscar($id) {
        $rows = $this->get($id);
		
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['buscarUsuario'] = 'No se pudo Buscar el Usuario';
			return FALSE;
		}
		
		if ($rows == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
    } // end buscar

    /**
     * Co_Usuario::listar()
     * 
     * @param 
     * @return 
     */
    function listar($registroComienzoPagina, $registroFinalPagina, $condiciones = '') {
        if (!empty($condiciones)) {
            $this->whereAdd($condiciones);
        }
		$this->orderBy('usuario');
		if ($registroComienzoPagina > 0 and $registroFinalPagina > 0) {
	        $this->limit($registroComienzoPagina, $registroFinalPagina);
		}
        $this->find();
    } // end listar

    /**
     * Co_Usuario::asignar()
     * 
     * @param  $atributos 
     * @return 
     */
    function asignar($arregloCampos) {
		$llaves = $this->keys();
		foreach($llaves as $unLlave){
			$this->$unLlave = isset($arregloCampos[$unLlave])?$arregloCampos[$unLlave]:null;
		}
		$returnValue = $this->setFrom($arregloCampos);
		if ($returnValue) {
			return $returnValue;
		} else {
		    $this->validacion->acumuladoErrores['asignarUsuario'] = 'No se pudo Asignar los valores';
			return $returnValue;
		}
    } // end asignar    
	    	  
    /**
     * Co_Usuario::validar()
     * 
     * @return 
     */
    function validar() {
        $returnValue = true;		
        $returnValue = $this->validacion->multiple($this->validacionCampos);
        return $returnValue;
    } // end validar  		 

    /**
     * Co_Usuario::contarUsuario()
     * 
     * @param 
     * @return 
     **/
    function contarUsuario() {
		$sentencia = "select count(usuario) as cantidad
			from co_usuario
			order by 1";
        $this->query($sentencia);
    } // end contarUsuario

    /**
     * Co_Usuario::insertarUsuario()
     * 
     * @param 
     * @return 
     **/
    function insertarUsuario($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->insertar();
    		}
    	}
    	return $returnValue;
    }
    
    /**
     * Co_Usuario::actualizarUsuario()
     * 
     * @param 
     * @return 
     **/
    function actualizarUsuario($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->actualizar();
    		}
    	}
    	return $returnValue;
    }

    /**
     * Co_Usuario::eliminarUsuario()
     * 
     * @param 
     * @return 
     **/
    function eliminarUsuario($arregloCampos) {
    	$returnValue = FALSE;
    	if (isset($arregloCampos['usuario']) && !empty($arregloCampos['usuario'])) {
    			$returnValue = $this->eliminar($arregloCampos['usuario']);
    	}
    	return $returnValue;
    }
  
    /**
     * Co_Usuario::obtenerPermisos()
     *
     * @param
     * @return
     **/
    function obtenerPermisos() {
    	$usuarioPermiso = array(
    		'S' => array(),
    		'N' => array()
    	);
    	$sentencia = "
			SELECT DISTINCT
			  M.MODULO,
			  M.NOMBRE NOMBREMODULO,
			  M.ORDEN ORDENMODULO,
			  P.PERMISO,
			  P.NOMBRE NOMBREPERMISO,
			  P.CLASE,
			  P.CONTROLADOR,
			  P.METODO,
			  P.ORDEN,
			  P.VISIBLE
			FROM CO_USUARIO U, CO_PERMISO P, CO_PERMISOROL PR, CO_MODULO M
			WHERE M.MODULO = P.MODULO
			  AND U.ROL = PR.ROL
			  AND P.PERMISO = PR.PERMISO
			  AND U.USUARIO = " . $this->usuario . "
			ORDER BY M.ORDEN ASC, M.NOMBRE ASC, P.ORDEN ASC, P.NOMBRE ASC
		";
    	$unPermiso = new DB_DataObject();
    	$unPermiso->query($sentencia);
    	while ($unPermiso->fetch()) {
    		$permiso = array(
    			'modulo' => $unPermiso->modulo,
    			'nombremodulo' => $unPermiso->nombremodulo,
				'ordenmodulo' => $unPermiso->ordenmodulo,
				'permiso' => $unPermiso->permiso,
				'nombrepermiso' => $unPermiso->nombrepermiso,
				'clase' => $unPermiso->clase,
				'controlador' => $unPermiso->controlador,
				'metodo' => $unPermiso->metodo,
				'orden' => $unPermiso->orden,
				'visible' => $unPermiso->visible
    		);
   			$usuarioPermiso[$unPermiso->visible][] = $permiso;
    	}
    	return $usuarioPermiso;
    } // end obtenerPermisos
    
} // end Co_Usuario
?>