<?php

require_once("Co_Distribucion.php");
require_once("Validacion.class.php");
 
/*
 * Co_Distribucion
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
 
class Co_Distribucion extends DOCo_Distribucion {

	var $validacion;
	var $validacionCampos;
	
    /**
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_Distribucion() {
		$this->validacionCampos = array (
		);
		$this->validacion =& new Validacion($this);
    } 

    /**
     * Co_Distribucion::insertar()
     * 
     * @return 
     */
    function insertar() {
        $this->insert();

		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['insertarDistribucion'] = 'Se produjo un error insertando la distrbucion';
			return FALSE;
		} else {
			return TRUE;
		}
	} // end insertar  
	
    /**
     * Co_Distribucion::actualizar()
     * 
     * @return 
     */
    function actualizar() {
        $clon = Co_Distribucion::staticGet($this->distribucion);
		
		if ($clon) {
			$rows = $this->update($clon);
        }
		
		//Manejamos errores.
		if ($rows == 0 
			||
			( $this->_lastError && $this->_lastError->getCode() == DB_DATAOBJECT_ERROR_NODATA)
			) {
		    	$this->validacion->acumuladoErrores['actualizarDistribucion'] = 'No se encontro la distribucion a Actualizar';
				return FALSE;
		} elseif ($this->_lastError) {
		    $this->validacion->acumuladoErrores['actualizarDistribucion'] = 'No se pudo actualizar la distribucion';
			return FALSE;
		} else {
			return TRUE;
		}

    } // end actualizar

    /**
     * Co_Distribucion::eliminar()
     * 
     * @param  $id
     * @return 
     */
    function eliminar($id) {
        $this->distribucion = $id;
        $rows = $this->delete();
		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['eliminarDistribucion'] = 'No se pudo eliminar la Distribucion';
			return FALSE;
		} else {
			if ($rows === FALSE || $rows == 0) {
		    	$this->validacion->acumuladoErrores['eliminarDistribucion'] = 'No se encontro la Distribucion a Eliminar';
				return FALSE;
			} else {
				return TRUE;
			}
		}
    } // end eliminar

    /**
     * Co_Distribucion::buscar()
     * 
     * @param  $campoValorOperador 
     * @return 
     */
    function buscar($id) {
        $rows = $this->get($id);
		
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['buscarDistribucion'] = 'No se pudo Buscar la Distribucion';
			return FALSE;
		}
		
		if ($rows == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
    } // end buscar

    /**
     * Co_Distribucion::listar()
     * 
     * @param 
     * @return 
     */
    function listar($registroComienzoPagina, $registroFinalPagina, $condiciones = '') {
        if (!empty($condiciones)) {
            $this->whereAdd($condiciones);
        }
		$this->orderBy('distribucion');
		if ($registroComienzoPagina > 0 and $registroFinalPagina > 0) {
	        $this->limit($registroComienzoPagina, $registroFinalPagina);
		}
        $this->find();
    } // end listar

    /**
     * Co_Distribucion::asignar()
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
		    $this->validacion->acumuladoErrores['asignarDistribucion'] = 'No se pudo Asignar los valores';
			return $returnValue;
		}
    } // end asignar    
	    	  
    /**
     * Co_Distribucion::validar()
     * 
     * @return 
     */
    function validar() {
        $returnValue = true;		
        $returnValue = $this->validacion->multiple($this->validacionCampos);
        return $returnValue;
    } // end validar  		 

    /**
     * Co_Distribucion::contarDistribucion()
     * 
     * @param 
     * @return 
     **/
    function contarDistribucion() {
		$sentencia = "select count(distribucion) as cantidad
			from co_distribucion
			order by 1";
        $this->query($sentencia);
    } // end contarDistribucion

    /**
     * Co_Distribucion::insertarDistribucion()
     * 
     * @param 
     * @return 
     **/
    function insertarDistribucion($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->insertar();
    		}
    	}
    	return $returnValue;
    }
    
    /**
     * Co_Distribucion::actualizarDistribucion()
     * 
     * @param 
     * @return 
     **/
    function actualizarDistribucion($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->actualizar();
    		}
    	}
    	return $returnValue;
    }

    /**
     * Co_Distribucion::eliminarDistribucion()
     * 
     * @param 
     * @return 
     **/
    function eliminarDistribucion($arregloCampos) {
    	$returnValue = FALSE;
    	if (isset($arregloCampos['distribucion']) && !empty($arregloCampos['distribucion'])) {
    			$returnValue = $this->eliminar($arregloCampos['distribucion']);
    	}
    	return $returnValue;
    }
  
    /**
     * Co_Distribucion::eliminarDistribucionPorConvenio()
     * 
     * @param 
     * @return 
     **/
    function eliminarDistribucionPorConvenio($idConvenio) {
    	$returnValue = FALSE;
    	if (!empty($idConvenio)) {
   	        $this->convenio = $idConvenio;
	        $rows = $this->delete();
			//Manejamos errores.
			if ($this->_lastError) {
			    $this->validacion->acumuladoErrores['eliminarDistribucion'] = 'No se pudo eliminar la Distribucion';
				return FALSE;
			} else {
				if ($rows === FALSE || $rows == 0) {
			    	$this->validacion->acumuladoErrores['eliminarDistribucion'] = 'No se encontro la Distribucion a Eliminar';
					return FALSE;
				} else {
					return TRUE;
				}
			}
    	}
    	return $returnValue;
    }
  
} // end Co_Distribucion
?>