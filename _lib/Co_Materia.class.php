<?php

require_once("Co_Materia.php");
require_once("Validacion.class.php");
 
/*
 * Co_Materia
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
 
class Co_Materia extends DOCo_Materia {

	var $validacion;
	var $validacionCampos;
	
    /**
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_Materia() {
		$this->validacionCampos = array (
		);
		$this->validacion =& new Validacion($this);
    } 

    /**
     * Co_Materia::insertar()
     * 
     * @return 
     */
    function insertar() {
        $this->insert();

		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['insertarMateria'] = 'Se produjo un error insertando la materia';
			return FALSE;
		} else {
			return TRUE;
		}
	} // end insertar  
	
    /**
     * Co_Materia::actualizar()
     * 
     * @return 
     */
    function actualizar() {
        $clon = Co_Materia::staticGet($this->materia);
		
		if ($clon) {
			$rows = $this->update($clon);
        }
		
		//Manejamos errores.
		if ($rows == 0 
			||
			( $this->_lastError && $this->_lastError->getCode() == DB_DATAOBJECT_ERROR_NODATA)
			) {
		    	$this->validacion->acumuladoErrores['actualizarMateria'] = 'No se encontro la materia a Actualizar';
				return FALSE;
		} elseif ($this->_lastError) {
		    $this->validacion->acumuladoErrores['actualizarMateria'] = 'No se pudo actualizar la materia';
			return FALSE;
		} else {
			return TRUE;
		}

    } // end actualizar

    /**
     * Co_Materia::eliminar()
     * 
     * @param  $id
     * @return 
     */
    function eliminar($id) {
        $this->materia = $id;
        $rows = $this->delete();
		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['eliminarMateria'] = 'No se pudo eliminar la materia';
			return FALSE;
		} else {
			if ($rows === FALSE || $rows == 0) {
		    	$this->validacion->acumuladoErrores['eliminarMateria'] = 'No se encontro la materia a Eliminar';
				return FALSE;
			} else {
				return TRUE;
			}
		}
    } // end eliminar

    /**
     * Co_Materia::buscar()
     * 
     * @param  $campoValorOperador 
     * @return 
     */
    function buscar($id) {
        $rows = $this->get($id);
		
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['buscarMateria'] = 'No se pudo Buscar la materia';
			return FALSE;
		}
		
		if ($rows == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
    } // end buscar

    /**
     * Co_Materia::listar()
     * 
     * @param 
     * @return 
     */
    function listar($registroComienzoPagina, $registroFinalPagina, $condiciones = '') {
        if (!empty($condiciones)) {
            $this->whereAdd($condiciones);
        }
		$this->orderBy('materia');
		if ($registroComienzoPagina > 0 and $registroFinalPagina > 0) {
	        $this->limit($registroComienzoPagina, $registroFinalPagina);
		}
        $this->find();
    } // end listar

    /**
     * Co_Materia::asignar()
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
		    $this->validacion->acumuladoErrores['asignarMateria'] = 'No se pudo Asignar los valores';
			return $returnValue;
		}
    } // end asignar    
	    	  
    /**
     * Co_Materia::validar()
     * 
     * @return 
     */
    function validar() {
        $returnValue = true;		
        $returnValue = $this->validacion->multiple($this->validacionCampos);
        return $returnValue;
    } // end validar  		 

    /**
     * Co_Materia::contarMaterias()
     * 
     * @param 
     * @return 
     **/
    function contarMaterias() {
		$sentencia = "select count(materias) as cantidad
			from co_materia
			order by 1";
        $this->query($sentencia);
    } // end contarMaterias

    /**
     * Co_Materia::insertarMateria()
     * 
     * @param 
     * @return 
     **/
    function insertarMateria($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->insertar();
    		}
    	}
    	return $returnValue;
    }
    
    /**
     * Co_Materia::actualizarMateria()
     * 
     * @param 
     * @return 
     **/
    function actualizarMateria($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->actualizar();
    		}
    	}
    	return $returnValue;
    }

    /**
     * Co_Materia::eliminarMateria()
     * 
     * @param 
     * @return 
     **/
    function eliminarMateria($arregloCampos) {
    	$returnValue = FALSE;
    	if (isset($arregloCampos['materia']) && !empty($arregloCampos['materia'])) {
    			$returnValue = $this->eliminar($arregloCampos['materia']);
    	}
    	return $returnValue;
    }
  
    /**
     * Co_Materia::eliminarMateriaPorConvenio()
     *
     * @param
     * @return
     **/
    function eliminarMateriaPorConvenio($idConvenio) {
    	$returnValue = FALSE;
    	if (!empty($idConvenio)) {
    		$this->convenio = $idConvenio;
    		$rows = $this->delete();
    		//Manejamos errores.
    		if ($this->_lastError) {
    			$this->validacion->acumuladoErrores['eliminarMateria'] = 'No se pudo eliminar las materias';
    			return FALSE;
    		} else {
   				return TRUE;
    		}
    	}
    	return $returnValue;
    }
    
} // end Co_Materia
?>