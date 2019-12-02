<?php

require_once("Co_PeriodoAcademico.php");
require_once("Co_Convenio.class.php");
require_once("Co_PlanPagos.class.php");
require_once("Co_PorcentajePagos.class.php");
require_once("Validacion.class.php");
 
/*
 * Co_PeriodoAcademico
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
 
class Co_PeriodoAcademico extends DOCo_PeriodoAcademico {

	var $validacion;
	var $validacionCampos;
	var $planpagos;
	var $porcentajepagos;
	
    /**
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_PeriodoAcademico() {
		$this->validacionCampos = array (
			'fechainicio' => array (
				'fnc' =>'esFechaValida',
				'max' => 10,
				'req' => true,
            	'msg' => 'La fecha de inicio del periodo no es un dato válido.'
			),
			'fechafin' => array (
				'fnc' =>'esFechaValida',
				'max' => 10,
				'req' => true,
            	'msg' => 'La fecha final del periodo no es un dato válido.'
			),
			'fechainicioreceso' => array (
				'fnc' =>'esFechaValida',
				'max' => 10,
				'req' => false,
            	'msg' => 'La fecha de inicio de la semana de receso no es un dato válido.'
			),
			'fechafinreceso' => array (
				'fnc' =>'esFechaValida',
				'max' => 10,
				'req' => false,
            	'msg' => 'La fecha fin de la semana de receso no es un dato válido.'
			),
			'minhoras'=> array (
				'fnc' => 'esEntero',
				'max' => 4,
				'req' => true,
            	'msg' => 'El número de horas mínimo no es un dato válido.'
			),
			'maxhoras'=> array (
				'fnc' => 'esEntero',
				'max' => 4,
				'req' => true,
            	'msg' => 'El número de horas máximo no es un dato válido.'
			),
			'periodosemestre' => array (
				'fnc' =>'esCadenaValida',
				'max' => 6,
				'req' => true,
            	'msg' => 'El periodo no es un dato válido.'
			),
			'minvalorhora'=> array (
				'fnc' => 'esEntero',
				'max' => 32,
				'req' => true,
            	'msg' => 'El mínimo de la hora no es un dato válido.'
			),
			'maxvalorhora'=> array (
				'fnc' => 'esEntero',
				'max' => 32,
				'req' => true,
            	'msg' => 'El máximo de la hora no es un dato válido.'
			),
			'fechalimite' => array (
				'fnc' =>'esFechaValida',
				'max' => 10,
				'req' => true,
            	'msg' => 'La fecha límite para las inscripciones no es un dato válido.'
			)
		);
		$this->validacion =& new Validacion($this);
    } 

    /**
     * Co_PeriodoAcademico::insertar()
     * 
     * @return 
     */
    function insertar() {
        $this->insert();

		//Manejamos errores.
		if ($this->_lastError) {
			$this->validacion->acumuladoErrores['insertarPeriodoAcademico'] = 'Se produjo un error insertando el periodo academico';
			return FALSE;
		} else {
			return TRUE;
		}
	} // end insertar  
	
    /**
     * Co_PeriodoAcademico::actualizar()
     * 
     * @return 
     */
    function actualizar() {
        $clon = Co_PeriodoAcademico::staticGet($this->periodoacademico);
		
		if ($clon) {
			$rows = $this->update($clon);
        }
		
		//Manejamos errores.
		if ($rows == 0 && ( $this->_lastError && $this->_lastError->getCode() == DB_DATAOBJECT_ERROR_NODATA)) {
			$this->validacion->acumuladoErrores['actualilzarPeriodoAcademico'] = 'No se encontro el periodo academico a Actualizar';
			return FALSE;
		} elseif ($this->_lastError) {
			$this->validacion->acumuladoErrores['actualizarPeriodoAcademico'] = 'No se pudo Actualizar el periodo academico';
			return FALSE;
		} else {
			return TRUE;
		}

    } // end actualizar

    /**
     * Co_PeriodoAcademico::eliminar()
     * 
     * @param  $idPeriodoAcademico
     * @return 
     */
    function eliminar($id) {
        $this->periodoacademico = $id;
        $rows = $this->delete();
		//Manejamos errores.
		if ($this->_lastError) {
			$this->validacion->acumuladoErrores['eliminarPeriodoAcademico'] = 'No se pudo Eliminar el Periodo Academico';
			return FALSE;
		} else {
			if ($rows === FALSE || $rows == 0) {
			    $this->validacion->acumuladoErrores['eliminarPeriodoAcademico'] = 'No se encontro el Periodo Academico a Eliminar';
				return FALSE;
			} else {
				return TRUE;
			}
		}
    } // end eliminar

    /**
     * Co_PeriodoAcademico::buscar()
     * 
     * @param  $campoValorOperador 
     * @return 
     */
    function buscar($id) {
        $rows = $this->get($id);
		
		if ($this->_lastError) {
			$this->raiseError('No se pudo Buscar el Periodo Academico!', 10006);
			return FALSE;
		}
		
		if ($rows == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
    } // end buscar

    /**
     * Co_PeriodoAcademico::buscarPlanPagos()
     * 
     * @param  $campoValorOperador 
     * @return 
     */
    function buscarPlanPagos($periodoAcademico) {
    	if (empty($periodoAcademico)) {
    		$this->planpagos = array();
    		$this->porcentajepagos = array();
    	} else {
    		$unPlanPagos = new Co_PlanPagos();
    		$unPlanPagos->periodoacademico = $periodoAcademico;
    		$unPlanPagos->orderBy('periodoacademico');
    		$unPlanPagos->find();
    		$i = 0;
    		$j = 0;
    		while ($unPlanPagos->fetch()) {
    			$this->planpagos[$i] = $unPlanPagos->toArray();
    			$unPorcentajePagos = new DOCo_PorcentajePagos();
    			$unPorcentajePagos->planpagos = $unPlanPagos->planpagos;
    			$unPorcentajePagos->orderBy('posicion');
    			$unPorcentajePagos->find();
    			while ($unPorcentajePagos->fetch()) {
    				$this->porcentajepagos[$j] = $unPorcentajePagos->toArray();
    				$j++;
    			}
    			$i++;
    		}
    	}
    }

    /**
     * Co_PeriodoAcademico::tieneConvenios()
     *
     * @param  $periodoAcademico
     * @return
     */
    function tieneConvenios($periodoAcademico) {
    	$returnValue = FALSE;
		$unConvenio = new Co_Convenio();
		$unConvenio->periodoacademico = $periodoAcademico;
		$unConvenio->find();
		if ($unConvenio->N > 0) {
			$this->validacion->acumuladoErrores['tieneConvenios'] = 'El periodo académico tiene Monitorías asignadas';
			$returnValue = TRUE;
		}
		return $returnValue;
    }
    
    /**
     * Co_PeriodoAcademico::listar()
     * 
     * @param 
     * @return 
     */
    function listar($registroComienzoPagina, $registroFinalPagina, $condiciones = '') {
        if (!empty($condiciones)) {
            $this->whereAdd($condiciones);
        }
		$this->orderBy('periodoacademico');
		if ($registroComienzoPagina > 0 and $registroFinalPagina > 0) {
	        $this->limit($registroComienzoPagina, $registroFinalPagina);
		}
        $this->find();
    } // end listar

    /**
     * Co_PeriodoAcademico::asignar()
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
			$this->raiseError('No se pudo Asignar los valores!', 10008);
			return $returnValue;
		}
    } // end asignar    
	    	  
    /**
     * Co_PeriodoAcademico::asignarPlanPagos()
     *
     * @param  $atributos
     * @return
     */
    function asignarPlanPagos($arregloCampos) {
    	$planpagos = (isset($arregloCampos['planpagos']) && is_array($arregloCampos['planpagos']))?$arregloCampos['planpagos']:array();
    	$porcentajepagos = (isset($arregloCampos['porcentajepagos']) && is_array($arregloCampos['porcentajepagos']))?$arregloCampos['porcentajepagos']:array();
    	$this->planpagos = $planpagos;
    	$this->porcentajepagos = $porcentajepagos;
    	return TRUE;
    }
    
    /**
     * Co_PeriodoAcademico::validar()
     * 
     * @return 
     */
    function validar() {
        $returnValue = true;		
        $returnValue = $this->validacion->multiple($this->validacionCampos);
        
        if ($returnValue) {
        	$arrFechaInicio = explode('/', $this->fechainicio);
        	$numFechaInicio = mktime(0, 0, 0, $arrFechaInicio[1], $arrFechaInicio[0], $arrFechaInicio[2]);
        	$arrFechaFin = explode('/', $this->fechafin);
        	$numFechaFin = mktime(0, 0, 0, $arrFechaFin[1], $arrFechaFin[0], $arrFechaFin[2]);
        	if ($numFechaInicio > $numFechaFin) {
        		$this->validacion->acumuladoErrores['fechainicio1'] = 'La fecha de inicio no puede ser mayor a la fecha fin';
        		$returnValue = FALSE;
        	}
			if ((empty($this->fechainicioreceso) && !empty($this->fechafinreceso)) || (!empty($this->fechainicioreceso) && empty($this->fechafinreceso))) {
				$this->validacion->acumuladoErrores['fechainicio1'] = 'Debe ingresar las fecha de inicio y fin de la semana de receso';
				$returnValue = FALSE;
			} elseif (!empty($this->fechainicioreceso) && !empty($this->fechafinreceso)) {
				$arrFechaInicioR = explode('/', $this->fechainicioreceso);
				$numFechaInicioR = mktime(0, 0, 0, $arrFechaInicioR[1], $arrFechaInicioR[0], $arrFechaInicioR[2]);
				$arrFechaFinR = explode('/', $this->fechafinreceso);
				$numFechaFinR = mktime(0, 0, 0, $arrFechaFinR[1], $arrFechaFinR[0], $arrFechaFinR[2]);
				if ($numFechaInicioR > $numFechaFinR) {
					$this->validacion->acumuladoErrores['fechainicioreceso1'] = 'La fecha de inicio receso no puede ser mayor a la fecha fin receso';
					$returnValue = FALSE;
				}
				if ($numFechaInicioR < $numFechaInicio || $numFechaInicioR > $numFechaFin) {
					$this->validacion->acumuladoErrores['fechainicioreceso2'] = 'La fecha de inicio receso no se encuentra en el rango del periodo';
					$returnValue = FALSE;
				}
				if ($numFechaFinR < $numFechaInicio || $numFechaFinR > $numFechaFin) {
					$this->validacion->acumuladoErrores['fechafinreceso2'] = 'La fecha fin receso no se encuentra en el rango del periodo';
					$returnValue = FALSE;
				}
			}
        	$arrFechaLimite = explode('/', $this->fechalimite);
        	$numFechaLimite = mktime(0, 0, 0, $arrFechaLimite[1], $arrFechaLimite[0], $arrFechaLimite[2]);
        	if ($numFechaLimite < $numFechaInicio || $numFechaLimite > $numFechaFin) {
        		$this->validacion->acumuladoErrores['fechalimite1'] = 'La fecha límite de inscripción no se encuentra en el rango del periodo';
        		$returnValue = FALSE;
        	}
        	
        	if ($this->minhoras > $this->maxhoras) {
        		$this->validacion->acumuladoErrores['minhoras1'] = 'El mínimo de horas no puede ser mayor al máximo de horas';
        		$returnValue = FALSE;
        	}
        	if ($this->minvalorhora > $this->maxvalorhora) {
        		$this->validacion->acumuladoErrores['minvalorhora1'] = 'El valor mínimo hora no puede ser mayor al valor máximo hora';
        		$returnValue = FALSE;
        	}
        }
        return $returnValue;
    } // end validar  		 

    /**
     * Co_PeriodoAcademico::validarPlanPagos()
     *
     * @return
     */
    function validarPlanPagos() {
    	$returnValue = true;
    	if (count($this->planpagos) == 0) {
    		$this->validacion->acumuladoErrores['planpagos'] = 'Debe diligenciar el plan de pagos';
    		$returnValue = FALSE;
    	}
       	if (count($this->porcentajepagos) == 0) {
    		$this->validacion->acumuladoErrores['planpagos'] = 'Debe diligenciar el porcentaje de pagos';
    		$returnValue = FALSE;
    	}
    	$returnValue = $this->validacion->esCadenaValida($this->porcentajepagos[0]['fecha'], 16, 'Fecha Corte', true) && $returnValue;
    	$returnValue = $this->validacion->esCadenaValida($this->porcentajepagos[1]['fecha'], 16, 'Fecha Primer Corte', true) && $returnValue;
    	$returnValue = $this->validacion->esCadenaValida($this->porcentajepagos[2]['fecha'], 16, 'Fecha Segundo Corte', true) && $returnValue;

    	$arrFecha0 = explode('/', $this->porcentajepagos[0]['fecha']);
    	$numFecha0 = mktime(0, 0, 0, $arrFecha0[1], $arrFecha0[0], $arrFecha0[2]);
    	$arrFecha1 = explode('/', $this->porcentajepagos[1]['fecha']);
    	$numFecha1 = mktime(0, 0, 0, $arrFecha1[1], $arrFecha1[0], $arrFecha1[2]);
    	$arrFecha2 = explode('/', $this->porcentajepagos[2]['fecha']);
    	$numFecha2 = mktime(0, 0, 0, $arrFecha2[1], $arrFecha2[0], $arrFecha2[2]);
    	if ($numFecha1 > $numFecha2) {
    		$this->validacion->acumuladoErrores['fecha1'] = 'La fecha de primer corte no puede ser mayor a la fecha segundo corte';
    		$returnValue = FALSE;
    	}
    	
    	$arrFechaInicio = explode('/', $this->fechainicio);
    	$numFechaInicio = mktime(0, 0, 0, $arrFechaInicio[1], $arrFechaInicio[0], $arrFechaInicio[2]);
    	$arrFechaFin = explode('/', $this->fechafin);
    	$numFechaFin = mktime(0, 0, 0, $arrFechaFin[1], $arrFechaFin[0], $arrFechaFin[2]);
    	if ($numFecha0 < $numFechaInicio || $numFecha0 > $numFechaFin) {
    		$this->validacion->acumuladoErrores['fecha0'] = 'La fecha de corte no se encuentra en el rango del periodo';
    		$returnValue = FALSE;
    	}
        if ($numFecha1 < $numFechaInicio || $numFecha1 > $numFechaFin) {
    		$this->validacion->acumuladoErrores['fecha1'] = 'La fecha de primer corte no se encuentra en el rango del periodo';
    		$returnValue = FALSE;
    	}
    	if ($numFecha2 < $numFechaInicio || $numFecha2 > $numFechaFin) {
    		$this->validacion->acumuladoErrores['fecha2'] = 'La fecha de segundo corte no se encuentra en el rango del periodo';
    		$returnValue = FALSE;
    	}
    	return $returnValue;
    }
    
    /**
     * Co_PeriodoAcademico::contarPeriodosAcademicos()
     * 
     * @param 
     * @return 
     **/
    function contarPeriodosAcademicos() {
		$sentencia = "select count(periodoacademico) as numeroperiodosacademicos
			from co_periodoacademico
			order by 1";
        $this->query($sentencia);
    } // end contarPeriodosAcademicos

    /**
     * Co_PeriodoAcademico::insertarPeriodo()
     * 
     * @param 
     * @return 
     **/
    function insertarPeriodo($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos) && $this->asignarPlanPagos($arregloCampos)) {
    		if ($this->validar() && $this->validarPlanPagos()) {
    			if ($this->insertar()) {
    				$returnValue = $this->insertarPlanPagos();
    			}
    		}
    	}
    	return $returnValue;
    }
    
    /**
     * Co_PeriodoAcademico::insertarPlanPagos()
     *
     * @return
     */
    function insertarPlanPagos() {
    	$returnValue = TRUE;

    	$planpagos0 = $this->planpagos['0'];
		$planpagos0['periodoacademico'] = $this->periodoacademico;
		$planpagos0['aplicafechalimite'] = isset($planpagos0['aplicafechalimite'])?$planpagos0['aplicafechalimite']:'N';
		$unPlanPagos0 = new Co_PlanPagos();
    	$unPlanPagos0->asignar($planpagos0);
    	if (!$unPlanPagos0->insertar()) {
    		$this->validacion->acumuladoErrores['insertarPlanPagos0'] = 'Se presentó un error insertando el plan de pago 100%';
    		$returnValue = FALSE;
    	}
    	
    	$porcentajepagos0 = $this->porcentajepagos['0'];
    	$unPorcentajePagos0 = new DOCo_PorcentajePagos();
    	$unPorcentajePagos0->posicion = '1';
    	$unPorcentajePagos0->porcentaje = $porcentajepagos0['porcentaje'];
    	$unPorcentajePagos0->planpagos = $unPlanPagos0->planpagos;
    	$unPorcentajePagos0->fecha = $porcentajepagos0['fecha'];
    	if (!$unPorcentajePagos0->insert()) {
    		$this->validacion->acumuladoErrores['insertarPorcentajePagos0'] = 'Se presentó un error insertando el porcentaje del pago del 100%';
    		$returnValue = FALSE;
    	}
    	
    	$planpagos1 = $this->planpagos['1'];
    	$planpagos1['periodoacademico'] = $this->periodoacademico;
    	$planpagos1['aplicafechalimite'] = isset($planpagos1['aplicafechalimite'])?$planpagos1['aplicafechalimite']:'N';
    	$unPlanPagos1 = new Co_PlanPagos();
    	$unPlanPagos1->asignar($planpagos1);
    	if (!$unPlanPagos1->insertar()) {
    		$this->validacion->acumuladoErrores['insertarPlanPagos1'] = 'Se presentó un error insertando el plan de pago 50% - 50%';
    		$returnValue = FALSE;
    	}
    	
    	$porcentajepagos1 = $this->porcentajepagos['1'];
    	$unPorcentajePagos1 = new DOCo_PorcentajePagos();
    	$unPorcentajePagos1->posicion = '1';
    	$unPorcentajePagos1->porcentaje = $porcentajepagos1['porcentaje'];
    	$unPorcentajePagos1->planpagos = $unPlanPagos1->planpagos;
    	$unPorcentajePagos1->fecha = $porcentajepagos1['fecha'];
    	if (!$unPorcentajePagos1->insert()) {
    		$this->validacion->acumuladoErrores['insertarPorcentajePagos1'] = 'Se presentó un error insertando el porcentaje del pago del primer corte';
    		$returnValue = FALSE;
    	}
    	
    	$porcentajepagos2 = $this->porcentajepagos['2'];
    	$unPorcentajePagos2 = new DOCo_PorcentajePagos();
    	$unPorcentajePagos2->posicion = '2';
    	$unPorcentajePagos2->porcentaje = $porcentajepagos2['porcentaje'];
    	$unPorcentajePagos2->planpagos = $unPlanPagos1->planpagos;
    	$unPorcentajePagos2->fecha = $porcentajepagos2['fecha'];
    	if (!$unPorcentajePagos2->insert()) {
	   		$this->validacion->acumuladoErrores['insertarPorcentajePagos2'] = 'Se presentó un error insertando el porcentaje del pago del segundo corte';
    		$returnValue = FALSE;
    	}
    	unset($unPlanPagos0);
    	unset($unPorcentajePagos0);
    	unset($unPlanPagos1);
    	unset($unPorcentajePagos1);
    	unset($unPorcentajePagos2);
    	
    	return $returnValue;
    }
    
    /**
     * Co_PeriodoAcademico::actualizarPeriodo()
     * 
     * @param 
     * @return 
     **/
    function actualizarPeriodo($arregloCampos) {
    	$returnValue = FALSE;
    	if ($this->asignar($arregloCampos) && $this->asignarPlanPagos($arregloCampos)) {
    		if ($this->validar() && $this->validarPlanPagos()) {
    			if ($this->actualizar()) {
   					$returnValue = $this->actualizarPlanPagos();
    			}
    		}
    	}
    	return $returnValue;
    }

    /**
     * Co_PeriodoAcademico::actualizarPlanPagos()
     *
     * @return
     */
    function actualizarPlanPagos() {
    	$returnValue = TRUE;
    
    	$planpagos0 = $this->planpagos['0'];
    	$planpagos0['periodoacademico'] = $this->periodoacademico;
    	$planpagos0['aplicafechalimite'] = isset($planpagos0['aplicafechalimite'])?$planpagos0['aplicafechalimite']:'N';
    	$unPlanPagos0 = new Co_PlanPagos();
    	if (!$unPlanPagos0->actualizarPlanPagos($planpagos0)) {
    		$this->validacion->acumuladoErrores['actualizarPlanPagos0'] = 'Se presentó un error actualizando el plan de pago 100%';
    		$returnValue = FALSE;
    	}
    	
    	$porcentajepagos0 = $this->porcentajepagos['0'];
    	$porcentajepagos0['posicion'] = '1';
    	$porcentajepagos0['planpagos'] = $unPlanPagos0->planpagos;
    	$unPorcentajePagos0 = new Co_PorcentajePagos();
    	if (!$unPorcentajePagos0->actualizarPorcentajePagos($porcentajepagos0)) {
    		$this->validacion->acumuladoErrores['actualizarPorcentajePagos0'] = 'Se presentó un error actualizando el porcentaje del pago del 100%';
    		$returnValue = FALSE;
    	}

    	$planpagos1 = $this->planpagos['1'];
    	$planpagos1['periodoacademico'] = $this->periodoacademico;
    	$planpagos1['aplicafechalimite'] = isset($planpagos1['aplicafechalimite'])?$planpagos1['aplicafechalimite']:'N';
    	$unPlanPagos1 = new Co_PlanPagos();
    	if (!$unPlanPagos1->actualizarPlanPagos($planpagos1)) {
    		$this->validacion->acumuladoErrores['actualizarPlanPagos1'] = 'Se presentó un error actualizando el plan de pago 50% - 50%';
    		$returnValue = FALSE;
    	}
    	
    	$porcentajepagos1 = $this->porcentajepagos['1'];
    	$porcentajepagos1['posicion'] = '1';
    	$porcentajepagos1['planpagos'] = $unPlanPagos1->planpagos;
    	$unPorcentajePagos1 = new Co_PorcentajePagos();
    	if (!$unPorcentajePagos1->actualizarPorcentajePagos($porcentajepagos1)) {
    		$this->validacion->acumuladoErrores['actualizarPorcentajePagos1'] = 'Se presentó un error insertando el porcentaje del pago del primer corte';
    		$returnValue = FALSE;
    	}
    	
    	$porcentajepagos2 = $this->porcentajepagos['2'];
    	$porcentajepagos2['posicion'] = '2';
    	$porcentajepagos2['planpagos'] = $unPlanPagos1->planpagos;
    	$unPorcentajePagos2 = new Co_PorcentajePagos();
    	if (!$unPorcentajePagos2->actualizarPorcentajePagos($porcentajepagos2)) {
    		$this->validacion->acumuladoErrores['actualizarPorcentajePagos2'] = 'Se presentó un error insertando el porcentaje del pago del segundo corte';
    		$returnValue = FALSE;
    	}

    	unset($unPlanPagos0);
    	unset($unPorcentajePagos0);
    	unset($unPlanPagos1);
    	unset($unPorcentajePagos1);
    	unset($unPorcentajePagos2);
    
    	return $returnValue;
    }
    
    /**
     * Co_PeriodoAcademico::eliminarPeriodo()
     * 
     * @param 
     * @return 
     **/
    function eliminarPeriodo($arregloCampos) {
    	$returnValue = FALSE;
    	if (isset($arregloCampos['periodoacademico']) && !empty($arregloCampos['periodoacademico'])) {
    		$returnValue = $this->eliminar($arregloCampos['periodoacademico']);
    	}
    	return $returnValue;
    }

    /**
     * Co_PeriodoAcademico::eliminarPlanPagos()
     *
     * @param
     * @return
     **/
    function eliminarPlanPagos($arregloCampos) {
    	$returnValue = FALSE;
    	if (isset($arregloCampos['periodoacademico']) && !empty($arregloCampos['periodoacademico'])) {
    		$unPlanPagos = new Co_PlanPagos();
    		$unPlanPagos->periodoacademico = $arregloCampos['periodoacademico'];
    		$unPlanPagos->find();
    		while ($unPlanPagos->fetch()) {
    			$unPorcentajePagos = new DOCo_PorcentajePagos();
    			$unPorcentajePagos->planpagos = $unPlanPagos->planpagos;
    			$unPorcentajePagos->delete();
    			unset($unPorcentajePagos);
    		}
    		unset($unPlanPagos);
    		$unPlanPagos = new Co_PlanPagos();
    		$unPlanPagos->periodoacademico = $arregloCampos['periodoacademico'];
    		$unPlanPagos->delete();
    		if ($unPlanPagos->_lastError) {
    			$this->validacion->acumuladoErrores['eliminarPlanPagos'] = 'Se presentó un error eliminando el plan del pagos';
    		} else {
    			$returnValue = TRUE;
    		} 
    	} else {
    		$this->validacion->acumuladoErrores['eliminarPlanPagos'] = 'El código del periodo académico es vacio';
    	}
    	return $returnValue;
    }
    
    /**
     * Co_PeriodoAcademico::cargarPeriodoActual()
     * 
     * @param 
     * @return 
     **/
    function cargarPeriodoActual() {
    	$this->whereAdd(' SYSDATE BETWEEN FECHAINICIO AND FECHAFIN ');
        $this->find(TRUE);
        return $this->toArray();
    } // end contarPeriodosAcademicos
    
    
} // end Co_PeriodoAcademico
?>