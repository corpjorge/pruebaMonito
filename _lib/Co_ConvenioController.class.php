<?php

require_once("Co_Convenio.class.php");
require_once("Co_ConvenioView.class.php");

require_once("Co_EstudianteController.class.php");
require_once("ReporteCsv.class.php");
require_once("ReporteExcel.class.php");

/*
 * Co_ConvenioController
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_ConvenioController {
    var $model;
    var $view;
    var $_interfaz;

    /**
     * Co_ConvenioController::Co_ConvenioController()
     * 
     * @return 
     */
    function Co_ConvenioController () {
        $this->model = &new Co_Convenio();
    } 

    /**
     * Co_ConvenioController::_Co_ConvenioController()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_ConvenioController () {
    } 

    /**
     * Co_ConvenioController::getView()
     * 
     * Método que obtiene la clase de vista a desplegar
     * 
     * @return 
     */
    function &getView () {
        return $this->view;
    }

    function setView (& $view) {
        $this->view =& $view;
    } 
    
} // end Co_ConvenioController

/**
 * Co_ConvenioItemController
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 */
class Co_ConvenioItemController extends Co_ConvenioController {

	/**
     * Co_ConvenioItemController::Co_ConvenioItemController()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_ConvenioItemController () {
        Co_ConvenioController::Co_ConvenioController();
        $this->view = &new Co_ConvenioItemView($this->model);
    } 

    /**
     * Co_ConvenioItemController::_Co_ConvenioItemController()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_ConvenioItemController () {
    } 

	/**
     * Co_ConvenioItemController::usrConsultarConvenio()
     * 
	 * Prepara la forma 
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function usrConsultarConvenio($arregloCampos) {
		global $unSesion;
		$convenio = isset($arregloCampos['convenio'])?$arregloCampos['convenio']:'';
		$unConvenio = new Co_Convenio();
		$unConvenio->buscar($convenio);
		$arrayEstudiante = $this->model->obtenerEstudiante($convenio);
		$unEstudianteController = new Co_EstudianteItemController();
		$unSesion->registrarVariable('periodoacademico', $unConvenio->periodoacademico);
		$datosBasicos = $unEstudianteController->cargarInformacionEstudiante($arrayEstudiante);
		$informacionEstudiante = $unEstudianteController->mostrarInformacionEstudiante($datosBasicos);
		
		$this->cargarInformacionConvenio($arregloCampos);
		$this->model->estado = '';
		$this->mostrarInformacionConvenio($informacionEstudiante);
	}

	/**
     * Co_ConvenioItemController::usrSolicitarConvenio()
     * 
	 * Permite al usuario mostrar el formulario para solicitar convenios 
	 * 
     * @param $arregloCampos
     * @return
     **/
	function usrSolicitarConvenio($arregloCampos) {
		global $unSesion;
		$usuario = $unSesion->obtenerVariable('usuario');
		$accion = (isset($arregloCampos['accion']) && !empty($arregloCampos['accion']))?$arregloCampos['accion']:'mostrarValidacionEstudiante'; 

		switch ($accion) {
			case 'mostrarValidacionEstudiante':
				$unEstudianteController = new Co_EstudianteItemController();
				$unEstudianteController->mostrarValidacionEstudiante($arregloCampos);
				$this->setView($unEstudianteController->getView());
			break;
			case 'validarEstudiante':
				$unEstudianteController = new Co_EstudianteItemController();
				if ($unEstudianteController->validarEstudiante($arregloCampos)) {
					$unSesion->registrarVariable('periodoacademico', $unEstudianteController->model->periodoActual['periodoacademico']);
					$datosBasicos = $unEstudianteController->cargarInformacionEstudiante($arregloCampos);
					$_SESSION['periodonombre']	= $unEstudianteController->model->periodoActual['periodosemestre'];
					$informacionEstudiante = $unEstudianteController->mostrarInformacionEstudiante($datosBasicos);
					$this->model->estudiante = isset($datosBasicos['estudiante'])?$datosBasicos['estudiante']:'';
					$this->cargarInformacionConvenio($arregloCampos);
					$this->mostrarInformacionConvenio($informacionEstudiante);
				} else {
					$this->setView($unEstudianteController->getView());
				}
			break;
			case 'solicitarConvenio':
				$convenioValido = TRUE;
				$tipomonitor	=	$arregloCampos['convenio']['tipomonitor'];
				$materia 		=	$arregloCampos['materias']['1000']['curso'];
				$estudiante = (isset($arregloCampos['estudiante']) && !empty($arregloCampos['estudiante']))?$arregloCampos['estudiante']:array();

				$unEstudianteController = new Co_EstudianteItemController();
				//validar primer semestre
				if ($tipomonitor != "109" && ($materia != "VICE3001") && ($materia != "VICE3002") ){		
					$esprimiparo = $unEstudianteController->model->esEstudianteEnPruebaAcademicaValidar($arregloCampos['estudiante']['codigo']);
					if ($esprimiparo){
						$convenioValido = FALSE;
						$this->view->usrMensaje('No es posible crear la monitoria debido a que el estudiante esta en primer semestre');
						break;	
					}
				}
				if ($this->validarConvenio($arregloCampos)) {
					if ($unEstudianteController->insertarEstudiante($estudiante)) {
						$this->model->estudiante = $unEstudianteController->model->estudiante;
						$this->model->usuariocreacion = $usuario['nombreusuario'];
						if ($this->model->insertarConvenio()) {
							if ($this->model->insertarMaterias()) {
								if ($this->model->insertarDistribucion()) {
									$this->model->planPagos['valor'] = $this->model->calcularValorConvenio();
									if ($this->model->insertarPagos()) {
										$unConvenio = new Co_Convenio();
										$unConvenio->buscarCuentaPorEstudiante($this->model->estudiante);
										if (count($unConvenio->cuenta) > 0) {
											if ($this->model->cuenta['tipocuenta'] != $unConvenio->cuenta['tipocuenta'] 
												|| $this->model->cuenta['numerocuenta'] != $unConvenio->cuenta['numerocuenta']
												|| $this->model->cuenta['banco'] != $unConvenio->cuenta['banco']
											) {
												$this->model->eliminarCuentaPorEstudiante($this->model->estudiante);
												if (!$this->model->insertarCuenta()) {
													$convenioValido = FALSE;
												}
											}
										}
									} else {
										$convenioValido = FALSE;
									}
								} else {
									$convenioValido = FALSE;
								}
							} else {
								$convenioValido = FALSE;
							}
						} else {
							$convenioValido = FALSE;
						}
						if (!$convenioValido && !empty($this->model->convenio)) {
							$this->model->eliminarConvenio($this->model->convenio);
						}
					} else {
						$erroresEstudiante = $unEstudianteController->model->validacion->getErrores();
						$this->model->validacion->acumuladoErrores = array_merge($erroresEstudiante, $this->model->validacion->acumuladoErrores);
						$convenioValido = FALSE;
					}
				} else {
					$unEstudianteController->model->asignar($estudiante);
					$convenioValido = FALSE;
				}
				if ($convenioValido) {
					$this->view->usrMensaje('La monitoria fue creada exitosamente');
				} else {
					$informacionEstudiante = $unEstudianteController->mostrarInformacionEstudiante(FALSE);
					$this->cargarInformacionConvenio($arregloCampos);
					$this->mostrarInformacionConvenio($informacionEstudiante);
				}
				
			break;
		}
		
	}

	/**
	 * Co_ConvenioItemController::usrActualizarConvenio()
	 *
	 * Permite al usuario mostrar el formulario para solicitar convenios
	 *
	 * @param $arregloCampos
	 * @return
	 **/
	function usrActualizarConvenio($arregloCampos) {
		global $unSesion;

		$accion = (isset($arregloCampos['accion']) && !empty($arregloCampos['accion']))?$arregloCampos['accion']:'mostrarValidacionEstudiante';
		switch ($accion) {
			case 'mostrarConvenio':
				$convenio = isset($arregloCampos['convenio'])?$arregloCampos['convenio']:'';
				$unConvenio = new Co_Convenio();
				$unConvenio->buscar($convenio);
				$arrayEstudiante = $this->model->obtenerEstudiante($convenio);
				$unEstudianteController = new Co_EstudianteItemController();
				$unSesion->registrarVariable('periodoacademico', $unConvenio->periodoacademico);
				$datosBasicos = $unEstudianteController->cargarInformacionEstudiante($arrayEstudiante);
				$informacionEstudiante = $unEstudianteController->mostrarInformacionEstudiante($datosBasicos);

				$this->cargarInformacionConvenio($arregloCampos);
				$this->mostrarInformacionConvenio($informacionEstudiante);
				break;
			case 'actualizarConvenio':
				$convenioValido = TRUE;
				$estudiante = (isset($arregloCampos['estudiante']) && !empty($arregloCampos['estudiante']))?$arregloCampos['estudiante']:array();
				$unEstudianteController = new Co_EstudianteItemController();
				if ($this->validarConvenio($arregloCampos)) {
					if ($unEstudianteController->insertarEstudiante($estudiante)) {
						if ($this->model->actualizar()) {
							if ($this->model->eliminarMateriaPorConvenio($this->model->convenio) && $this->model->insertarMaterias()) {
								if ($this->model->eliminarDistribucionPorConvenio($this->model->convenio) && $this->model->insertarDistribucion()) {
									$this->model->planPagos['valor'] = $this->model->calcularValorConvenio();
									if ($this->model->eliminarPagoPorConvenio($this->model->convenio) && $this->model->insertarPagos()) {
										$unConvenio = new Co_Convenio();
										$unConvenio->buscarCuentaPorEstudiante($this->model->estudiante);
										if (count($unConvenio->cuenta) > 0) {
											if ($this->model->cuenta['tipocuenta'] != $unConvenio->cuenta['tipocuenta'] 
												|| $this->model->cuenta['numerocuenta'] !== $unConvenio->cuenta['numerocuenta']
												|| $this->model->cuenta['banco'] != $unConvenio->cuenta['banco']
											) {
												$this->model->eliminarCuentaPorEstudiante($this->model->estudiante);
												if (!$this->model->insertarCuenta()) {
													$convenioValido = FALSE;
												}
											}
										}
									} else {
										$convenioValido = FALSE;
									}
								} else {
									$convenioValido = FALSE;
								}
							} else {
								$convenioValido = FALSE;
							}
						} else {
							$convenioValido = FALSE;
						}
					} else {
						$erroresEstudiante = $unEstudianteController->model->validacion->getErrores();
						$this->model->validacion->acumuladoErrores = array_merge($erroresEstudiante, $this->model->validacion->acumuladoErrores);
						$convenioValido = FALSE;
					}
				} else {
					$unEstudianteController->model->asignar($estudiante);
					$convenioValido = FALSE;
				}
				if ($convenioValido) {
					$this->view->usrMensaje('La monitoria fue actualizada exitosamente');
				} else {
					$informacionEstudiante = $unEstudianteController->mostrarInformacionEstudiante(FALSE);
					$this->cargarInformacionConvenio($arregloCampos);
					$this->mostrarInformacionConvenio($informacionEstudiante);
				}
	
				break;
		}
	
	}
	
	/**
     * Co_ConvenioItemController::cargarInformacionConvenio()
     * 
	 * Carga la informacion del convenio
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function cargarInformacionConvenio($arregloCampos) {
		global $unSesion;
		$periodoAcademico = $unSesion->obtenerVariable('periodoacademico');
		$this->model->cargarPeriodo($periodoAcademico);
		$this->model->cargarDependencias();
		$this->model->cargarFondoPresupuestal();

		if (isset($arregloCampos['convenio'])) {
			if (is_array($arregloCampos['convenio'])) {
				$convenio = $arregloCampos['convenio'];
				if (!isset($convenio['dependencia']) || empty($convenio['dependencia'])) {
					$convenio['dependencia'] = (isset($convenio['dependenciapadre']))?$convenio['dependenciapadre']:'';
				}
				$this->model->asignar($convenio);
				$materias = (isset($arregloCampos['materias']) && !empty($arregloCampos['materias']))?$arregloCampos['materias']:array();
				$this->model->asignarMaterias($materias);
				$distribucion = (isset($arregloCampos['distribucion']) && !empty($arregloCampos['distribucion']))?$arregloCampos['distribucion']:array();
				$this->model->asignarDistribucion($distribucion);
				$planPagos = (isset($arregloCampos['planpagos']) && !empty($arregloCampos['planpagos']))?$arregloCampos['planpagos']:array();
				$this->model->asignarPlanPagos($planPagos);
				$cuenta = (isset($arregloCampos['cuenta']) && !empty($arregloCampos['cuenta']))?$arregloCampos['cuenta']:array();
				$this->model->asignarCuenta($cuenta);
			} elseif (!empty($arregloCampos['convenio'])) {
				$convenio = $arregloCampos['convenio'];
				$this->model->buscar($convenio);
				$this->model->buscarMateriaPorConvenio($convenio);
				$this->model->buscarDistribucionPorConvenio($convenio);
				$this->model->buscarPlanPagoPorConvenio($convenio);
				$this->model->buscarCuentaPorEstudiante($this->model->estudiante);
			}
		} else {
			$this->model->asignar(array());
			$this->model->asignarMaterias(array());
			$this->model->asignarDistribucion(array());
			$this->model->asignarPlanPagos(array());
			$this->model->buscarCuentaPorEstudiante($this->model->estudiante);
//			$this->model->asignarCuenta(array());
		}
	}

	/**
	 * Co_ConvenioItemController::mostrarInformacionConvenio()
	 *
	 * Muestra el formulario de la información del convenio
	 *
	 * @param $arregloCampos
	 * @return
	 **/
	function mostrarInformacionConvenio($informacionEstudiante) {
		$this->view->mostrarInformacionConvenio($informacionEstudiante);
	}
	
	
	/**
     * Co_ConvenioItemController::validarConvenio()
     * 
	 * Vallida la información del convenio
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function validarConvenio($arregloCampos) {
		global $unSesion;
		$returnValue = TRUE;
		
		$periodoAcademico = $unSesion->obtenerVariable('periodoacademico');
		$estudiante = (isset($arregloCampos['estudiante']) && !empty($arregloCampos['estudiante']))?$arregloCampos['estudiante']:array();
		$convenio = (isset($arregloCampos['convenio']) && !empty($arregloCampos['convenio']))?$arregloCampos['convenio']:array();
		$materias = (isset($arregloCampos['materias']) && !empty($arregloCampos['materias']))?$arregloCampos['materias']:array();
		$distribucion = (isset($arregloCampos['distribucion']) && !empty($arregloCampos['distribucion']))?$arregloCampos['distribucion']:array();
		$planPagos = (isset($arregloCampos['planpagos']) && !empty($arregloCampos['planpagos']))?$arregloCampos['planpagos']:array();
		$cuenta = (isset($arregloCampos['cuenta']) && !empty($arregloCampos['cuenta']))?$arregloCampos['cuenta']:array();
		
		$convenio['periodoacademico'] = $periodoAcademico;
		if (!isset($convenio['estado']) || empty($convenio['estado'])) {
			$convenio['estado'] = 'C';
		}
		
		$this->model->asignar($convenio);
		$this->model->dependenciapadre = isset($convenio['dependenciapadre'])?$convenio['dependenciapadre']:'';
		$this->model->asignarMaterias($materias);
		$this->model->asignarDistribucion($distribucion);
		$this->model->asignarPlanPagos($planPagos);
		$this->model->asignarCuenta($cuenta);
		$this->model->cargarPeriodo($periodoAcademico);
		$this->model->cargarLabor();
		if (!$this->model->validar()) {
			return FALSE;
		}
		$returnValue = $this->model->validarDependencia() && $returnValue;
		$returnValue = $this->model->validarFechas() && $returnValue;
		$codigo = (isset($estudiante['codigo']) && !empty($estudiante['codigo']))?$estudiante['codigo']:'';
		$returnValue = $this->model->validarMaterias() && $returnValue;
		$returnValue = $this->model->validarValorHora() && $returnValue;
		$returnValue = $this->model->validarHorasDisponibles($codigo) && $returnValue;

		if (!isset($arregloCampos['request'])) {
			$returnValue = $this->model->validarDistribucion() && $returnValue;
			$returnValue = $this->model->validarPlanPagos() && $returnValue;
			$returnValue = $this->model->validarCuenta() && $returnValue;
		}
		
		return $returnValue;
	}
	
	/**
	 * Co_ConvenioListController::usrEliminarConvenio()
	 *
	 * Elimina un convenio
	 *
	 * @param $arregloCampos
	 * @return
	 **/
	function usrEliminarConvenio($arregloCampos) {
		$convenio = isset($arregloCampos['convenio'])?$arregloCampos['convenio']:'';
		$unConvenio = new Co_Convenio();
		$unConvenio->buscar($convenio);
		if ($unConvenio->estado == 'A' || $unConvenio->estado == 'G') {
			$mensaje = 'No es posible eliminar la monitoria debido a que ya se aprobó el pago ó se generó el pago.';
		} else {
			$this->model->eliminarConvenio($convenio);
			if ($this->model->eliminar($convenio)) {
				$mensaje = 'La monitoria fue eliminada correctamente.';
			} else {
				$mensaje = 'Se produjo un error eliminando la monitoria.';
			}
		}
		$this->view->usrMensaje($mensaje);
	}
	
	/**
	 * Co_ConvenioListController::usrAprobarPago()
	 *
	 * Aprueba el pago de un convenio través de ajax
	 *
	 * @param mixed $arregloCampos
	 * @return
	 **/
	function usrAprobarPago($arregloCampos) {
		$arregloValores = array(
			'error' => ''
		);
		$convenios[] = (isset($arregloCampos['convenio']) && !empty($arregloCampos['convenio']))?$arregloCampos['convenio']:'';
		if (!$this->model->cambiarEstado($convenios, 'A')) {
			$arregloValores['error'] = 'No fue posible aprobar la monitoria';
		}
		return json_encode($arregloValores);
	}
	
	
	
} 

/**
 * Co_ConvenioListController
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 */
class Co_ConvenioListController extends Co_ConvenioController {

	var $_registroComienzoPagina;
	var $_registroFinalPagina;
	var $_condicion;
	
    /**
     * Co_ConvenioListController::Co_ConvenioListController()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_ConvenioListController () {
        Co_ConvenioController::Co_ConvenioController();
        $this->view = &new Co_ConvenioListView($this->model);
    } 

    /**
     * Co_ConvenioListController::_Co_ConvenioListController()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_ConvenioListController () {
    } 

    /**
     * Co_ConvenioListController::usrListar()
     * 
     * @param mixed $arregloCampos
     * @param mixed $template
     * @return 
     **/
    function usrListar ($arregloCampos) {
    	global $unSesion;
    	$condicion = '';
    	
    	$usuario = $unSesion->obtenerVariable('usuario');
    	$this->model->cargarPeriodoActual();
    	
    	$filtroPeriodoAcademico = isset($arregloCampos['filtroPeriodoAcademico'])?$arregloCampos['filtroPeriodoAcademico']:'';
    	if (empty($filtroPeriodoAcademico)) {
    		$filtroPeriodoAcademico = $unSesion->obtenerVariable('filtroPeriodoAcademico');
    		if ($filtroPeriodoAcademico === FALSE) {
    			$filtroPeriodoAcademico = $this->model->periodoActual['periodoacademico'];
    			$unSesion->registrarVariable('filtroPeriodoAcademico', $filtroPeriodoAcademico);
    		}
    	} else {
    		$unSesion->registrarVariable('filtroPeriodoAcademico', $filtroPeriodoAcademico);
    	}
    	
        $filtroDependencia = isset($arregloCampos['filtroDependencia'])?$arregloCampos['filtroDependencia']:'';
    	$accion = isset($arregloCampos['accion'])?$arregloCampos['accion']:'';
    	if (empty($filtroDependencia) && $accion != 'Listar') {
    		$filtroDependencia = $unSesion->obtenerVariable('filtroDependencia');
    		if ($filtroDependencia === FALSE) {
    			$filtroDependencia = $usuario['dependencia'];
    			$unSesion->registrarVariable('filtroDependencia', $filtroDependencia);
    		}
    	} else {
    		$unSesion->registrarVariable('filtroDependencia', $filtroDependencia);
    	}

        $filtroEstado = isset($arregloCampos['filtroEstado'])?$arregloCampos['filtroEstado']:'';
    	if (empty($filtroEstado) && $accion != 'Listar') {
    		$filtroEstado = $unSesion->obtenerVariable('filtroEstado');
    		if ($filtroEstado === FALSE) {
    			$filtroEstado = '';
    			$unSesion->registrarVariable('filtroEstado', $filtroEstado);
    		}
    	} else {
    		$unSesion->registrarVariable('filtroEstado', $filtroEstado);
    	}

    	$filtroCodigo = isset($arregloCampos['filtroCodigo'])?$arregloCampos['filtroCodigo']:'';
    	if (empty($filtroCodigo) && $accion != 'Listar') {
    		$filtroCodigo = $unSesion->obtenerVariable('filtroCodigo');
    		if ($filtroCodigo === FALSE) {
    			$filtroCodigo = '';
    			$unSesion->registrarVariable('filtroCodigo', $filtroCodigo);
    		}
    	} else {
    		$unSesion->registrarVariable('filtroCodigo', $filtroCodigo);
    	}
    	
    	$filtros = array(
   			'filtroPeriodoAcademico' => $filtroPeriodoAcademico,
   			'filtroDependencia' => $filtroDependencia,
   			'filtroEstado' => $filtroEstado,
    		'filtroCodigo' => $filtroCodigo
    	);

    	$parametroTmp = cargarArregloBD('Co_Parametro', 'nombre', 'valor', 'nombre', " NOMBRE IN ('SISTEMA_PAGINACION_REGISTROS', 'SISTEMA_PAGINACION_PAGINAS') ");
    	$paginacionSesion = $unSesion->obtenerVariable('paginacionListadoConvenios');
    	if ($paginacionSesion === FALSE) {
    		$paginacion = array(
   				'regInicio' => 1,
   				'regFin' => $parametroTmp['SISTEMA_PAGINACION_REGISTROS'],
   				'totalRegistros' => $this->model->contar($filtros),
   				'numeroPaginas' => $parametroTmp['SISTEMA_PAGINACION_PAGINAS'],
   				'numeroRegistros' => $parametroTmp['SISTEMA_PAGINACION_REGISTROS'],
   				'paginaActual' => 1,
   				'pagina' => ''
    		);
    		$unSesion->registrarVariable('paginacionListadoConvenios', array_merge($paginacion, $filtros));
    	} else {
    		if ($paginacionSesion['filtroPeriodoAcademico'] !=  $filtros['filtroPeriodoAcademico'] ||
    			$paginacionSesion['filtroDependencia'] !=  $filtros['filtroDependencia'] ||
    			$paginacionSesion['filtroEstado'] !=  $filtros['filtroEstado'] ||
    			$paginacionSesion['filtroCodigo'] !=  $filtros['filtroCodigo']
    		) {
    			$paginacion = array(
    				'regInicio' => 1,
    				'regFin' => $parametroTmp['SISTEMA_PAGINACION_REGISTROS'],
    				'totalRegistros' => $this->model->contar($filtros),
    				'numeroPaginas' => $parametroTmp['SISTEMA_PAGINACION_PAGINAS'],
    				'numeroRegistros' => $parametroTmp['SISTEMA_PAGINACION_REGISTROS'],
    				'paginaActual' => 1,
    				'pagina' => ''
    			);
    			$unSesion->registrarVariable('paginacionListadoConvenios', array_merge($paginacion, $filtros));
    		} else {
    			$paginacion = $paginacionSesion;
    		}
    	}
    	$this->view->unPaginacion->calcularPaginacion($paginacion);
    	
    	$this->model->listar($filtros, $paginacion);
    	$this->view->usrListar($filtros, $paginacion);
    } 
    
    /**
     * Co_ConvenioListController::usrMostrarListado()
     *
     * @param mixed $arregloCampos
     * @param mixed $template
     * @return
     **/
    function usrMostrarListado ($arregloCampos) {
    	global $unSesion;
    	$condicion = '';
    	
    	$usuario = $unSesion->obtenerVariable('usuario');
    	$this->model->cargarPeriodoActual();
    
    	$filtroPeriodoAcademico = isset($arregloCampos['filtroPeriodoAcademico'])?$arregloCampos['filtroPeriodoAcademico']:'';
    	$filtroDependencia = isset($arregloCampos['filtroDependencia'])?$arregloCampos['filtroDependencia']:'';
    	$filtroEstado = isset($arregloCampos['filtroEstado'])?$arregloCampos['filtroEstado']:'';
    	$filtroCodigo = isset($arregloCampos['filtroCodigo'])?$arregloCampos['filtroCodigo']:'';
    	
    	$filtros = array(
   			'filtroPeriodoAcademico' => $filtroPeriodoAcademico,
   			'filtroDependencia' => $filtroDependencia,
   			'filtroEstado' => $filtroEstado,
    		'filtroCodigo' => $filtroCodigo
    	);
    
    	$parametroTmp = cargarArregloBD('Co_Parametro', 'nombre', 'valor', 'nombre', " NOMBRE IN ('SISTEMA_PAGINACION_REGISTROS', 'SISTEMA_PAGINACION_PAGINAS') ");

    	$arregloCampos['numeroPaginas'] = $parametroTmp['SISTEMA_PAGINACION_PAGINAS'];
    	$arregloCampos['numeroRegistros'] = $parametroTmp['SISTEMA_PAGINACION_REGISTROS'];
    	$this->view->unPaginacion->calcularPaginacion($arregloCampos);
    	$paginacion = array(
   			'regInicio' => $this->view->unPaginacion->regInicio,
   			'regFin' => $this->view->unPaginacion->regFin,
    		'totalRegistros' => $this->view->unPaginacion->totalRegistros,
    		'numeroPaginas' => $parametroTmp['SISTEMA_PAGINACION_PAGINAS'],
    		'numeroRegistros' => $parametroTmp['SISTEMA_PAGINACION_REGISTROS'],
    		'paginaActual' => $this->view->unPaginacion->paginaActual,
    		'pagina' => $arregloCampos['pagina']
    	);
    	$unSesion->registrarVariable('paginacionListadoConvenios', array_merge($paginacion, $filtros));
    	$this->model->listar($filtros, $paginacion);
    	return utf8_encode($this->view->mostrarListado(array_merge($paginacion, $filtros)));
    }

    /**
     * Co_ConvenioListController::usrCambioDependenciaPadre()
     * 
     * Devuelve el listado de dependencias y tipos de labor según la dependencia padre para ser cargado a través de ajax
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrCambioDependenciaPadre($arregloCampos) {
		$arregloValores = array(
			'dependencias' => array(),
			'tiposLabor' => array()
		);
    	$dependenciaPadre = (isset($arregloCampos['dependenciapadre']) && !empty($arregloCampos['dependenciapadre']))?$arregloCampos['dependenciapadre']:'';
		$this->cargarDependencia($arregloValores, $dependenciaPadre);
		$this->cargarTipoLabor($arregloValores, $dependenciaPadre);
		return json_encode($arregloValores);
    } 

    /**
     * Co_ConvenioListController::usrCambioDependencia()
     * 
     * Devuelve el listado de tipos de labor según la dependencia para ser cargado a través de ajax
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrCambioDependencia($arregloCampos) {
		$arregloValores = array(
			'tiposLabor' => array()
		);
    	$dependencia = (isset($arregloCampos['dependencia']) && !empty($arregloCampos['dependencia']))?$arregloCampos['dependencia']:'';
		$dependenciaPadre = (isset($arregloCampos['dependenciapadre']) && !empty($arregloCampos['dependenciapadre']))?$arregloCampos['dependenciapadre']:'';
		$this->cargarTipoLabor($arregloValores, $dependencia);
		$this->cargarTipoLabor($arregloValores, $dependenciaPadre);
		return json_encode($arregloValores);
    } 

    /**
     * Co_ConvenioListController::usrCambioTipoLabor()
     * 
     * Devuelve el listado de tipos de monitor según la dependencia y la labor para ser cargado a través de ajax
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrCambioTipoLabor($arregloCampos) {
		$arregloValores = array(
			'tiposMonitor' => array(),
			'tipoMonitorDefecto' => '',
			'labor' => ''
		);
    	$dependencia = (isset($arregloCampos['dependencia']) && !empty($arregloCampos['dependencia']))?$arregloCampos['dependencia']:'';
		$dependenciaPadre = (isset($arregloCampos['dependenciapadre']) && !empty($arregloCampos['dependenciapadre']))?$arregloCampos['dependenciapadre']:'';
		$tipoLabor = (isset($arregloCampos['tipolabor']) && !empty($arregloCampos['tipolabor']))?$arregloCampos['tipolabor']:'';
		
		$this->cargarTipoMonitor($arregloValores, $dependencia);
		$this->cargarTipoMonitor($arregloValores, $dependenciaPadre);
		$arrayTipoLabor = $this->model->buscarTipoLabor($tipoLabor);
		
		$arregloValores['tipoMonitorDefecto'] = isset($arrayTipoLabor['tipomonitor'])?$arrayTipoLabor['tipomonitor']:'';
		$arregloValores['labor'] = isset($arrayTipoLabor['labor'])?$arrayTipoLabor['labor']:'';
		return json_encode($arregloValores);
    } 
    
    /**
     * Co_ConvenioListController::cargarDependencia()
     * 
     * Devuelve el listado de dependencias
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function cargarDependencia(& $arregloValores, $dependenciaPadre) {
    	$longitud = 100;
		$dependencias = cargarArregloBD('Co_Dependencia', 'dependencia', 'nombre', 'nombre', " dependenciapadre = '$dependenciaPadre' ");
		if (is_array($dependencias)) {
			foreach ($dependencias as $kDependencia => $vDependencia) {
				$arregloValores['dependencias'][$kDependencia] = htmlentities(substr($vDependencia, 0, $longitud)) . (strlen($vDependencia) > $longitud?'...':'');
			}
		}
    }
    
    /**
     * Co_ConvenioListController::cargarTipoLabor()
     * 
     * Devuelve el listado de tipos de labor
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function cargarTipoLabor(& $arregloValores, $dependencia) {
		$tiposLabor = $this->model->cargarTipoLabor($dependencia);
		if (is_array($tiposLabor)) {
			foreach ($tiposLabor as $kTipoLabor => $vTipoLabor) {
				$arregloValores['tiposLabor'][$kTipoLabor] = htmlentities($vTipoLabor);
			}
		}
    }
    
    /**
     * Co_ConvenioListController::cargarTipoMonitor()
     * 
     * Devuelve el listado de tipos de labor
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function cargarTipoMonitor(& $arregloValores, $dependencia) {
		$tiposMonitor = $this->model->cargarTipoMonitor($dependencia);
		if (is_array($tiposMonitor)) {
			foreach ($tiposMonitor as $kTipoMonitor => $vTipoMonitor) {
				$arregloValores['tiposMonitor'][$kTipoMonitor] = htmlentities($vTipoMonitor);
			}
		}
    }
    
    /**
     * Co_ConvenioListController::usrBuscarMateria()
     * 
     * Genera el listado de materias según el texto ingresado por el usuario para ser cargado a través de ajax
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrBuscarMateria($arregloCampos) {
		$textoMateria = (isset($arregloCampos['textomateria']) && !empty($arregloCampos['textomateria']))?$arregloCampos['textomateria']:'';
		$materias = $this->model->cargarMateriaPorCodigo($textoMateria);
		if (is_array($materias)) {
			foreach ($materias as $kMateria => $vMateria) {
				$materias[$kMateria] = htmlentities($vMateria);
			}
		} else {
			$materias = array();
		}
		return json_encode($materias);
    } 

    /**
     * Co_ConvenioListController::usrCambioMateria()
     * 
     * Devuelve el nombre de la materia y el listado de secciones según el código para ser cargado a través de ajax
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrCambioMateria($arregloCampos) {
		$arregloValores = array(
			'secciones' => array()
		);
		$materia = (isset($arregloCampos['curso']) && !empty($arregloCampos['curso']))?$arregloCampos['curso']:'';
		$secciones = $this->model->cargarSecciones($materia);
		if (is_array($secciones)) {
			foreach ($secciones as $kSeccion => $vSeccion) {
				$seccionesTmp[str_pad($kSeccion, 2, '0', STR_PAD_LEFT)]= str_pad($vSeccion, 2, '0', STR_PAD_LEFT);
			}
			$arregloValores['secciones'] = $seccionesTmp;
		}
		return json_encode($arregloValores);
    } 

    /**
     * Co_ConvenioListController::usrCambioSeccion()
     * 
     * Devuelve el crn de las secciones según el código y la sección para ser cargado a través de ajax
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrCambioSeccion($arregloCampos) {
		$arregloValores = array(
			'nombre' => '',
			'crn' => ''
		);
		$materia = (isset($arregloCampos['curso']) && !empty($arregloCampos['curso']))?$arregloCampos['curso']:'';
		$seccion = (isset($arregloCampos['seccion']) && !empty($arregloCampos['seccion']))?$arregloCampos['seccion']:'';
		$materias = $this->model->cargarNombreMateria($materia, ltrim($seccion, '0'));
		if (is_array($materias)) {
			$arregloValores['nombre'] = htmlentities(array_shift($materias));
		}
		$crn = $this->model->cargarCrn($materia, ltrim($seccion, '0'));
		$arregloValores['crn'] = $crn;			
		return json_encode($arregloValores);
    } 

    /**
     * Co_ConvenioListController::usrCambioTipoObjeto()
     * 
     * Devuelve la lista de objetos de costo según el tipo de objeto para ser cargado a través de ajax
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrCambioTipoObjeto($arregloCampos) {
    	global $unSesion;
    	$longitud = 20;
		$tipoObjeto = (isset($arregloCampos['tipoobjeto']) && !empty($arregloCampos['tipoobjeto']))?$arregloCampos['tipoobjeto']:'';
//		$usuario = $unSesion->getAuthData('uid');
		$usuario = $unSesion->getAuthData('cn');
		//Adicionado para permitir al usuario ge-colme obtener los centros de costo ya que su login corto es ga.colmenare, ID de ERP. 10412-15 Request Detail
		/*
		//Se elimina por solicitud: 25145-17
		if($usuario == 'ge-colme'){
			$usuario = 'ga.colmenare';	
		}*/
		

		/* 
		* Cristian Arenas  05-08-2019
	    * TODO - validar regla de negocio de colocar null el valor hora, horas semanales y descripcion con el área funcional
		*/
		if($usuario == 'nbarreto' || $usuario == 'cd.arenas'){
			$usuario = 'xe.obando20';
		}
		

		$objetosCosto = $this->model->cargarObjetosCosto($tipoObjeto, $usuario);
		/*
		if($unSesion->getAuthData('cn') == 'nbarreto'){
			echo "<pre>";
			print_r ($objetosCosto);
			echo "</pre>";
		}  */

		
		if (is_array($objetosCosto)) {
			foreach ($objetosCosto as $kObjetoCosto => $vObjetoCosto) {
				$objetosCosto[$kObjetoCosto] = $kObjetoCosto . ' - ' . htmlentities(substr($vObjetoCosto, 0, $longitud), ENT_COMPAT, "UTF-8") . (strlen($vObjetoCosto) > $longitud?'...':'');
			}
		} else {
			$objetosCosto = array();
		}
		return json_encode($objetosCosto);
    } 

    /**
     * Co_ConvenioListController::usrCalcularValorConvenio()
     * 
     * Devuelve el valor del convenio para ser cargado a través de ajax
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrCalcularValorConvenio($arregloCampos) {
		$arregloValores = array(
			'valor' => '',
			'mensaje' => '',
			'errores' => array()
		);
		$unConvenioController = new Co_ConvenioItemController();
		if ($unConvenioController->validarConvenio($arregloCampos)) {
			$arregloValores['valor'] = $unConvenioController->model->calcularValorConvenio();
		} else {
			$arregloValores['mensaje'] = "Los valores requeridos para el calculo no son validos";
			$erroresConvenios = $unConvenioController->model->validacion->getErrores();
			foreach ($erroresConvenios as $kError => $vError) {
				$erroresConvenios[$kError] = htmlentities($vError);
			}
			$arregloValores['errores'] = $erroresConvenios;
		}
		return json_encode($arregloValores);
    } 

    /**
     * Co_ConvenioListController::usrReporteCsv()
     * 
     * Muestra el formulario para generar el reporte csv de los pagos del convenio
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrReporteCsv($arregloCampos) {
    	global $unSesion;
    	
		$accion = (isset($arregloCampos['accion']) && !empty($arregloCampos['accion']))?$arregloCampos['accion']:''; 
		switch ($accion) {
			case 'generarPagosCsv':
				$periodoacademico = (isset($arregloCampos['periodoacademico']) && !empty($arregloCampos['periodoacademico']))?$arregloCampos['periodoacademico']:'';
				$porcentajepagos = (isset($arregloCampos['corte']) && !empty($arregloCampos['corte']))?$arregloCampos['corte']:'';
				
				$estadoActual = "'A'";
				$estadoSiguiente = "'R1'";
				$arrayPorcentajepagos = explode(',', $porcentajepagos);
				if (count($arrayPorcentajepagos) == 2) {
					$estadoActual .= ",'R1'";
					$estadoSiguiente = "'R2'";
				}

				$this->model->consultarPagoConvenios($periodoacademico, $porcentajepagos, $estadoActual);
//				$cambioEstado = $this->model->cambiarEstadoPagoConvenios($periodoacademico, $porcentajepagos, $estadoActual, $estadoSiguiente);
				$cambioEstado = true;
				if ($cambioEstado) {
					
					$unReporteCsv = new ReporteCsv();
					$unReporteCsv->generarPagosConvenios($this->model);
					$unReporteCsv->enviarCsv();
				} else {
					echo "<script>alert('Se produjo un error generando el reporte de pagos'); self.close();</script>";
				}
    			
				break;
			case 'generarCuentasCsv':
				$periodoacademico = (isset($arregloCampos['periodoacademico']) && !empty($arregloCampos['periodoacademico']))?$arregloCampos['periodoacademico']:'';
				$porcentajepagos = (isset($arregloCampos['corte']) && !empty($arregloCampos['corte']))?$arregloCampos['corte']:'';
				
				$this->model->consultarCuentaEstudiante($periodoacademico, $porcentajepagos);
				
    			$unReporteCsv = new ReporteCsv();
    			$unReporteCsv->generarCuentaConvenios($this->model);
    			$unReporteCsv->enviarCsv();
    			
    			// TODO: Falta implementar el cambio de estado GENERADO
    			
    			
				break;
			default:
				$this->model->cargarPeriodoActual();
				$this->view->usrReporteCsv();
		}
    	
    }

    /**
     * Co_ConvenioListController::usrCambioPeriodoAcademicoR()
     *
     * Devuelve la lista de porcentajes de pago según el periodo academico para ser cargado a través de ajax (Reporte)
     *
     * @param mixed $arregloCampos
     * @return
     **/
    function usrCambioPeriodoAcademicoR($arregloCampos) {
    	global $unSesion;
    	$periodoacademico = (isset($arregloCampos['periodoacademico']) && !empty($arregloCampos['periodoacademico']))?$arregloCampos['periodoacademico']:'';
    
    	$planPagos = $this->model->cargarPlanPagosPorPeriodoAcademico($periodoacademico);
    	$porcentajesPago = array();
    	foreach ($planPagos as $kPlan => $vPlan) {
    		$porcentajesPagoAux = $this->model->cargarPorcentajePagosPorPlanPagos($kPlan);
    		if (count($porcentajesPagoAux) == 1) {
    			$pagoUnico = key($porcentajesPagoAux);
    		} else {
    			$porcentajesPago = $porcentajesPagoAux;
    		}
    	}

    	$ultimoPago = array_search(count($porcentajesPago), $porcentajesPago);
    	array_pop($porcentajesPago);
    	$porcentajesPago[$ultimoPago . ',' . $pagoUnico] = (count($porcentajesPago) + 1) . '';
    	
    	if (!is_array($porcentajesPago)) {
    		$porcentajesPago = array();
    	}
    	return json_encode($porcentajesPago);
    }

    /**
     * Co_ConvenioListController::usrAprobar()
     *
     * @param mixed $arregloCampos
     * @param mixed $template
     * @return
     **/
    function usrAprobar ($arregloCampos) {
		global $unSesion;
		
    	$usuario = $unSesion->obtenerVariable('usuario');
    	$dependencia = $usuario['dependencia'];
    	$mensaje = '';
    	
    	$accion = (isset($arregloCampos['accion']) && !empty($arregloCampos['accion']))?$arregloCampos['accion']:''; 
		$this->model->cargarPeriodoActual();
		switch ($accion) {
			case 'aprobar':
				$convenios = isset($arregloCampos['convenios'])?$arregloCampos['convenios']:array();
				if (count($convenios) == 0) {
					$mensaje .= 'Debe ingresar el periodo académico' . "<br>";
				}
				if (empty($mensaje)) {
					if ($this->model->cambiarEstado($convenios, 'A')) {
						$mensaje = 'Las monitorias fueron aprobadas exitosamente';
					} else {
						$mensaje = 'Se presento un error aprobando las monitorias';
					}
				}
			default:
				$periodo = isset($arregloCampos['periodoacademico'])?$arregloCampos['periodoacademico']:$this->model->periodoActual['periodoacademico'];
				$estado = isset($arregloCampos['estado'])?$arregloCampos['estado']:'C';
				
				$filtros = array(
					'filtroPeriodoAcademico' => $periodo,
					'filtroDependencia' => $dependencia,
					'filtroEstado' => $estado
				);
				
				$parametroTmp = cargarArregloBD('Co_Parametro', 'nombre', 'valor', 'nombre', " NOMBRE IN ('SISTEMA_PAGINACION_REGISTROS', 'SISTEMA_PAGINACION_PAGINAS') ");
				$paginacionSesion = $unSesion->obtenerVariable('paginacionListadoAprobar');
				if ($paginacionSesion === FALSE) {
					$paginacion = array(
						'regInicio' => 1,
						'regFin' => $parametroTmp['SISTEMA_PAGINACION_REGISTROS'],
						'totalRegistros' => $this->model->contar($filtros),
						'numeroPaginas' => $parametroTmp['SISTEMA_PAGINACION_PAGINAS'],
						'numeroRegistros' => $parametroTmp['SISTEMA_PAGINACION_REGISTROS'],
						'paginaActual' => 1,
						'pagina' => ''
					);
					$unSesion->registrarVariable('paginacionListadoAprobar', array_merge($paginacion, $filtros));
				} else {
					if ($paginacionSesion['filtroPeriodoAcademico'] !=  $filtros['filtroPeriodoAcademico'] ||
							$paginacionSesion['filtroDependencia'] !=  $filtros['filtroDependencia'] ||
							$paginacionSesion['filtroEstado'] !=  $filtros['filtroEstado']
					) {
						$paginacion = array(
							'regInicio' => 1,
							'regFin' => $parametroTmp['SISTEMA_PAGINACION_REGISTROS'],
							'totalRegistros' => $this->model->contar($filtros),
							'numeroPaginas' => $parametroTmp['SISTEMA_PAGINACION_PAGINAS'],
							'numeroRegistros' => $parametroTmp['SISTEMA_PAGINACION_REGISTROS'],
							'paginaActual' => 1,
							'pagina' => ''
						);
						$unSesion->registrarVariable('paginacionListadoAprobar', array_merge($paginacion, $filtros));
					} else {
						$paginacion = $paginacionSesion;
					}
				}
				$this->view->unPaginacion->calcularPaginacion($paginacion);
				
				$this->model->listar($filtros, $paginacion);
				$this->view->usrAprobar($filtros, $paginacion, $mensaje);
		}
    }
    
    /**
     * Co_ConvenioListController::usrMostrarListadoAprobar()
     *
     * @param mixed $arregloCampos
     * @param mixed $template
     * @return
     **/
    function usrMostrarListadoAprobar ($arregloCampos) {
    	global $unSesion;
    
    	$filtroPeriodoAcademico = isset($arregloCampos['filtroPeriodoAcademico'])?$arregloCampos['filtroPeriodoAcademico']:'';
    	$filtroDependencia = isset($arregloCampos['filtroDependencia'])?$arregloCampos['filtroDependencia']:'';
    	$filtroEstado = isset($arregloCampos['filtroEstado'])?$arregloCampos['filtroEstado']:'';
    
    	$filtros = array(
   			'filtroPeriodoAcademico' => $filtroPeriodoAcademico,
   			'filtroDependencia' => $filtroDependencia,
   			'filtroEstado' => $filtroEstado
    	);
    
    	$parametroTmp = cargarArregloBD('Co_Parametro', 'nombre', 'valor', 'nombre', " NOMBRE IN ('SISTEMA_PAGINACION_REGISTROS', 'SISTEMA_PAGINACION_PAGINAS') ");
    
    	$arregloCampos['numeroPaginas'] = $parametroTmp['SISTEMA_PAGINACION_PAGINAS'];
    	$arregloCampos['numeroRegistros'] = $parametroTmp['SISTEMA_PAGINACION_REGISTROS'];
    	$this->view->unPaginacion->calcularPaginacion($arregloCampos);
    	$paginacion = array(
   			'regInicio' => $this->view->unPaginacion->regInicio,
   			'regFin' => $this->view->unPaginacion->regFin,
   			'totalRegistros' => $this->view->unPaginacion->totalRegistros,
   			'numeroPaginas' => $parametroTmp['SISTEMA_PAGINACION_PAGINAS'],
   			'numeroRegistros' => $parametroTmp['SISTEMA_PAGINACION_REGISTROS'],
   			'paginaActual' => $this->view->unPaginacion->paginaActual,
   			'pagina' => $arregloCampos['pagina']
    	);
    	$unSesion->registrarVariable('paginacionListadoAprobar', array_merge($paginacion, $filtros));
    	$this->model->listar($filtros, $paginacion);
    	return utf8_encode($this->view->mostrarListadoAprobar(array_merge($paginacion, $filtros)));
    }
    
    /**
     * Co_ConvenioListController::usrMostrarPDF()
     *
     * @param mixed $arregloCampos
     * @param mixed $template
     * @return
     **/
    function usrMostrarPDF($arregloCampos) {
    	$convenios = isset($arregloCampos['convenios'])?$arregloCampos['convenios']:array();
    	$informacionPDF = $this->model->cargarInformacionPDF($convenios);
    	$this->view->generarPDF($informacionPDF);
    }

    /**
     * Co_ConvenioListController::usrReporteConvenios()
     *
     * Muestra el formulario para generar el reporte excel de los convenios
     *
     * @param mixed $arregloCampos
     * @return
     **/
    function usrReporteConvenios($arregloCampos) {
    	global $unSesion;
    	global $_ENV;
    
    	$accion = (isset($arregloCampos['accion']) && !empty($arregloCampos['accion']))?$arregloCampos['accion']:'';
    	switch ($accion) {
    		case 'generar':
    			$_ENV['TMPDIR'] = TMP_DIR;
    
    			$filtroPeriodoAcademico = isset($arregloCampos['filtroPeriodoAcademico'])?$arregloCampos['filtroPeriodoAcademico']:'';
    			$filtroDependencia = isset($arregloCampos['filtroDependencia'])?$arregloCampos['filtroDependencia']:'';
    			$filtroEstado = isset($arregloCampos['filtroEstado'])?$arregloCampos['filtroEstado']:'';
    			$filtroCodigo = isset($arregloCampos['filtroCodigo'])?$arregloCampos['filtroCodigo']:'';
    			
    			$filtros = array(
    				'filtroPeriodoAcademico' => $filtroPeriodoAcademico,
    				'filtroDependencia' => $filtroDependencia,
    				'filtroEstado' => $filtroEstado,
    				'filtroCodigo' => $filtroCodigo,
    			);
    			$convenios = $this->model->cargarInformacionExcel($filtros);
    			$unReporteExcel = new ReporteExcel('RepConvenios-' . date('YmdHis'));
    			$datosAdicionales['periodoAcademico'] = $filtroPeriodoAcademico;
    			$datosAdicionales['dependencia'] = $filtroDependencia;
    			$datosAdicionales['estado'] = $filtroEstado;
    			$unReporteExcel->generarConvenios($convenios, $datosAdicionales);
    			$unReporteExcel->cerrarArchivoExcel();
    
    			break;
    	}
    }
    
}

?>
