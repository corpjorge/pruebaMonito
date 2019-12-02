<?php

require_once("Co_PlanPagos.php");
require_once("Validacion.class.php");
 
/*
 * Co_PlanPagos
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
 
class Co_PlanPagos extends DOCo_PlanPagos {

	var $validacion;
	var $validacionCampos;
	
    /**
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_PlanPagos() {
		$this->validacionCampos = array (
		);
		$this->validacion =& new Validacion($this);
    } 

    /**
     * Co_PlanPagos::insertar()
     * 
     * @return 
     */
    function insertar() {
        $this->insert();

		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['insertarPlanPagos'] = 'Se produjo un error insertando el Plan Pagos';
			return FALSE;
		} else {
			return TRUE;
		}
	} // end insertar  
	
    /**
     * Co_PlanPagos::actualizar()
     * 
     * @return 
     */
    function actualizar() {
        $clon = Co_PlanPagos::staticGet($this->planpagos);
		
		if ($clon) {
			$rows = $this->update($clon);
        }
		
		//Manejamos errores.
		if ($rows == 0 
			||
			( $this->_lastError && $this->_lastError->getCode() == DB_DATAOBJECT_ERROR_NODATA)
			) {
		    	$this->validacion->acumuladoErrores['actualizarPlanPagos'] = 'No se encontro el plan pagos a Actualizar';
				return FALSE;
		} elseif ($this->_lastError) {
		    $this->validacion->acumuladoErrores['actualizarPlanPagos'] = 'No se pudo actualizar el plan pagos';
			return FALSE;
		} else {
			return TRUE;
		}

    } // end actualizar

    /**
     * Co_PlanPagos::eliminar()
     * 
     * @param  $id
     * @return 
     */
    function eliminar($id) {
        $this->planpagos = $id;
        $rows = $this->delete();
		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['eliminarPlanPagos'] = 'No se pudo eliminar el plan pagos';
			return FALSE;
		} else {
			if ($rows === FALSE || $rows == 0) {
		    	$this->validacion->acumuladoErrores['eliminarPlanPagos'] = 'No se encontro el Plan Pagos a Eliminar';
				return FALSE;
			} else {
				return TRUE;
			}
		}
    } // end eliminar

    /**
     * Co_PlanPagos::buscar()
     * 
     * @param  $campoValorOperador 
     * @return 
     */
    function buscar($id) {
        $rows = $this->get($id);
		
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['buscarPlanPagos'] = 'No se pudo Buscar el Plan Pagos';
			return FALSE;
		}
		
		if ($rows == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
    } // end buscar

    /**
     * Co_PlanPagos::listar()
     * 
     * @param 
     * @return 
     */
    function listar($registroComienzoPagina, $registroFinalPagina, $condiciones = '') {
        if (!empty($condiciones)) {
            $this->whereAdd($condiciones);
        }
		$this->orderBy('planpagos');
		if ($registroComienzoPagina > 0 and $registroFinalPagina > 0) {
	        $this->limit($registroComienzoPagina, $registroFinalPagina);
		}
        $this->find();
    } // end listar

    /**
     * Co_PlanPagos::asignar()
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
		    $this->validacion->acumuladoErrores['asignarPlanPagos'] = 'No se pudo Asignar los valores';
			return $returnValue;
		}
    } // end asignar    
	    	  
    /**
     * Co_PlanPagos::validar()
     * 
     * @return 
     */
    function validar() {
        $returnValue = true;		
        $returnValue = $this->validacion->multiple($this->validacionCampos);
        return $returnValue;
    } // end validar  		 

    /**
     * Co_PlanPagos::contarPlanPagos()
     * 
     * @param 
     * @return 
     **/
    function contarPlanPagos() {
		$sentencia = "select count(planpagos) as cantidad
			from co_planpagos
			order by 1";
        $this->query($sentencia);
    } // end contarPlanPagos

    /**
     * Co_PlanPagos::insertarPlanPagos()
     * 
     * @param 
     * @return 
     **/
    function insertarPlanPagos($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->insertar();
    		}
    	}
    	return $returnValue;
    }
    
    /**
     * Co_PlanPagos::actualizarPlanPagos()
     * 
     * @param 
     * @return 
     **/
    function actualizarPlanPagos($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->actualizar();
    		}
    	}
    	return $returnValue;
    }

    /**
     * Co_PlanPagos::eliminarPlanPagos()
     * 
     * @param 
     * @return 
     **/
    function eliminarPlanPagos($arregloCampos) {
    	$returnValue = FALSE;
    	if (isset($arregloCampos['planpagos']) && !empty($arregloCampos['planpagos'])) {
    			$returnValue = $this->eliminar($arregloCampos['planpagos']);
    	}
    	return $returnValue;
    }
    
    function buscarPorPeriodoAcademico($periodoAcademico) {
		$this->periodoacademico = $periodoAcademico;
		$this->orderBy('periodoacademico');
		$this->find();
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['buscarPlanPagosPorPeriodoAcademico'] = 'No se pudo Buscar el Plan Pagos por periodo academico';
			return FALSE;
		}
		return TRUE;
	}
    
} // end Co_Distribucion
?>