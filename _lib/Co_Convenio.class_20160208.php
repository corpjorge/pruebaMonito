<?php

require_once("Co_Pago.php");
require_once("Co_Cuenta.php");
require_once("Co_Convenio.php");
require_once("Co_Dependencia.php");
require_once("Co_TipoLabor.php");
require_once("Co_TipoMonitor.php");
require_once("Co_Materia.class.php");
require_once("Co_Distribucion.class.php");
require_once("Co_Estudiante.class.php");
require_once("Co_PlanPagos.class.php");
require_once("Co_PorcentajePagos.php");
require_once("Co_PeriodoAcademico.class.php");
require_once("ClienteWebService.class.php");
require_once("Validacion.class.php");
 
/*
 * Co_Convenio
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_Convenio extends DOCo_Convenio {

	var $validacion;
	var $validacionCampos;
	var $arrayDependencia;
	var $periodoActual;
	var $materias;
	var $distribucion;
	var $fondoPresupuestal;
	var $dependenciapadre;
	var $labor;
	var $planPagos;
	var $cuenta;
	var $aplicaFechaLimite;
	var $pagos;
	
    /**
     * M�todo Constructor de la clase
     * 
     * @return 
     */
    function Co_Convenio() {
    	$this->validacionCampos = array (
			'fechainicio' => array (
				'fnc' =>'esFechaValida',
				'max' => 10,
				'req' => true,
            	'msg' => 'La fecha de inicio no es un dato v�lido.'
			),
			'fechafin' => array (
				'fnc' =>'esFechaValida',
				'max' => 10,
				'req' => true,
            	'msg' => 'La fecha fin no es un dato v�lido.'
			),
			'estudiante' => array (
				'fnc' =>'esEntero',
				'max' => 32,
				'req' => false,
            	'msg' => 'La monitoria no fue asociado a un estudiante v�lido.'
			),
			'dependenciapadre' => array (
				'fnc' =>'esCadenaValida',
				'max' => 32,
				'req' => true,
            	'msg' => 'La facultad no es un dato v�lido.'
			),
			'dependencia' => array (
				'fnc' =>'esCadenaValida',
				'max' => 32,
				'req' => false,
            	'msg' => 'El departamento no es un dato v�lido.'
			),
			'tipomonitor'=> array (
				'fnc' => 'esEntero',
				'max' => 32,
				'req' => true,
            	'msg' => 'El tipo de monitor no es un dato v�lido.'
			),
			'tipolabor'=> array (
				'fnc' => 'esEntero',
				'max' => 32,
				'req' => true,
            	'msg' => 'El tipo labor no es un dato v�lido.'
			),
			'periodoacademico' => array (
				'fnc' =>'esEntero',
				'max' => 32,
				'req' => true,
            	'msg' => 'La monitoria no fue asociado a un periodo v�lido.'
			),
			'valorhora' => array (
				'fnc' =>'esEntero',
				'max' => 32,
				'req' => false,
            	'msg' => 'El valor de la hora no es un dato v�lido.'
			),
			'horassemanales' => array (
				'fnc' =>'esEntero',
				'max' => 32,
				'req' => false,
            	'msg' => 'Las horas semanales no es un dato v�lido.'
			),
			'estado' => array (
				'fnc' =>'esCadenaValida',
				'max' => 8,
				'req' => true,
            	'msg' => 'El estado no es un dato v�lido.'
			)
		);
		$this->validacion =& new Validacion($this);
    } 

    /**
     * Co_Convenio::insertar()
     * 
     * @return 
     */
    function insertar() {
        $this->insert();

		//Manejamos errores.
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['insertarConvenio'] = 'Se produjo un error insertando la monitoria';
			return false;
		} else {
			return true;
		}
	} // end insertar  

    /**
     * Co_Convenio::insertarConvenio()
     * 
     * @return 
     */
    function insertarConvenio() {
    	$unConvenio = new Co_Convenio();
    	$this->consecutivo = $unConvenio->obtenerConsecutivo($this->estudiante);
    	
    	if ($this->labor == 'D') {
    		$this->valorhora = NULL;
    		$this->horassemanales = NULL;
    		$this->descripcion = NULL;
    	}
    	return $this->insertar();
	}

    /**
     * Co_Convenio::insertarMaterias()
     * 
     * @return 
     */
    function insertarMaterias() {
    	$returnValue = true;
    	if ($this->labor == 'D') {
    		foreach ($this->materias as $vMateria) {
    			$vMateria['convenio'] = $this->convenio;
    			$vMateria['curso'] = $vMateria['curso'] . '_' . str_pad($vMateria['seccion'], 2, '0', STR_PAD_LEFT);
    			//isset($vMateria['materia']);
    			$unMateria = new Co_Materia();
	    		$returnValue = $unMateria->insertarMateria($vMateria) && $returnValue;
    		}
    	} else {
    		$vMateria = $this->materias[1000];
    		$vMateria['convenio'] = $this->convenio;
    		$vMateria['curso'] = $vMateria['curso'] . '_' . str_pad($vMateria['seccion'], 2, '0', STR_PAD_LEFT);
    		$vMateria['valorhora'] = '0';
    		$vMateria['horassemanales'] = '0';
    		$unMateria = new Co_Materia();
    		$returnValue = $unMateria->insertarMateria($vMateria) && $returnValue;
    	}
       	if (!$returnValue) {
   			$erroresMateria = $unMateria->validacion->getErrores();
   			$this->validacion->acumuladoErrores = array_merge($erroresMateria, $this->validacion->acumuladoErrores);
   		}
    	return $returnValue;
	}

    /**
     * Co_Convenio::insertarDistribucion()
     * 
     * @return 
     */
    function insertarDistribucion() {
    	$returnValue = true;
    	foreach ($this->distribucion as $vDistribucion) {
    		$vDistribucion['convenio'] = $this->convenio;
    		$unDistribucion = new Co_Distribucion();
    		$returnValue = $unDistribucion->insertarDistribucion($vDistribucion) && $returnValue;
    	}
    	if (!$returnValue) {
    		$erroresDistribucion = $unDistribucion->validacion->getErrores();
    		$this->validacion->acumuladoErrores = array_merge($erroresDistribucion, $this->validacion->acumuladoErrores);
    	}
    	return $returnValue;
	}

    /**
     * Co_Convenio::insertarPagos()
     * 
     * @return 
     */
    function insertarPagos() {
    	$planPagos = $this->planPagos['planpagos'];
    	$valor = $this->planPagos['valor'];
    	$returnValue = true;
    	$unPorcentajePagos = new DOCo_PorcentajePagos();
    	$unPorcentajePagos->planpagos = $planPagos;
    	$unPorcentajePagos->orderBy('posicion');
    	$unPorcentajePagos->find();
    	while ($unPorcentajePagos->fetch()) {
    		$valorPago = number_format($valor * ($unPorcentajePagos->porcentaje / 100), 3, '.', '');
    		$unPago = new DOCo_Pago();
    		$unPago->valor = $valorPago;
    		$unPago->convenio = $this->convenio;
    		$unPago->porcentajepagos = $unPorcentajePagos->porcentajepagos;
    		$unPago->insert();
			if ($unPago->_lastError) {
			    $this->validacion->acumuladoErrores['insertarPago' . $unPorcentajePagos->posicion] = 'Se produjo un error insertando el plan de pagos';
				$returnValue = false;
			}
    	}
    	return $returnValue;
	}

    /**
     * Co_Convenio::insertarCuenta()
     * 
     * @return 
     */
    function insertarCuenta() {
    	$tipocuenta = $this->cuenta['tipocuenta'];
        $banco = $this->cuenta['banco'];
        $numerocuenta = $this->cuenta['numerocuenta'];
    	$returnValue = true;
    	
    	$unCuenta = new DOCo_Cuenta();
    	$unCuenta->estudiante = $this->estudiante;
    	$unCuenta->tipocuenta = $tipocuenta;
    	$unCuenta->banco = $banco;
    	$unCuenta->numerocuenta = $numerocuenta;
    	$unCuenta->insert();
		if ($unCuenta->_lastError) {
		    $this->validacion->acumuladoErrores['insertarCuenta'] = 'Se produjo un error insertando la cuenta';
			$returnValue = false;
		}
    	return $returnValue;
	}
	
    /**
     * Co_Convenio::actualizar()
     * 
     * @return 
     */
    function actualizar() {
        $clon = Co_Convenio::staticGet($this->convenio);
		if ($clon) {
			$rows = $this->update($clon);
        }
		//Manejamos errores.
		if ($rows == 0 || ( $this->_lastError && $this->_lastError->getCode() == DB_DATAOBJECT_ERROR_NODATA)) {
			$this->validacion->acumuladoErrores['actualizarConvenio'] = 'No se encontro la monitoria a Actualizar';
			return false;
		} elseif ($this->_lastError) {
			$this->validacion->acumuladoErrores['actualizarConvenio'] = 'No se pudo Actualizar la monitoria';
			return false;
		} else {
			return true;
		}
    } // end actualizar

    /**
     * Co_Convenio::eliminar()
     * 
     * @param  $idConvenio
     * @return 
     */
    function eliminar($id) {
        $this->convenio = $id;
        $rows = $this->delete();
		//Manejamos errores.
		if ($this->_lastError) {
			$this->validacion->acumuladoErrores['eliminarConvenio'] = 'No se pudo Eliminar la monitoria';
			return false;
		} else {
			if ($rows === false || $rows == 0) {
				$this->validacion->acumuladoErrores['eliminarConvenio'] = 'No se encontro la monitoria a Eliminar';
				return false;
			} else {
				return true;
			}
		}
    } // end eliminar

    /**
     * Co_Convenio::eliminarConvenio()
     * 
     * @param  $idConvenio
     * @return 
     */
    function eliminarConvenio($id) {
		$this->eliminarPagoPorConvenio($id);
		$this->eliminarDistribucionPorConvenio($id);
		$this->eliminarMateriaPorConvenio($id);
    } // end eliminarConvenio
    
    /**
     * Co_Convenio::eliminarPagoPorConvenio()
     * 
     * @param  $id
     * @return 
     */
    function eliminarPagoPorConvenio($idConvenio) {
    	$unPago = new DOCo_Pago();
        $unPago->convenio = $idConvenio;
        $rows = $unPago->delete();
		//Manejamos errores.
		if ($unPago->_lastError) {
		    $this->validacion->acumuladoErrores['eliminarPago'] = 'No se pudo Eliminar los pagos';
			return false;
		} else {
			if ($rows === false || $rows == 0) {
		    	$this->validacion->acumuladoErrores['eliminarPago'] = 'No se encontraron los pagos a Eliminar';
				return false;
			} else {
				return true;
			}
		}
    } // end eliminar

    /**
     * Co_Convenio::eliminarDistribucionPorConvenio()
     *
     * @param  $id
     * @return
     */
    function eliminarDistribucionPorConvenio($idConvenio) {
    	$unDistribucion = new Co_Distribucion();
    	$unDistribucion->convenio = $idConvenio;
    	if (!$unDistribucion->eliminarDistribucionPorConvenio($idConvenio)) {
    		$erroresDistribucion = $unDistribucion->validacion->getErrores();
    		$this->validacion->acumuladoErrores = array_merge($erroresDistribucion, $this->validacion->getErrores());
    		return false;
    	}
		return true;
    } // end eliminar

    /**
     * Co_Convenio::eliminarMateriaPorConvenio()
     *
     * @param  $id
     * @return
     */
    function eliminarMateriaPorConvenio($idConvenio) {
    	$unMateria = new Co_Materia();
    	$unMateria->convenio = $idConvenio;
    	if (!$unMateria->eliminarMateriaPorConvenio($idConvenio)) {
    		$erroresMateria = $unMateria->validacion->getErrores();
    		$this->validacion->acumuladoErrores = array_merge($erroresMateria, $this->validacion->getErrores());
    		return false;
    	}
    	return true;
    } // end eliminar

    /**
     * Co_Convenio::eliminarCuentaPorEstudiante()
     * 
     * @param  $id
     * @return 
     */
    function eliminarCuentaPorEstudiante($idEstudiante) {
    	$unCuenta = new DOCo_Cuenta();
        $unCuenta->estudiante = $idEstudiante;
        $rows = $unCuenta->delete();
		//Manejamos errores.
		if ($unCuenta->_lastError) {
		    $this->validacion->acumuladoErrores['eliminarCuenta'] = 'No se pudo Eliminar las cuentas';
			return false;
		} else {
			if ($rows === false || $rows == 0) {
		    	$this->validacion->acumuladoErrores['eliminarCuenta'] = 'No se encontraron las cuentas a Eliminar';
				return false;
			} else {
				return true;
			}
		}
    } // end eliminar
    
    /**
     * Co_Convenio::buscar()
     * 
     * @param  $campoValorOperador 
     * @return 
     */
    function buscar($id) {
        $rows = $this->get($id);
		
		if ($this->_lastError) {
			$this->raiseError('No se pudo Buscar la monitoria!', 10006);
			return false;
		}
		
		if ($rows == 0) {
			return false;
		} else {
			return true;
		}
    } // end buscar

    /**
     * Co_Convenio::buscarMateriaPorConvenio()
     * 
     * @param  $idConvenio 
     * @return 
     */
    function buscarMateriaPorConvenio($idConvenio) {
    	$this->materias = array();
    	$unMateria = new Co_Materia();
    	$unMateria->convenio = $idConvenio;
    	$unMateria->find();
    	while ($unMateria->fetch()) {
    		$arrayCurso = explode('_', $unMateria->curso);
    		$materia['curso'] = $arrayCurso[0];
    		$materia['seccion'] = $arrayCurso[1];
    		$this->materias[] = array_merge($unMateria->toArray(), $materia);
    	}
    }

    /**
     * Co_Convenio::buscarDistribucionPorConvenio()
     *
     * @param  $idConvenio
     * @return
     */
    function buscarDistribucionPorConvenio($idConvenio) {
    	$this->distribucion = array();
    	$unDistribucion = new Co_Distribucion();
    	$unDistribucion->convenio = $idConvenio;
    	$unDistribucion->find();
    	while ($unDistribucion->fetch()) {
    		$this->distribucion[] = $unDistribucion->toArray();
    	}
    }
    
    /**
     * Co_Convenio::buscarPlanPagoPorConvenio()
     *
     * @param  $idConvenio
     * @return
     */
    function buscarPlanPagoPorConvenio($idConvenio) {
    	$this->planPagos = array();
    	$unPago = new DOCo_Pago();
    	$unPago->get('convenio', $idConvenio);
    	$unPorcentaje = new DOCo_PorcentajePagos();
    	$unPorcentaje->get($unPago->porcentajepagos);
    	$this->planPagos['planpagos'] = $unPorcentaje->planpagos;
    	$this->planPagos['valor'] = $this->calcularValorConvenio();
    }

    /**
     * Co_Convenio::buscarCuentaPorConvenio()
     *
     * @param  $idConvenio
     * @return
     */
    function buscarCuentaPorEstudiante($idEstudiante) {
    	$this->cuenta = array();
    	$unCuenta = new DOCo_Cuenta();
    	$unCuenta->get('estudiante', $idEstudiante);
    	$this->cuenta = $unCuenta->toArray();
    }

    /**
     * Co_Convenio::buscarPagosPorConvenio()
     *
     * @param  $idConvenio
     * @return
     */
    function buscarPagosPorConvenio($idConvenio) {
    	$this->pagos = array();
    	$unPago = new DOCo_Pago();
    	$unPago->convenio = $idConvenio;
    	$unPago->orderBy('pago');
    	$unPago->find();
		while ($unPago->fetch()) {
			$this->pagos[] = $unPago->pago;
		}
    }
    
    /**
     * Co_Convenio::listar()
     * 
     * @param 
     * @return 
     */
    function listar($filtros = array(), $paginacion = array()) {
    	$condicion = '';
    	$filtroPeriodoAcademico = isset($filtros['filtroPeriodoAcademico'])?$filtros['filtroPeriodoAcademico']:'';
    	$filtroDependencia = isset($filtros['filtroDependencia'])?$filtros['filtroDependencia']:'';
    	$filtroCodigo = isset($filtros['filtroCodigo'])?$filtros['filtroCodigo']:'';
    	$filtroEstado = isset($filtros['filtroEstado'])?$filtros['filtroEstado']:'';
    	
    	$regInicio = isset($paginacion['regInicio'])?$paginacion['regInicio']:1;
    	$regFin = isset($paginacion['regFin'])?$paginacion['regFin']:1;
    	
    	if (!empty($filtroPeriodoAcademico)) {
			$condicion .= ' AND C.PERIODOACADEMICO = ' . $filtroPeriodoAcademico;
		}
		if (!empty($filtroDependencia)) {
			$condicion .= " AND (D.DEPENDENCIA = '" . $filtroDependencia . "' OR D.DEPENDENCIAPADRE = '" . $filtroDependencia . "') ";
		}
		if (!empty($filtroEstado)) {
			$condicion .= " AND C.ESTADO = '" . $filtroEstado . "' ";
		}
		if (!empty($filtroCodigo)) {
			$condicion .= " AND E.CODIGO = '" . $filtroCodigo . "' ";
		}
        $sentencia = "
			SELECT *
			FROM (
			    SELECT ROWNUM AS LINENUM, CONVENIO, FECHAINICIO, FECHAFIN, ESTUDIANTE, DEPENDENCIA, TIPOMONITOR, TIPOLABOR,
			      PERIODOACADEMICO, VALORHORA, HORASSEMANALES, DESCRIPCION, ESTADO, CONSECUTIVO, USUARIOCREACION, FECHACREACION,
			      NOMBRES, APELLIDOS, DIRECCION, TELEFONO, EMAIL, GENERO, EXPEDICIONDOC, CODIGO, DOCUMENTO, ESTADOESTUDIANTE,
			      TIPODOCUMENTO, CIUDAD, DEPARTAMENTO, PAIS, NOMBREDEPENDENCIA
			    FROM (
			        SELECT C.CONVENIO, C.FECHAINICIO, C.FECHAFIN, C.ESTUDIANTE, C.DEPENDENCIA, C.TIPOMONITOR, C.TIPOLABOR,
			          C.PERIODOACADEMICO, C.VALORHORA, C.HORASSEMANALES, C.DESCRIPCION, C.ESTADO, C.CONSECUTIVO, C.USUARIOCREACION, C.FECHACREACION,
			          E.NOMBRES, E.APELLIDOS, E.DIRECCION, E.TELEFONO, E.EMAIL, E.GENERO, E.EXPEDICIONDOC, E.CODIGO, E.DOCUMENTO, E.ESTADOESTUDIANTE,
			          E.TIPODOCUMENTO, E.CIUDAD, E.DEPARTAMENTO, E.PAIS, D.NOMBRE NOMBREDEPENDENCIA
			        FROM CO_CONVENIO C, CO_DEPENDENCIA D, CO_ESTUDIANTE E
			        WHERE C.DEPENDENCIA = D.DEPENDENCIA
			          AND C.ESTUDIANTE = E.ESTUDIANTE
			          $condicion
			        ORDER BY D.NOMBRE, E.NOMBRES
			      )
			    WHERE ROWNUM <= $regFin
			  )
			WHERE LINENUM >= $regInicio
    	";
		// echo $sentencia;exit;
    	$this->query($sentencia);
    } // end listar

    /**
     * Co_Convenio::contar()
     *
     * @param
     * @return
     */
    function contar($filtros = array()) {
    	$condicion = '';
    	$filtroPeriodoAcademico = isset($filtros['filtroPeriodoAcademico'])?$filtros['filtroPeriodoAcademico']:'';
    	$filtroDependencia = isset($filtros['filtroDependencia'])?$filtros['filtroDependencia']:'';
    	$filtroCodigo = isset($filtros['filtroCodigo'])?$filtros['filtroCodigo']:'';
    	$filtroEstado = isset($filtros['filtroEstado'])?$filtros['filtroEstado']:'';
    
    	if (!empty($filtroPeriodoAcademico)) {
    		$condicion .= ' AND C.PERIODOACADEMICO = ' . $filtroPeriodoAcademico;
    	}
    	if (!empty($filtroDependencia)) {
    		$condicion .= " AND (D.DEPENDENCIA = '" . $filtroDependencia . "' OR D.DEPENDENCIAPADRE = '" . $filtroDependencia . "') ";
    	}
    	if (!empty($filtroEstado)) {
    		$condicion .= " AND C.ESTADO = '" . $filtroEstado . "' ";
    	}
    	if (!empty($filtroCodigo)) {
    		$condicion .= " AND E.CODIGO = '" . $filtroCodigo . "' ";
    	}
    	$sentencia = "
			SELECT COUNT(*) CANTIDAD
	        FROM CO_CONVENIO C, CO_DEPENDENCIA D, CO_ESTUDIANTE E
	        WHERE C.DEPENDENCIA = D.DEPENDENCIA
	          AND C.ESTUDIANTE = E.ESTUDIANTE
	          $condicion
	        ORDER BY D.NOMBRE, E.NOMBRES
    	";
    	$unConvenio = new Co_Convenio();
    	$unConvenio->query($sentencia);
    	$cantidad = 0;
    	if ($unConvenio->fetch()) {
    		$cantidad = $unConvenio->cantidad;
    	}
    	return $cantidad;
    } // end listar
    
    
    /**
     * Co_Convenio::asignar()
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
     * Co_Convenio::asignarMaterias()
     * 
     * @param  $atributos 
     * @return 
     */
    function asignarMaterias($materias) {
    	if (!is_array($materias)) {
    		$materias = array();
    	}
    	$this->materias = $materias;
    }

    /**
     * Co_Convenio::asignarDistribucion()
     * 
     * @param  $atributos 
     * @return 
     */
    function asignarDistribucion($distribucion) {
    	if (!is_array($distribucion)) {
    		$distribucion = array();
    	}
    	$this->distribucion = $distribucion;
    }

    /**
     * Co_Convenio::asignarPlanPagos()
     * 
     * @param  $atributos 
     * @return 
     */
    function asignarPlanPagos($planPagos) {
    	if (!is_array($planPagos)) {
    		$planPagos = array();
    	}
    	$this->planPagos = $planPagos;
    }
    
    /**
     * Co_Convenio::asignarCuenta()
     * 
     * @param  $atributos 
     * @return 
     */
    function asignarCuenta($cuenta) {
    	if (!is_array($cuenta)) {
    		$cuenta = array();
    	}
    	$this->cuenta = $cuenta;
    }
    
    /**
     * Co_Convenio::validar()
     * 
     * @return 
     */
    function validar() {
        $returnValue = true;		
        $returnValue = $this->validacion->multiple($this->validacionCampos);
        return $returnValue;
    } // end validar  		 

    /**
     * Co_Convenio::usrSolicitarConvenio()
     * 
     * @param 
     * @return 
     **/
    function usrSolicitarConvenio($arregloCampos) {
    	$returnValue = false;
    	if ($this->asignar($arregloCampos)) {
    		if ($this->validar()) {
    			$returnValue = $this->insertar();
    		}
    	}
    	return $returnValue;
    }
    
    /**
     * Co_Convenio::cargarTipoLabor()
     * 
     * Carga la lista de tipos de labor
     * 
     * @param 
     * @return 
     **/
    function cargarTipoLabor($dependencia) {
    	$tiposLabor = array();
    	$sentencia = "
			SELECT TL.TIPOLABOR, TL.NOMBRE 
			FROM CO_TIPOMONITOR TM, CO_TIPOMONITORDEPENDENCIA TD, CO_TIPOLABOR TL
			WHERE TD.TIPOMONITOR = TM.TIPOMONITOR
			  AND TM.TIPOMONITOR = TL.TIPOMONITOR
			  AND TD.DEPENDENCIA = '$dependencia'
			UNION
			SELECT TL.TIPOLABOR, TL.NOMBRE 
			FROM CO_TIPOMONITOR TM, CO_TIPOLABOR TL
			WHERE TM.TIPOMONITOR = TL.TIPOMONITOR
			  AND TM.TIPOMONITOR NOT IN (
			    SELECT TD.TIPOMONITOR
			    FROM CO_TIPOMONITORDEPENDENCIA TD
			  )
			ORDER BY 2
    	";
    	$unConvenio = new Co_Convenio();
    	$unConvenio->query($sentencia);
    	while ($unConvenio->fetch()) {
    		$tiposLabor[$unConvenio->tipolabor] = $unConvenio->nombre;
    	}
    	return $tiposLabor;
    }

    /**
     * Co_Convenio::cargarTipoMonitor()
     * 
     * Carga la lista de tipos de monitor
     * 
     * @param 
     * @return 
     **/
    function cargarTipoMonitor($dependencia) {
    	$tiposMonitor = array();
    	$sentencia = "
			SELECT TM.TIPOMONITOR, TM.NOMBRE 
			FROM CO_TIPOMONITOR TM, CO_TIPOMONITORDEPENDENCIA TD
			WHERE TD.TIPOMONITOR = TM.TIPOMONITOR
			  AND TD.DEPENDENCIA = '$dependencia'
			UNION
			SELECT TM.TIPOMONITOR, TM.NOMBRE 
			FROM CO_TIPOMONITOR TM
			WHERE TM.TIPOMONITOR NOT IN (
			    SELECT TD.TIPOMONITOR
			    FROM CO_TIPOMONITORDEPENDENCIA TD
			  )
			ORDER BY 2
    	";
    	$unConvenio = new Co_Convenio();
    	$unConvenio->query($sentencia);
    	while ($unConvenio->fetch()) {
    		$tiposMonitor[$unConvenio->tipomonitor] = $unConvenio->nombre;
    	}
    	return $tiposMonitor;
    }

    /**
     * Co_Convenio::buscarTipoLabor()
     * 
     * Busca un tipo de labor
     * 
     * @param 
     * @return 
     **/
    function buscarTipoLabor($idTipoLabor) {
    	$tipoLabor = array();
    	$sentencia = "
			SELECT * 
			FROM CO_TIPOLABOR TL
			WHERE TL.TIPOLABOR = '$idTipoLabor'
    	";
    	$unConvenio = new Co_Convenio();
    	$unConvenio->query($sentencia);
    	while ($unConvenio->fetch()) {
    		$tipoLabor['tipolabor'] = $unConvenio->tipolabor;
    		$tipoLabor['nombre'] = $unConvenio->nombre;
    		$tipoLabor['descripcion'] = $unConvenio->descripcion;
    		$tipoLabor['tipomonitor'] = $unConvenio->tipomonitor;
    		$tipoLabor['labor'] = $unConvenio->labor;
    	}
    	return $tipoLabor;
    }
    
    /**
     * Co_Convenio::cargarDependencias()
     * 
     * @param 
     * @return 
     **/
    function cargarDependencias() {
		$arrayDependencia = array();
		$unFacultad = new DOCo_Dependencia();
		$unFacultad->whereAdd(' DEPENDENCIAPADRE IS NULL ');
		$unFacultad->find();
		while ($unFacultad->fetch()) {
			$arrayDependencia[$unFacultad->dependencia] = array();
			$arrayDependencia[$unFacultad->dependencia]['nombre'] = $unFacultad->nombre;
			$arrayDependencia[$unFacultad->dependencia]['departamento'] = array();
			$unDepartamento = new DOCo_Dependencia();
			$unDepartamento->dependenciapadre = $unFacultad->dependencia;
			$unDepartamento->find();
			while ($unDepartamento->fetch()) {
				$arrayDependencia[$unFacultad->dependencia]['departamento'][$unDepartamento->dependencia] = $unDepartamento->nombre;
			}
			unset($unDepartamento);
		}
		unset($unFacultad);
		$this->arrayDependencia = $arrayDependencia;
    }
  
    /**
     * Co_Convenio::cargarMateriaPorCodigo()
     * 
     * @param 
     * @return 
     **/
    function cargarMateriaPorCodigo($codigoMateria = '') {
		$arrayMateria = array();
		$unConvenio = new Co_Convenio();
		$sentencia = "
			SELECT DISTINCT DEPARTAMENTO || MATERIA MATERIA
			FROM MATERIA@NIFE
			WHERE MAT_SEMESTRE IN (
			    SELECT PERIODOSEMESTRE
			    FROM CO_PERIODOACADEMICO
			    WHERE SYSDATE BETWEEN FECHAINICIO AND FECHAFIN
			  )
			  AND DEPARTAMENTO || MATERIA LIKE UPPER('$codigoMateria%')
			ORDER BY 1
		";
		$unConvenio->query($sentencia);
		while ($unConvenio->fetch()) {
			$arrayMateria[$unConvenio->materia] = $unConvenio->materia;
		}
		unset($unConvenio);
		return $arrayMateria;
	}
	
    /**
     * Co_Convenio::cargarNombreMateria()
     * 
     * @param 
     * @return 
     **/
    function cargarNombreMateria($codigoMateria = '', $seccion = '') {
		$arrayMateria = array();
		$unConvenio = new Co_Convenio();
		$sentencia = "
			SELECT DISTINCT NOMBRE
			FROM MATERIA@NIFE
			WHERE MAT_SEMESTRE IN (
			    SELECT PERIODOSEMESTRE
			    FROM CO_PERIODOACADEMICO
			    WHERE SYSDATE BETWEEN FECHAINICIO AND FECHAFIN
			  )
			  AND DEPARTAMENTO || MATERIA = UPPER('$codigoMateria')
  			  AND SECCION = '$seccion'
			ORDER BY 1
		";
		$unConvenio->query($sentencia);
		while ($unConvenio->fetch()) {
			$arrayMateria[$codigoMateria] = $unConvenio->nombre;
		}
		unset($unConvenio);
		return $arrayMateria;
	}
	
    /**
     * Co_Convenio::cargarSecciones()
     * 
     * @param 
     * @return 
     **/
    function cargarSecciones($codigoMateria = '') {
		$arraySeccion = array();
		$unConvenio = new Co_Convenio();
		$sentencia = "
			SELECT DISTINCT SECCION
			FROM MATERIA@NIFE
			WHERE MAT_SEMESTRE IN (
			    SELECT PERIODOSEMESTRE
			    FROM CO_PERIODOACADEMICO
			    WHERE SYSDATE BETWEEN FECHAINICIO AND FECHAFIN
			  )
			  AND DEPARTAMENTO || MATERIA = UPPER('$codigoMateria')
			ORDER BY 1
		";
		$unConvenio->query($sentencia);
		while ($unConvenio->fetch()) {
			$arraySeccion[$unConvenio->seccion] = $unConvenio->seccion;
		}
		unset($unConvenio);
		return $arraySeccion;
	}
	
	/**
     * Co_Convenio::cargarCrn()
     * 
     * @param 
     * @return 
     **/
    function cargarCrn($codigoMateria = '', $seccion = '') {
		$crn = '';
		$unConvenio = new Co_Convenio();
		$sentencia = "
			SELECT DISTINCT CRN
			FROM MATERIA@NIFE
			WHERE MAT_SEMESTRE IN (
			    SELECT PERIODOSEMESTRE
			    FROM CO_PERIODOACADEMICO
			    WHERE SYSDATE BETWEEN FECHAINICIO AND FECHAFIN
			  )
			  AND DEPARTAMENTO || MATERIA = UPPER('$codigoMateria')
			  AND SECCION = '$seccion'
			ORDER BY 1
		";
		$unConvenio->query($sentencia);
		if ($unConvenio->fetch()) {
			$crn = $unConvenio->crn;
		}
		unset($unConvenio);
		return $crn;
	}

	/**
     * Co_Convenio::cargarPeriodoActual()
     * 
     * @param 
     * @return 
     **/
    function cargarPeriodoActual() {
		$unPeriodoAcademico = new Co_PeriodoAcademico();
		$this->periodoActual = $unPeriodoAcademico->cargarPeriodoActual();
		unset($unPeriodoAcademico);
	}

	/**
     * Co_Convenio::cargarPeriodo()
     * 
     * @param 
     * @return 
     **/
    function cargarPeriodo($periodoAcademico) {
		$unPeriodoAcademico = new Co_PeriodoAcademico();
		if ($unPeriodoAcademico->buscar($periodoAcademico)) {
			$this->periodoActual = $unPeriodoAcademico->toArray();
		} else {
			$this->periodoActual = array();
		}
		unset($unPeriodoAcademico);
	}
	
	/**
	 * Co_Convenio::cargarFondoPresupuestal()
	 *
	 * @param
	 * @return
	 **/
	function cargarFondoPresupuestal() {
		global $unSesion;
		$arrayFondoPresupuestal = array();
	
		$sesionFondoPresupuestal = $unSesion->obtenerVariable('fondoPresupuestal');
        
		if ($sesionFondoPresupuestal === false) {
            $unClienteWS = new ClienteWebService();
            $error = false;
            $fondoPresupuestal = $unClienteWS->erpServiceConsultaFondosPresupuestales();

            if ($fondoPresupuestal === false) {
                $error = true;
                $wsFondoPresupuestal = array();
            } else {
                if (isset($fondoPresupuestal->error)) {
                    $wsFondoPresupuestal = array();
                } else {
                    $wsFondoPresupuestal = $fondoPresupuestal;
                }
            }
        }
        if ($error) {
            $arrayFondoPresupuestal = array();
            $this->validacion->acumuladoErrores['cargarFondoPresupuestal'] = 'Se present� un error obteniendo los fondos presupuestales';
        } else {
            foreach ($wsFondoPresupuestal as $vFondoPresupuestal) {
                if(is_array($vFondoPresupuestal)){
                    if (!empty($vFondoPresupuestal['CODIGO'])) {
                        $arrayFondoPresupuestal[$vFondoPresupuestal['CODIGO']] = $vFondoPresupuestal['NOMBRE'];
                    }
                }else{
                    if (!empty($vFondoPresupuestal->CODIGO)) {
                        $arrayFondoPresupuestal[$vFondoPresupuestal->CODIGO] = $vFondoPresupuestal->NOMBRE;
                    }
                }
                
            }
        }
        $this->fondoPresupuestal = $arrayFondoPresupuestal;
	}
	
	/**
     * Co_Convenio::validarValorHora()
     * 
     * @param 
     * @return 
     **/
	function validarValorHora()	{
		$returnValue = true;
		$unTipoMonitor = new DOCo_TipoMonitor();
		$unTipoMonitor->get($this->tipomonitor);
		$unPeriodoAcademico = new Co_PeriodoAcademico();
		$unPeriodoAcademico->buscar($this->periodoacademico);
		if ($this->labor == 'I') {
			if ($unTipoMonitor->minvalorhora > 0 && $unTipoMonitor->maxvalorhora > 0) {
				if ($this->valorhora < $unTipoMonitor->minvalorhora || $this->valorhora > $unTipoMonitor->maxvalorhora) {
					$this->validacion->acumuladoErrores['valorhora'] = 'El valor de la hora no se encuentra en el rango permitido';
					$returnValue = false;
				}
			} else {
				if ($this->valorhora < $unPeriodoAcademico->minvalorhora || $this->valorhora > $unPeriodoAcademico->maxvalorhora) {
					$this->validacion->acumuladoErrores['valorhora'] = 'El valor de la hora no se encuentra en el rango permitido';
					$returnValue = false;
				}
			}
		} else {
			$i = 1;
			foreach ($this->materias as $vMateria) {
				$valorHora = $vMateria['valorhora'];
				if ($unTipoMonitor->minvalorhora > 0 && $unTipoMonitor->maxvalorhora > 0) {
					if ($valorHora < $unTipoMonitor->minvalorhora || $valorHora > $unTipoMonitor->maxvalorhora) {
						$this->validacion->acumuladoErrores['valorhora' . $i] = 'El valor de la hora no se encuentra en el rango permitido';
						$returnValue = false;
					}
				} else {
					if ($valorHora < $unPeriodoAcademico->minvalorhora || $valorHora > $unPeriodoAcademico->maxvalorhora) {
						$this->validacion->acumuladoErrores['valorhora' . $i] = 'El valor de la hora no se encuentra en el rango permitido';
						$returnValue = false;
					}
				}
				$i++;
			}
		}
		return $returnValue;
	}
	
	/**
     * Co_Convenio::validarFechas()
     * 
     * @param 
     * @return 
     **/
	function validarFechas() {
		$returnValue = true;
		$arrFechaInicio = explode('/', $this->fechainicio);
		$numFechaInicio = mktime(0, 0, 0, $arrFechaInicio[1], $arrFechaInicio[0], $arrFechaInicio[2]);
		$arrFechaFin = explode('/', $this->fechafin);
		$numFechaFin = mktime(0, 0, 0, $arrFechaFin[1], $arrFechaFin[0], $arrFechaFin[2]);
		if ($numFechaInicio > $numFechaFin) {
			$this->validacion->acumuladoErrores['fechainicio1'] = 'La fecha de inicio no puede ser mayor a la fecha de finalizaci�n';
			$returnValue = false;
		}
		$unPeriodoAcademico = new Co_PeriodoAcademico();
		$unPeriodoAcademico->buscar($this->periodoacademico);
		$arrFechaInicioPA = explode('/', $unPeriodoAcademico->fechainicio);
		$numFechaInicioPA = mktime(0, 0, 0, $arrFechaInicioPA[1], $arrFechaInicioPA[0], $arrFechaInicioPA[2]);
		$arrFechaFinPA = explode('/', $unPeriodoAcademico->fechafin);
		$numFechaFinPA = mktime(0, 0, 0, $arrFechaFinPA[1], $arrFechaFinPA[0], $arrFechaFinPA[2]);
		if ($numFechaInicio < $numFechaInicioPA || $numFechaInicio > $numFechaFinPA) {
			$this->validacion->acumuladoErrores['fechainicio2'] = 'La fecha de inicio no se encuentra en el rango permitido para el periodo';
			$returnValue = false;
		}
		if ($numFechaFin < $numFechaInicioPA || $numFechaFin > $numFechaFinPA) {
			$this->validacion->acumuladoErrores['fechafin1'] = 'La fecha de finalizaci�n no se encuentra en el rango permitido para el periodo';
			$returnValue = false;
		}
		
		if (!empty($unPeriodoAcademico->fechainicioreceso) && !empty($unPeriodoAcademico->fechafinreceso)) {
			$arrFechaInicioRPA = explode('/', $unPeriodoAcademico->fechainicioreceso);
			$numFechaInicioRPA = mktime(0, 0, 0, $arrFechaInicioRPA[1], $arrFechaInicioRPA[0], $arrFechaInicioRPA[2]);
			$arrFechaFinRPA = explode('/', $unPeriodoAcademico->fechafinreceso);
			$numFechaFinRPA = mktime(0, 0, 0, $arrFechaFinRPA[1], $arrFechaFinRPA[0], $arrFechaFinRPA[2]);
			if ($numFechaInicio >= $numFechaInicioRPA && $numFechaInicio <= $numFechaFinRPA) {
				$this->validacion->acumuladoErrores['fechainicio3'] = 'La fecha de inicio no puede encontrarse en la semana de receso';
				$returnValue = false;
			}
			if ($numFechaFin >= $numFechaInicioRPA && $numFechaFin <= $numFechaFinRPA) {
				$this->validacion->acumuladoErrores['fechafin2'] = 'La fecha de finalizaci�n no puede encontrarse en la semana de receso';
				$returnValue = false;
			}
		}
		return $returnValue;
	}
	
	/**
     * Co_Convenio::validarDependencia()
     * 
     * @param 
     * @return 
     **/
	function validarDependencia() {
		$returnValue = true;
		$arrayDependencia = cargarArregloBD('Co_Dependencia', 'dependencia', 'nombre', 'nombre', " dependenciapadre = '" . $this->dependenciapadre . "' ");
		if (empty($this->dependencia)) {
			if (count($arrayDependencia) > 0) {
				$this->validacion->acumuladoErrores['dependencia'] = 'El departamento no puede ser vacio';
				$returnValue = false;
			} else {
				$this->dependencia = $this->dependenciapadre;
			}
		}
		return $returnValue;
	}
	
	/**
     * Co_Convenio::validarHorasDisponibles()
     * 
     * @param 
     * @return 
     **/
	function validarHorasDisponibles($codigo) {
		$returnValue = true;
		$unEstudiante = new Co_Estudiante();
        $vice = false;
        
		if ($this->labor == 'I') {
            $cursoVice = $this->materias[1000]['curso'];
            if($cursoVice == 'VICE3001' || $cursoVice == 'VICE3002'){
                $vice = true;
            }
			$returnValue = $unEstudiante->tieneHorasDisponibles($this->periodoacademico, $codigo, $this->horassemanales, $this->convenio, $vice);
		} else {
			$horasSemanales = 0;
			foreach ($this->materias as $vMateria) {
				$horasSemanales += $vMateria['horassemanales'];
                if($vMateria['curso'] == 'VICE3001' || $vMateria['curso'] == 'VICE3002'){
                    $vice = true;
                }
			}
			$returnValue = $unEstudiante->tieneHorasDisponibles($this->periodoacademico, $codigo, $horasSemanales, $this->convenio, $vice);
		}
		if (!$returnValue) {
			$erroresEstudiante = $unEstudiante->validacion->getErrores();
			$this->validacion->acumuladoErrores = array_merge($erroresEstudiante, $this->validacion->acumuladoErrores);   
		}
		
		return $returnValue;
	}

	/**
     * Co_Convenio::validarMaterias()
     * 
     * @param 
     * @return 
     **/
	function validarMaterias() {
		$returnValue = true;
		if ($this->labor == 'D') {
			$i = 1;
			foreach ($this->materias as $vMateria) {
				$materia = isset($vMateria['curso'])?$vMateria['curso']:'';
				$valorhora = isset($vMateria['valorhora'])?$vMateria['valorhora']:'';
				$horassemanales = isset($vMateria['horassemanales'])?$vMateria['horassemanales']:'';
				$seccion = isset($vMateria['seccion'])?$vMateria['seccion']:'';
				
				$returnValue = $this->validacion->esCadenaValida($materia, 16, 'Materia #' . $i, true) && $returnValue;
				$returnValue = $this->validacion->esCadenaValida($seccion, 8, 'Seccion #' . $i, true) && $returnValue;
				$returnValue = $this->validacion->esCadenaValida($horassemanales, 8, 'Horas Semanales #' . $i, true) && $returnValue;
				$returnValue = $this->validacion->esCadenaValida($valorhora, 8, 'Valor Hora #' . $i, true) && $returnValue;
				$i++;
			}
			if (count($this->materias) == 0) {
				$this->validacion->acumuladoErrores['curso'] = 'Debe diligenciar m�nimo una materia';
				$returnValue = false;
			}
		} else {
			$materia = isset($this->materias[1000]['curso'])?$this->materias[1000]['curso']:'';
			$seccion = isset($this->materias[1000]['seccion'])?$this->materias[1000]['seccion']:'';
			$returnValue = $this->validacion->esCadenaValida($materia, 16, 'Materia', true) && $returnValue;
			$returnValue = $this->validacion->esCadenaValida($seccion, 8, 'Seccion', true) && $returnValue;
			
			$returnValue = $this->validacion->esCadenaValida($this->horassemanales, 8, 'horassemanales', true) && $returnValue;
			$returnValue = $this->validacion->esCadenaValida($this->valorhora, 8, 'valorhora', true) && $returnValue;
		}
		return $returnValue;
	}
	
	/**
     * Co_Convenio::cargarLabor()
     * 
     * @param 
     * @return 
     **/
	function cargarLabor() {
		$unTipoLabor = new DOCo_TipoLabor();
		$unTipoLabor->get($this->tipolabor);
		$this->labor = $unTipoLabor->labor;
	}
	
	/**
     * Co_Convenio::obtenerConsecutivo()
     * 
     * @param 
     * @return 
     **/
	function obtenerConsecutivo($estudiante) {
		$returnValue = 1;
		$this->estudiante = $estudiante;
		$this->selectAdd();
		$this->selectAdd('MAX(CONSECUTIVO) CONSECUTIVO');
		$this->find(true);
		if ($this->_lastError) {
		    $this->validacion->acumuladoErrores['obtenerConsecutivo'] = 'Se produjo un error obteniendo el consecutivo del estudiante';
			$returnValue = 1;
		} else {
			$returnValue = $this->consecutivo + 1;
		}
		return $returnValue;
	}

    /**
     * Co_Convenio::cargarObjetosCosto()
     * 
     * @param 
     * @return 
     **/
    function cargarObjetosCosto($tipoObjeto = '', $usuario = '') {
    	global $unSesion;
    	$arrayObjetosCosto = array();
    	
    	$modulos = cargarArregloBD('Co_Parametro', 'nombre', 'valor', 'nombre', " nombre = 'WS_OBJETOSCOSTO_MODULOS' ");
    	$arrayModulo = explode(',', $modulos['WS_OBJETOSCOSTO_MODULOS']);
        $sesionObjetosCosto = $unSesion->obtenerVariable('objetosCosto');
    	
       
    	if (empty($sesionObjetosCosto)) {
            $unClienteWS = new ClienteWebService();
            $error = false;
            $errorPI = false;
            foreach ($arrayModulo as $vModulo) {
                $objetosCosto = $unClienteWS->objcostoService($usuario, $vModulo);
                    if ($objetosCosto === false) {
                    
                    //$error = true;
                    $wsObjetosCosto[$vModulo] = array();
                    continue;
                } else {
                    if (isset($objetosCosto['error'])) {
                        $wsObjetosCosto[$vModulo] = array();
                    } else {
                        $wsObjetosCosto[$vModulo] = $objetosCosto;
                    }
                }

            }
          
            if ($error) {
                /*foreach ($arrayModulo as $vModulo) {
                    $objetosCostoPI = $unClienteWS->objetosCosto($usuario, $vModulo);
                    if ($objetosCostoPI === false) {
                        $errorPI = true;
                        $wsObjetosCosto = array();
                        continue;
                    } else {
                        if (is_object($objetosCosto)) {
                            $wsObjetosCosto[$vModulo] = array();
                        } else {
                            $wsObjetosCosto[$vModulo] = $objetosCosto;
                        }
                    }
                }
                if ($errorPI) {
                    $arrayObjetosCosto = false;
                    $this->validacion->acumuladoErrores['cargarObjetosCosto'] = 'Se presento un error obteniendo los objetos de costo';
                } else {
                    foreach ($wsObjetosCosto as $vObjetosCostoModulo) {
                        foreach ($vObjetosCostoModulo as $vObjetosCosto) {
                            if ($vObjetosCosto->Estado == 'A') {
                                $arrayObjetosCosto[$vObjetosCosto->Tipo_objeto][$vObjetosCosto->Obj_costo] = $vObjetosCosto->Descripcion;
                            }
                        }
                    }
                }*/
            } else {
                foreach ($wsObjetosCosto as $vObjetosCostoModulo) {
                    if(isset($vObjetosCostoModulo['ESTADO']) && $vObjetosCostoModulo['ESTADO'] == 'A'){
                        $arrayObjetosCosto[$vObjetosCostoModulo['TIPO_OBJETO']][$vObjetosCostoModulo['OBJETO_COSTO']] = $vObjetosCostoModulo['DESCRIPCION'];
                    }else{

                        foreach ($vObjetosCostoModulo as $vObjetosCosto) {

                            if(is_array($vObjetosCosto)){
                                if ($vObjetosCosto['ESTADO'] == 'A') {
                                    $arrayObjetosCosto[$vObjetosCosto['TIPO_OBJETO']][$vObjetosCosto['OBJETO_COSTO']] = $vObjetosCosto['DESCRIPCION'];
                                }
                            }else{
                                if ($vObjetosCosto->ESTADO == 'A') {
                                    $arrayObjetosCosto[$vObjetosCosto->TIPO_OBJETO][$vObjetosCosto->OBJETO_COSTO] = $vObjetosCosto->DESCRIPCION;
                                }
                            }
                            
                        }
                    }
                }
            }
    		if ($errorPI) {
    			$returnObjetosCosto = false;
    		} else {
    			$unSesion->registrarVariable('objetosCosto', $arrayObjetosCosto);
    			$returnObjetosCosto = isset($arrayObjetosCosto[$tipoObjeto])?$arrayObjetosCosto[$tipoObjeto]:array();
    		}
    	} else {
    		$returnObjetosCosto = isset($sesionObjetosCosto[$tipoObjeto])?$sesionObjetosCosto[$tipoObjeto]:array();
    	}
    	return $returnObjetosCosto;
	}
	
	/**
     * Co_Convenio::validarDistribucion()
     * 
     * @param 
     * @return 
     **/
	function validarDistribucion() {
		$returnValue = true;
		$porcentaje = 0;
		$i = 1;
		foreach ($this->distribucion as $vDistribucion) {
			$returnValue = $this->validacion->esCadenaValida($vDistribucion['tipoobjeto'], 8, 'Tipo Objeto #' . $i, true) && $returnValue;
			$objetocosto = isset($vDistribucion['objetocosto'])?$vDistribucion['objetocosto']:'';
			$returnValue = $this->validacion->esCadenaValida($objetocosto, 128, 'Objeto Costo #' . $i, true) && $returnValue;
			$returnValue = $this->validacion->esCadenaValida($vDistribucion['fondopresupuestal'], 64, 'Fondo Presupuestal #' . $i, true) && $returnValue;
			$returnValue = $this->validacion->esCadenaValida($vDistribucion['porcentaje'], 8, 'Porcentaje #' . $i, 'Porcentaje #' . $i, true) && $returnValue;
			$porcentaje += (empty($vDistribucion['porcentaje'])?0:$vDistribucion['porcentaje']);
			$i++;
		}
		if (count($this->distribucion) > 0) {
			if ($porcentaje != 100) {
				$this->validacion->acumuladoErrores['distribucion'] = 'La sumatoria de los porcentajes debe ser 100%';
				$returnValue = false;
			}
		} else {
			$this->validacion->acumuladoErrores['distribucion'] = 'Debe diligenciar m�nimo un registro para la distribuci�n de costos';
			$returnValue = false;
		}
		return $returnValue;
	}

	/**
     * Co_Convenio::validarPlanPagos()
     * 
     * @param 
     * @return 
     **/
	function validarPlanPagos() {
		$returnValue = true;
		$planpagos = isset($this->planPagos['planpagos'])?$this->planPagos['planpagos']:'';
		$valor = isset($this->planPagos['valor'])?$this->planPagos['valor']:'';
		
		$returnValue = $this->validacion->esCadenaValida($planpagos, 8, 'planpagos', true) && $returnValue;
		$returnValue = $this->validacion->esCadenaValida($valor, 16, 'valor', true) && $returnValue;
		return $returnValue;
	}

	/**
     * Co_Convenio::validarCuenta()
     * 
     * @param 
     * @return 
     **/
	function validarCuenta() {
		$returnValue = true;
		$tipocuenta = isset($this->cuenta['tipocuenta'])?$this->cuenta['tipocuenta']:'';
		$banco = isset($this->cuenta['banco'])?$this->cuenta['banco']:'';
		$numerocuenta = isset($this->cuenta['numerocuenta'])?$this->cuenta['numerocuenta']:'';

		$returnValue = $this->validacion->esCadenaValida($tipocuenta, 8, 'tipocuenta', true) && $returnValue;
		$returnValue = $this->validacion->esCadenaValida($banco, 8, 'banco', true) && $returnValue;
		$returnValue = $this->validacion->esCadenaValida($numerocuenta, 24, 'numerocuenta', true) && $returnValue;
		return $returnValue;
	}
	/**
     * Co_Convenio::calcularValorConvenio()
     * 
     * @param 
     * @return 
     **/
	function calcularValorConvenio() {
		$fechaInicio = $this->fechainicio;
		$fechaFin = $this->fechafin;
		$fechaInicioR = $this->periodoActual['fechainicioreceso'];
		$fechaFinR = $this->periodoActual['fechafinreceso'];
		
		$arrayFechaInicio = explode("/", $fechaInicio);
		$numFechaInicio = mktime(0, 0, 0, $arrayFechaInicio[1], $arrayFechaInicio[0], $arrayFechaInicio[2]);
		$arrayFechaFin = explode("/", $fechaFin);
		$numFechaFin = mktime(0, 0, 0, $arrayFechaFin[1], $arrayFechaFin[0], $arrayFechaFin[2]);
		$totalDias = floor(($numFechaFin - $numFechaInicio)/(60 * 60 * 24)) + 1;			
		$numSemanas = round(($totalDias / 7), 2);

		$numSemanasR = 0;
		if (!empty($fechaInicioR) && !empty($fechaFinR)) {
			$arrayFechaInicioR = explode("/", $fechaInicioR);
			$numFechaInicioR = mktime(0, 0, 0, $arrayFechaInicioR[1], $arrayFechaInicioR[0], $arrayFechaInicioR[2]);
			$arrayFechaFinR = explode("/", $fechaFinR);
			$numFechaFinR = mktime(0, 0, 0, $arrayFechaFinR[1], $arrayFechaFinR[0], $arrayFechaFinR[2]);
			if ($numFechaInicioR >= $numFechaInicio && $numFechaInicioR <= $numFechaFinR && $numFechaFinR <= $numFechaFin) {
            //if ($numFechaInicioR >= $numFechaInicio && $numFechaInicioR <= $numFechaFinR) {
				$totalDiasR = floor(($numFechaFinR - $numFechaInicioR)/(60 * 60 * 24)) + 1;
				$numSemanasR = round(($totalDiasR / 7), 2);

			}
		}
		
		$totalSemanas = abs(round(($numSemanas - $numSemanasR), 2));
		
		$horasSemanales = 0;
		$valorHora = 0;
		$valorSemana = 0;
		
		$unTipoLabor = new DOCo_TipoLabor();
		
		//$unTipoLabor->get($this->tipolabor);
		$sentencia = "SELECT * FROM co_tipolabor WHERE tipolabor = '".$this->tipolabor."'";
		$unTipoLabor->query($sentencia);
		$unTipoLabor->fetch();
		/*if($unTipoLabor->fetch()){
			echo $unTipoLabor->labor;
		}*/
		/*$unConvenio->query($sentencia);
		if ($unConvenio->fetch()) {
			$crn = $unConvenio->crn;
		}
		unset($unConvenio);*/
		//echo '<pre>'; print_r($unTipoLabor);exit;
		if(!$unTipoLabor->labor){
			
			/*echo '<pre>'; print_r($unTipoLabor);
			echo '<br>'.$this->tipolabor;
			echo '<br>'.$unTipoLabor->labor;
			exit;*/
		}
		
		if ($unTipoLabor->labor == 'I') {
			$horasSemanales = $this->horassemanales;
			$valorHora = $this->valorhora;
			$valorSemana = $horasSemanales * $valorHora;
		} else {
			foreach ($this->materias as $vMateria) {
				$horasSemanales += $vMateria['horassemanales'];
				$valorHora += $vMateria['valorhora'];
				$valorSemana += $vMateria['horassemanales'] * $vMateria['valorhora'];
			}
		}
		$valorFinal = intval(round(($valorSemana * $totalSemanas), 0));
		
		$unTipoLabor->free();
		return $valorFinal;
	}

	/**
	 * Co_Convenio::cargarPlanPagosPorPeriodoAcedmico()
	 *
	 * Carga la lista de planes de pago
	 *
	 * @param
	 * @return
	 **/
	function cargarPlanPagosPorPeriodoAcademico($periodoAcademico) {
		$planPagos = array();
		$unPlanPagos = new Co_PlanPagos();
		$unPlanPagos->buscarPorPeriodoAcademico($periodoAcademico);
		
		while ($unPlanPagos->fetch()) {
			$planPagos[$unPlanPagos->planpagos] = $unPlanPagos->nombre;
		}
		return $planPagos;
	}
	
	/**
	 * Co_Convenio::cargarPorcentajePagosPorPlanPagos()
	 *
	 * Carga la lista de porcentajes de pago
	 *
	 * @param
	 * @return
	 **/
	function cargarPorcentajePagosPorPlanPagos($planPagos) {
		$porcentajesPagos = array();
		$unPorcentajePagos = new DOCo_PorcentajePagos();
		$unPorcentajePagos->planpagos = $planPagos;
		$unPorcentajePagos->orderBy('posicion');
		$unPorcentajePagos->find();
		
		while ($unPorcentajePagos->fetch()) {
			$porcentajesPagos[$unPorcentajePagos->porcentajepagos] = $unPorcentajePagos->posicion;
		}
		return $porcentajesPagos;
	}
	
	/**
	 * Co_Convenio::consultarPagoConvenios()
	 *
	 * Extrae los datos del convenio y calcula el valor que se debe reportar
	 *
	 * @param
	 * @return
	 **/
	function consultarPagoConvenios($periodoacademico, $porcentajepagos, $estadoActual) {
		$sentencia = "
			SELECT DISTINCT
			  C.CONVENIO, 
			  E.DOCUMENTO, 
			  (P.VALOR * (D.PORCENTAJE / 100)) VALOR,
			  D.OBJETOCOSTO,
			  D.FONDOPRESUPUESTAL,
			  TM.NOMBRE TIPOMONITOR,
			  P.PAGO
			FROM 
			  CO_ESTUDIANTE E, 
			  CO_CONVENIO C, 
			  CO_PAGO P, 
			  CO_DISTRIBUCION D, 
			  CO_TIPOMONITOR TM
			WHERE E.ESTUDIANTE = C.ESTUDIANTE
			  AND C.CONVENIO = P.CONVENIO
			  AND C.CONVENIO = D.CONVENIO
			  AND TM.TIPOMONITOR = C.TIPOMONITOR
			  AND C.ESTADO IN ($estadoActual)
			  AND C.PERIODOACADEMICO = $periodoacademico
			  AND P.PORCENTAJEPAGOS in ($porcentajepagos)
		";
		$this->query($sentencia);
	}

	/**
	 * Co_Convenio::cambiarEstadoPagoConvenios()
	 *
	 * Cambia el estado de los convenios seg�n el corte
	 *
	 * @param
	 * @return
	 **/
	function cambiarEstadoPagoConvenios($periodoacademico, $porcentajepagos, $estadoActual, $estadoSiguiente) {
		$returnValue = true;
		$sentencia = "
			UPDATE CO_CONVENIO
			SET ESTADO = $estadoSiguiente
			WHERE CONVENIO IN (
			    SELECT DISTINCT
			      C.CONVENIO 
			    FROM 
			      CO_CONVENIO C, 
			      CO_PAGO P
			    WHERE C.CONVENIO = P.CONVENIO
			      AND C.ESTADO IN ($estadoActual)
			      AND C.PERIODOACADEMICO = $periodoacademico
			      AND P.PORCENTAJEPAGOS in ($porcentajepagos)
			  )
		";
		$unConvenio = new Co_Convenio();
		$unConvenio->query($sentencia);
		$unConvenio->query($sentencia);
		if ($unConvenio->_lastError) {
			$this->validacion->acumuladoErrores['cambiarEstadoPagoConvenios'] = 'Se produjo un error cambiando el estado de las monitorias';
			$returnValue = false;
		}
		return $returnValue;
	}
	
	/**
	 * Co_Convenio::consultarPagoConvenios()
	 *
	 * Extrae los datos del convenio y calcula el valor que se debe reportar
	 *
	 * @param
	 * @return
	 **/
	function consultarCuentaEstudiante($periodoacademico, $porcentajepagos) {
		$sentencia = "
			SELECT DISTINCT
			  E.DOCUMENTO, 
			  B.PAIS,
			  B.BANCO,
			  T.NUMEROCUENTA CUENTA,
			  E.NOMBRES || ' ' || E.APELLIDOS TITULAR,
			  T.TIPOCUENTA
			FROM 
			  CO_ESTUDIANTE E,
			  CO_CONVENIO C,
			  CO_PAGO P,
			  CO_CUENTA T,
			  CO_BANCO B
			WHERE E.ESTUDIANTE = C.ESTUDIANTE
			  AND C.CONVENIO = P.CONVENIO
			  AND E.ESTUDIANTE = T.ESTUDIANTE
			  AND T.BANCO = B.BANCO
			  AND C.PERIODOACADEMICO = $periodoacademico
			  AND P.PORCENTAJEPAGOS in ($porcentajepagos)
		";
		$this->query($sentencia);
	}
	
	/**
	 * Co_Convenio::cambiarEstado()
	 *
	 * Modifica varios convenios con el estado definido por el usuario
	 *
	 * @param
	 * @return
	 **/
	function cambiarEstado($convenios, $estado) {
		$txtConvenios = implode(',', $convenios);
		$sentencia = "
			UPDATE CO_CONVENIO
			SET ESTADO = '$estado'
			WHERE CONVENIO IN ($txtConvenios)
		";
		$result = $this->query($sentencia);
		if (DB::isError($result)) {
			return false;
		}
		return true;
	}
	
	/**
	 * Co_Convenio::obtenerEstudiante()
	 *
	 * @param
	 * @return
	 **/
	function obtenerEstudiante($convenio) {
		$arrayEstudiante = array();
		$sentencia = "
			SELECT DISTINCT E.*
			FROM CO_ESTUDIANTE E, CO_CONVENIO C
			WHERE E.ESTUDIANTE = C.ESTUDIANTE
			AND C.CONVENIO = $convenio
		";
		$unEstudiante = new Co_Estudiante();
		$unEstudiante->query($sentencia);
		if ($unEstudiante->fetch()) {
			$arrayEstudiante = $unEstudiante->toArray();
		}
		return $arrayEstudiante;
	}
	
	/**
	 * Co_Convenio::cargarInformacionPDF()
	 *
	 * @param
	 * @return
	 */
	function cargarInformacionPDF($convenios = array()) {
		global $estadoConvenioMostrarPDF;
		$condicion = "";
		$condicionMostrarPDF = "";
		
		if (count($estadoConvenioMostrarPDF) > 0) {
			$condicionMostrarPDF = " AND C.ESTADO IN ('" . implode("','", $estadoConvenioMostrarPDF) . "')";
		}
		if (is_array($convenios) && count($convenios) > 0) {
			$txtConvenios = implode(',', $convenios);
			$condicion = " AND C.CONVENIO IN ($txtConvenios) ";
		}

		$sentencia = "
			SELECT DISTINCT
			  C.CONVENIO, 
			  C.PERIODOACADEMICO, 
			  C.CONSECUTIVO,
			  E.APELLIDOS,
			  E.NOMBRES,
			  E.CODIGO,
			  TD.NOMBRE TIPODOCUMENTO,
			  E.DOCUMENTO,
			  E.EXPEDICIONDOC,
			  E.DIRECCION,
			  E.TELEFONO,
			  GC.NOMBRE CIUDAD,
			  GD.NOMBRE DEPARTAMENTO,
			  GP.NOMBRE PAIS,
			  TL.DESCRIPCION ACTIVIDAD,
			  TL.LABOR LABOR,
			  PL.NOMBRE DISTRIBUCION,
			  C.VALORHORA,
			  C.HORASSEMANALES,
			  C.DESCRIPCION,
			  C.FECHAINICIO,
			  C.FECHAFIN,
			  B.NOMBRE BANCO,
			  CU.TIPOCUENTA,
			  CU.NUMEROCUENTA,
			  D.NOMBRE DEPENDENCIA,
			  DP.NOMBRE DEPENDENCIAPADRE,
			  M.CURSO,
			  M.NOMBRE NOMBRECURSO,
			  M.VALORHORA VALORHORACURSO,
			  M.HORASSEMANALES HORASSEMANALESCURSO
			FROM CO_ESTUDIANTE E, 
			  CO_CONVENIO C, 
			  G_TIPODOCUMENTO TD,
			  G_CIUDAD GC,
			  G_DEPARTAMENTO GD,
			  G_PAIS GP,
			  CO_TIPOLABOR TL,
			  CO_PAGO P,
			  CO_PORCENTAJEPAGOS PP,
			  CO_PLANPAGOS PL,
			  CO_CUENTA CU,
			  CO_BANCO B,
			  CO_DEPENDENCIA D,
			  CO_DEPENDENCIA DP,
			  CO_MATERIA M
			WHERE E.ESTUDIANTE = C.ESTUDIANTE
			  AND E.TIPODOCUMENTO = TD.TIPODOCUMENTO
			  AND E.CIUDAD = GC.CIUDAD
			  AND E.DEPARTAMENTO = GD.DEPARTAMENTO
			  AND E.PAIS = GP.PAIS
			  AND GD.PAIS = GP.PAIS
			  AND GC.DEPARTAMENTO = GD.DEPARTAMENTO
			  AND C.TIPOLABOR = TL.TIPOLABOR
			  AND C.CONVENIO = P.CONVENIO
			  AND P.PORCENTAJEPAGOS = PP.PORCENTAJEPAGOS
			  AND PP.PLANPAGOS = PL.PLANPAGOS
			  AND E.ESTUDIANTE = CU.ESTUDIANTE
			  AND CU.BANCO = B.BANCO
			  AND C.DEPENDENCIA = D.DEPENDENCIA
			  AND D.DEPENDENCIAPADRE = DP.DEPENDENCIA (+)
			  AND C.CONVENIO = M.CONVENIO (+)
			  $condicion
			  $condicionMostrarPDF
			ORDER BY E.APELLIDOS, C.CONVENIO
		";
		$unInformacion = new DB_DataObject();
		$unInformacion->query($sentencia);
	
		$informacion = array();
		$convenioActual = '';
		$i = -1;
		while ($unInformacion->fetch()) {
			if ($convenioActual != $unInformacion->convenio) {
				$unConvenio = new Co_Convenio();
				$unConvenio->cargarPeriodo($unInformacion->periodoacademico);
				$unConvenio->buscar($unInformacion->convenio);
				$unConvenio->buscarMateriaPorConvenio($unInformacion->convenio);
				$valor = $unConvenio->calcularValorConvenio();
				$i++;
				$informacion[$i] = array(
					'convenio' => $unInformacion->convenio,
					'periodoacademico' => $unInformacion->periodoacademico,
					'consecutivo' => $unInformacion->consecutivo,
					'documento' => $unInformacion->documento,
					'apellidos' => $unInformacion->apellidos,
					'nombres' => $unInformacion->nombres,
					'codigo' => $unInformacion->codigo,
					'tipodocumento' => $unInformacion->tipodocumento,
					'documento' => $unInformacion->documento,
					'expediciondoc' => $unInformacion->expediciondoc,
					'direccion' => $unInformacion->direccion,
					'telefono' => $unInformacion->telefono,
					'ciudad' => $unInformacion->ciudad,
					'departamento' => $unInformacion->departamento,
					'pais' => $unInformacion->pais,
					'actividad' => $unInformacion->actividad,
					'labor' => $unInformacion->labor,
					'distribucion' => $unInformacion->distribucion,
					'valorhora' => $unInformacion->valorhora,
					'horassemanales' => $unInformacion->horassemanales,
					'descripcion' => $unInformacion->descripcion,
					'fechainicio' => $unInformacion->fechainicio,
					'fechafin' => $unInformacion->fechafin,
					'banco' => $unInformacion->banco,
					'valor' => $valor,
					'tipocuenta' => $unInformacion->tipocuenta,
					'numerocuenta' => $unInformacion->numerocuenta,
					'dependencia' => $unInformacion->dependencia,
					'dependenciapadre' => $unInformacion->dependenciapadre,
					'materia' => array()
				);
				$unConvenio->buscarPagosPorConvenio($unInformacion->convenio);
				foreach ($unConvenio->pagos as $pago) {
					$informacion[$i]['pago'][] = PREFIJO . $unInformacion->convenio . $pago;
				}
				unset($unConvenio);
				$convenioActual = $unInformacion->convenio;
			}
			$informacion[$i]['materia'][] = array(
				'curso' => $unInformacion->curso,
				'nombrecurso' => $unInformacion->nombrecurso,
				'valorhoracurso' => $unInformacion->valorhoracurso,
				'horassemanalescurso' => $unInformacion->horassemanalescurso
			);
		}
		return $informacion;
	}

	/**
	 * Co_Convenio::cargarInformacionPDF()
	 *
	 * @param
	 * @return
	 */
	function cargarInformacionExcel($filtros = array()) {
		$condicion = "";
		
		$filtroPeriodoAcademico = $filtros['filtroPeriodoAcademico'];
		if (!empty($filtroPeriodoAcademico)) {
			$condicion .= " AND C.PERIODOACADEMICO = " . $filtroPeriodoAcademico;
		}
		
		$filtroDependencia = $filtros['filtroDependencia'];
		if (!empty($filtroDependencia)) {
			$condicion .= " AND (D.DEPENDENCIA = '" . $filtroDependencia . "' OR D.DEPENDENCIAPADRE = '" . $filtroDependencia . "') ";
		}
	
		$filtroEstado = $filtros['filtroEstado'];
		if (!empty($filtroEstado)) {
			$condicion .= " AND C.ESTADO = '" . $filtroEstado . "' ";
		}

		$filtroCodigo = $filtros['filtroCodigo'];
		if (!empty($filtroCodigo)) {
			$condicion .= " AND E.CODIGO = '" . $filtroCodigo . "' ";
		}
		
		$sentencia = "
			SELECT DISTINCT
			  C.CONVENIO,
			  C.PERIODOACADEMICO,
			  C.CONSECUTIVO,
			  E.APELLIDOS,
			  E.NOMBRES,
			  E.CODIGO,
			  E.DOCUMENTO,
			  TL.TIPOLABOR CODLABOR,
			  TL.LABOR TIPOLABOR,
			  TL.NOMBRE LABOR,
			  PL.NOMBRE DISTRIBUCION,
			  C.VALORHORA,
			  C.HORASSEMANALES,
			  C.DESCRIPCION,
			  C.FECHAINICIO,
			  C.FECHAFIN,
			  M.CURSO,
			  M.NOMBRE NOMBRECURSO,
			  M.VALORHORA VALORHORACURSO,
			  M.HORASSEMANALES HORASSEMANALESCURSO,
			  D.NOMBRE NOMBREDEPENDENCIA
			FROM CO_ESTUDIANTE E, 
			  CO_CONVENIO C, 
			  CO_DEPENDENCIA D, 
			  CO_TIPOLABOR TL,
			  CO_PAGO P,
			  CO_PORCENTAJEPAGOS PP,
			  CO_PLANPAGOS PL,
			  CO_MATERIA M
			WHERE E.ESTUDIANTE = C.ESTUDIANTE
			  AND C.DEPENDENCIA = D.DEPENDENCIA
			  AND C.TIPOLABOR = TL.TIPOLABOR
			  AND C.CONVENIO = P.CONVENIO
			  AND P.PORCENTAJEPAGOS = PP.PORCENTAJEPAGOS
			  AND PP.PLANPAGOS = PL.PLANPAGOS
			  AND C.CONVENIO = M.CONVENIO (+)
			  $condicion
			ORDER BY C.CONVENIO, M.CURSO
		";
		//echo '<pre>';print_r($sentencia); exit;
		$unInformacion = new DB_DataObject();
		$unInformacion->query($sentencia);
	
		$informacion = array();
		$convenioActual = '';
		$i = -1;
		while ($unInformacion->fetch()) {
			if ($convenioActual != $unInformacion->convenio) {
				$unConvenio = new Co_Convenio();
				if (empty($this->periodoActual)) {
					$unConvenio->cargarPeriodo($unInformacion->periodoacademico);
					$this->periodoActual = $unConvenio->periodoActual;
				} else {
					$unConvenio->periodoActual = $this->periodoActual;
				}
//				$unConvenio->periodoActual = $this->periodoActual;
//				$unConvenio->cargarPeriodo($unInformacion->periodoacademico);
//				$unConvenio->buscar($unInformacion->convenio);
				$unConvenio->fechainicio = $unInformacion->fechainicio;
				$unConvenio->fechafin = $unInformacion->fechafin;
				$unConvenio->tipolabor = $unInformacion->codlabor;
				$unConvenio->valorhora = $unInformacion->valorhora;
				$unConvenio->horassemanales = $unInformacion->horassemanales;
				$unConvenio->buscarMateriaPorConvenio($unInformacion->convenio);
				$valor = $unConvenio->calcularValorConvenio();
				$i++;
				$informacion[$i] = array(
					'convenio' => $unInformacion->convenio,
					'periodoacademico' => $unInformacion->periodoacademico,
					'consecutivo' => $unInformacion->consecutivo,
					'apellidos' => $unInformacion->apellidos,
					'nombres' => $unInformacion->nombres,
					'codigo' => $unInformacion->codigo,
					'documento' => $unInformacion->documento,
					'tipolabor' => $unInformacion->tipolabor,
					'labor' => $unInformacion->labor,
					'nombredependencia' => $unInformacion->nombredependencia,
					'distribucion' => $unInformacion->distribucion,
					'valorhora' => $unInformacion->valorhora,
					'horassemanales' => $unInformacion->horassemanales,
					'descripcion' => $unInformacion->descripcion,
					'fechainicio' => $unInformacion->fechainicio,
					'fechafin' => $unInformacion->fechafin,
					'valor' => $valor,
					'materia' => array()
				);
				unset($unConvenio);
				$convenioActual = $unInformacion->convenio;
			}
			$informacion[$i]['materia'][] = array(
				'curso' => $unInformacion->curso,
				'nombrecurso' => $unInformacion->nombrecurso,
				'valorhoracurso' => $unInformacion->valorhoracurso,
				'horassemanalescurso' => $unInformacion->horassemanalescurso
			);
		}
		return $informacion;
	}
	
} // end Co_Convenio
?>