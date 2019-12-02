<?php

require_once("Co_PorcentajePagos.php");
require_once("Validacion.class.php");
 
/*
 * Co_PorcentajePagos
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
 
class Co_PorcentajePagos extends DOCo_PorcentajePagos {

	var $validacion;
	var $validacionCampos;
	
    /**
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_PorcentajePagos() {
		$this->validacionCampos = array (
		);
		$this->validacion =& new Validacion($this);
    } 

    /**
     * Co_PorcentajePagos::insertar()
     * 
     * @return 
     */
    function insertar() {
        $this->insert();

		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['insertarPorcentajePagos'] = 'Se produjo un error insertando el Porcentaje Pagos';
			return FALSE;
		} else {
			return TRUE;
		}
	} // end insertar  
	
    /**
     * Co_PorcentajePagos::actualizar()
     * 
     * @return 
     */
    function actualizar() {
        $clon = Co_PorcentajePagos::staticGet($this->porcentajepagos);
		
		if ($clon) {
			$rows = $this->update($clon);
        }
		
		//Manejamos errores.
		if ($rows == 0 
			||
			( $this->_lastError && $this->_lastError->getCode() == DB_DATAOBJECT_ERROR_NODATA)
			) {
		    	$this->validacion->acumuladoErrores['actualizarPorcentajePagos'] = 'No se encontro el Porcentaje pagos a Actualizar';
				return FALSE;
		} elseif ($this->_lastError) {
		    $this->validacion->acumuladoErrores['actualizarPorcentajePagos'] = 'No se pudo actualizar el Porcentaje pagos';
			return FALSE;
		} else {
			return TRUE;
		}

    } // end actualizar

    /**
     * Co_PorcentajePagos::eliminar()
     * 
     * @param  $id
     * @return 
     */
    function eliminar($id) {
        $this->porcentajepagos = $id;
        $rows = $this->delete();
		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['eliminarPorcentajePagos'] = 'No se pudo eliminar el Porcentaje pagos';
			return FALSE;
		} else {
			if ($rows === FALSE || $rows == 0) {
		    	$this->validacion->acumuladoErrores['eliminarPorcentajePagos'] = 'No se encontro el Porcentaje Pagos a Eliminar';
				return FALSE;
			} else {
				return TRUE;
			}
		}
    } // end eliminar

    /**
     * Co_PorcentajePagos::buscar()
     * 
     * @param  $campoValorOperador 
     * @return 
     */
    function buscar($id) {
        $rows = $this->get($id);
		
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['buscarPorcentajePagos'] = 'No se pudo Buscar el Porcentaje Pagos';
			return FALSE;
		}
		
		if ($rows == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
    } // end buscar

    /**
     * Co_PorcentajePagos::listar()
     * 
     * @param 
     * @return 
     */
    function listar($registroComienzoPagina, $registroFinalPagina, $condiciones = '') {
        if (!empty($condiciones)) {
            $this->whereAdd($condiciones);
        }
		$this->orderBy('porcentajepagos');
		if ($registroComienzoPagina > 0 and $registroFinalPagina > 0) {
	        $this->limit($registroComienzoPagina, $registroFinalPagina);
		}
        $this->find();
    } // end listar

    /**
     * Co_PorcentajePagos::asignar()
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
		    $this->validacion->acumuladoErrores['asignarPorcentajePagos'] = 'No se pudo Asignar los valores';
			return $returnValue;
		}
    } // end asignar    
	    	  
    /**
     * Co_PorcentajePagos::validar()
     * 
     * @return 
     */
    function validar() {
        $returnValue = true;		
        $returnValue = $this->validacion->multiple($this->validacionCampos);
        return $returnValue;
    } // end validar  		 

    /**
     * Co_PorcentajePagos::contarPorcentajePagos()
     * 
     * @param 
     * @return 
     **/
    function contarPorcentajePagos() {
		$sentencia = "select count(porcentajepagos) as cantidad
			from co_porcentajepagos
			order by 1";
        $this->query($sentencia);
    } // end contarPorcentajePagos

    /**
     * Co_PorcentajePagos::insertarPorcentajePagos()
     * 
     * @param 
     * @return 
     **/
    function insertarPorcentajePagos($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->insertar();
    		}
    	}
    	return $returnValue;
    }
    
    /**
     * Co_PorcentajePagos::actualizarPorcentajePagos()
     * 
     * @param 
     * @return 
     **/
    function actualizarPorcentajePagos($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->actualizar();
    		}
    	}
    	return $returnValue;
    }

    /**
     * Co_PorcentajePagos::eliminarPorcentajePagos()
     * 
     * @param 
     * @return 
     **/
    function eliminarPorcentajePagos($arregloCampos) {
    	$returnValue = FALSE;
    	if (isset($arregloCampos['porcentajepagos']) && !empty($arregloCampos['porcentajepagos'])) {
    			$returnValue = $this->eliminar($arregloCampos['porcentajepagos']);
    	}
    	return $returnValue;
    }
    
    function buscarPorPlanPagos($planPagos) {
		$this->planpagos = $planPagos;
		$this->orderBy('planpagos');
		$this->find();
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['buscarPorcentajePagosPorPlanPagos'] = 'No se pudo Buscar el Porcentaje Pagos por plan pagos';
			return FALSE;
		}
		return TRUE;
	}
    
} // end Co_PorcentajePagos
?>