<?php
/*
 * Co_ConvenioView
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
require_once 'HTML/Template/IT.php';
require_once 'Funciones.php';
require_once 'Paginacion.class.php';
require_once 'fpdf/fpdf.php';

class Co_ConvenioView {
    var $model;
    var $tpl;
    var $_interfaz;

    function Co_ConvenioView (&$model) {
        $this->model = &$model;
        $this->tpl = new HTML_Template_IT(TPL_DIR);
    } 

    function _Co_ConvenioView () {
    } 

	/**
	 * Co_ConvenioView::setAtributos()
	 * 
	 * Remplaza en la plantilla los {tags} por los atributos del modelo
	 * 
	 * @return void 
	 **/
	function setAtributos(){		
		$campos = $this->model->table();
		foreach ($campos as $kCampo => $vCampo) {
			$this->tpl->setVariable($kCampo, $this->model->$kCampo);
		}
	}
	
	/**
	 * Co_ConvenioView::setValidacion()
	 * 
	 * Remplaza los {tags} de validacion por las alertas respectivas, adicionalmente 
	 * carga la variable mensaje forma con la lista de errores ocurridos.
	 * 
	 * @param $mensajeForma
	 * @return 
	 **/
	function setValidacion(& $mensajeForma){

        if ($this->model->validacion->huboError()) {
            $errores = $this->model->validacion->getErrores();
			$mensajeForma .= '<ul>'. "\n";
            foreach ($errores as $campo => $mensaje) {
                $this->tpl->setVariable('v' . $campo, muestreAlerta($mensaje));
				$mensajeForma .= "\t" .'<li>' . ucfirst(strtolower($mensaje)). "\n";
            }
			$mensajeForma .= '</ul>'. "\n";
        } else {
			foreach($this->model->validacionCampos as $campo => $arCampo){
				if($arCampo['req']){
					$this->tpl->setVariable('v' . $campo, muestreRequerido());
				}
			}
		}

	}

	/**
	 * Co_ConvenioView::setMensaje()
	 * 
	 * Remplaza el mensaje en la plantilla, este debe estar en un bloque aparte llamado
	 * MENSAJE.
	 * 
	 * @param $mensajeForma
	 * @return void
	 **/
	function setMensaje(& $mensajeForma){
		//Revisa si hubo algun error en el modelo
		if ($this->model->_lastError) {
			$mensajeForma = $mensajeForma 
				. "\n"
				. 'Error : ' 
				. $this->model->_lastError->getCode() 
				. ' :: ' 
				. $this->model->_lastError->getMessage()
				. "\n";
			
		}
		// Revisa si hubo algun error en la validacion o anterior
		if (!empty($mensajeForma)) {
			$this->tpl->setCurrentBlock('MENSAJE');
			$this->tpl->setVariable('mensaje' 	, $mensajeForma);
			$this->tpl->parseCurrentBlock();   
		}
	}
   
    /**
     * Co_ConvenioView::display()
     * 
     * Método que despliega la información de uno o varios registros
     * 
     * @return 
     */
    function display () {
        $this->tpl->show();
    } 

    /**
     * Co_ConvenioView::get()
     * 
     * Método que captura la información de uno o varios registros
     * 
     * @return 
     */
    function get () {
        return $this->tpl->get();
    } 

} // end Co_ConvenioView

/*
 * Co_ConvenioItemView
 * 
 * Clase responsable de la definición de métodos de vista para la 
 * presentación de la información por pantalla 
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_ConvenioItemView extends Co_ConvenioView {

    /**
     * Co_ConvenioItemView::Co_ConvenioItemView()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_ConvenioItemView (&$model) {
        Co_ConvenioView::Co_ConvenioView($model);
    } 

    /**
     * Co_ConvenioItemView::_Co_ConvenioItemView()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_ConvenioItemView () {
    } 

    /**
     * Co_ConvenioItemView::usrMensaje()
     * 
     * Método que despliega un mensaje por pantalla
     * 
     * @return 
     */
    function usrMensaje($mensaje) {
        $this->tpl->loadTemplateFile('frmMensaje.tpl', true, true);
		$this->tpl->setVariable('cabezote', cargarCabezote());
		$this->tpl->setVariable('pie', cargarPie());
 		$this->tpl->setVariable('clase', 'Convenio');
 		$this->tpl->setVariable('controlador', 'List');
 		$this->tpl->setVariable('metodo', 'usrListar');
 		$this->tpl->setVariable('mensaje', $mensaje);
    }
    
    /**
     * Co_ConvenioItemView::mostrarInformacionConvenio()
     * 
     * Método que despliega el formulario con la información del convenio por pantalla
     * 
     * @return 
     */
    function mostrarInformacionConvenio($informacionEstudiante) {
    	global $tipoObjeto;
    	global $tipoCuenta;
    	global $unSesion;
    	global $estadoConvenio;
    	
    	$usuario = $unSesion->obtenerVariable('usuario');
    	
    	$mensajeForma = NULL;
        $this->tpl->loadTemplateFile('frmInformacionConvenio.tpl', true, true);
		$this->tpl->setVariable('cabezote', cargarCabezote());
		$this->tpl->setVariable('pie', cargarPie());

		$this->tpl->setVariable('URL_SITIO', URL_SITIO);
		$this->tpl->setVariable('queryHiddenSession', imprimirSessionString(FALSE));
		
		$this->tpl->setVariable('informacionEstudiante', $informacionEstudiante);
		
		$this->tpl->setVariable('fechaInicioPeriodo', $this->model->periodoActual['fechainicio']);
		$this->tpl->setVariable('fechaFinPeriodo', $this->model->periodoActual['fechafin']);
		
		$this->setAtributos();

		$dependenciaPadre = '';
		$dependencia = '';
		$arrayDependenciaPadre = array();
		foreach ($this->model->arrayDependencia as $kDependenciaPadre => $vDependenciaPadre) {
			$arrayDependenciaPadre[$kDependenciaPadre] = $vDependenciaPadre['nombre'];
			if (!empty($this->model->dependencia)) {
				if ($this->model->dependencia == $kDependenciaPadre) {
					$dependenciaPadre = $kDependenciaPadre;
				} elseif (isset($vDependenciaPadre['departamento'][$this->model->dependencia])) {
					$dependenciaPadre = $kDependenciaPadre;
					$dependencia = $this->model->dependencia;
				}
			}
		}
		$selectDependenciaPadre = imprimirOpcionesArreglo($arrayDependenciaPadre, $dependenciaPadre, 'Seleccionar...', 100);
		$this->tpl->setVariable('selectDependenciaPadre', $selectDependenciaPadre);
		$arrayDependencia = isset($this->model->arrayDependencia[$dependenciaPadre]['departamento'])?$this->model->arrayDependencia[$dependenciaPadre]['departamento']:array();
		$selectDependencia = imprimirOpcionesArreglo($arrayDependencia, $dependencia, 'Seleccionar...', 100);
		$this->tpl->setVariable('selectDependencia', $selectDependencia);
		$this->tpl->setVariable('dependencia', $dependencia);
		$this->tpl->setVariable('dependenciapadre', $dependenciaPadre);

		if (empty($this->model->tipolabor)) {
			$arrayTipoLabor = array();
			$arrayTmpTipoLabor = array();
		} else {
			$arrayTipoLabor = cargarArregloBD('Co_TipoLabor', 'tipolabor', 'nombre', 'nombre', " tipolabor = '" . $this->model->tipolabor . "' ");
			$arrayTmpTipoLabor = cargarArregloBD('Co_TipoLabor', 'tipolabor', 'labor', 'labor', " tipolabor = '" . $this->model->tipolabor . "' ");
		}
		$selectTipoLabor = imprimirOpcionesArreglo($arrayTipoLabor, $this->model->tipolabor, 'Seleccionar...');
		$this->tpl->setVariable('selectTipoLabor', $selectTipoLabor);
	
		if (empty($this->model->tipomonitor)) {
			$arrayTipoMonitor = array();
		} else {
			$arrayTipoMonitor = cargarArregloBD('Co_TipoMonitor', 'tipomonitor', 'nombre', 'nombre', " tipomonitor = '" . $this->model->tipomonitor . "' ");
		}
		$selectTipoMonitor = imprimirOpcionesArreglo($arrayTipoMonitor, $this->model->tipomonitor, 'Seleccionar...');
		$this->tpl->setVariable('selectTipoMonitor', $selectTipoMonitor);
		
		$minHoras = $this->model->periodoActual['minhoras'];
		$maxHoras = $this->model->periodoActual['maxhoras'];
		for($i = $minHoras; $i <= $maxHoras; $i++) {
			$horasSemanales[$i] = $i;
		}

		$selectHorasSemanales = imprimirOpcionesArreglo($horasSemanales, $this->model->horassemanales, 'Seleccionar...');
		$this->tpl->setVariable('selectHorasSemanales', $selectHorasSemanales);
		
		$divTablaTipoLabor = 'hide';
		$divTablaTipoLaborI = 'hide';
		$divTablaTipoLaborD = 'hide';
		if (isset($arrayTmpTipoLabor[$this->model->tipolabor]) && !empty($arrayTmpTipoLabor[$this->model->tipolabor])) {
			$divTablaTipoLabor = 'show';
			if ($arrayTmpTipoLabor[$this->model->tipolabor] == 'I') {
				$divTablaTipoLaborI = 'show';
			}
			if ($arrayTmpTipoLabor[$this->model->tipolabor] == 'D') {
				$divTablaTipoLaborD = 'show';
			}
		}
		$this->tpl->setVariable('divTablaTipoLabor', $divTablaTipoLabor);
		$this->tpl->setVariable('divTablaTipoLaborI', $divTablaTipoLaborI);
		$this->tpl->setVariable('divTablaTipoLaborD', $divTablaTipoLaborD);
		$divTituloTipoLabor = isset($arrayTipoLabor[$this->model->tipolabor])?$arrayTipoLabor[$this->model->tipolabor]:'';
		$this->tpl->setVariable('divTituloTipoLabor', $divTituloTipoLabor);
		
		$numeroMaterias = count($this->model->materias);
		$divTablaMateria = $numeroMaterias > 0?'show':'hide';
		$this->tpl->setVariable('divTablaMateria', $divTablaMateria);
		$this->tpl->setVariable('numeromaterias', $numeroMaterias);
		$this->tpl->setVariable('minhoras', $minHoras);
		$this->tpl->setVariable('maxhoras', $maxHoras);

		$numeroDistribucion = count($this->model->distribucion);
		$this->tpl->setVariable('numerodistribucion', $numeroDistribucion);
		$arrayTipoObjeto = 'var arrayTipoObjeto = new Array();' . "\n";
		foreach ($tipoObjeto as $kTipoObjeto => $vTipoObjeto) {
			$arrayTipoObjeto .= "arrayTipoObjeto['$kTipoObjeto'] = '$vTipoObjeto';" . "\n";
		}
		$this->tpl->setVariable('arrayTipoObjeto', $arrayTipoObjeto);
		$arrayFondoPresupuestal = 'var arrayFondoPresupuestal = new Array();' . "\n";
		$fondoPresupuestal = array();
		foreach ($this->model->fondoPresupuestal as $kFondoPresupuestal => $vFondoPresupuestal) {
			$fondoPresupuestal[$kFondoPresupuestal] = $kFondoPresupuestal . ' - ' . utf8_decode($vFondoPresupuestal);
			$arrayFondoPresupuestal .= "arrayFondoPresupuestal['$kFondoPresupuestal'] = '" . $fondoPresupuestal[$kFondoPresupuestal] . "';" . "\n";
		}
		$this->tpl->setVariable('arrayFondoPresupuestal', $arrayFondoPresupuestal);
		
		$planpagos = isset($this->model->planPagos['planpagos'])?$this->model->planPagos['planpagos']:'';
		$valor = isset($this->model->planPagos['valor'])?$this->model->planPagos['valor']:'';
		$filtroPlanPagos = " periodoacademico = '" . $this->model->periodoActual['periodoacademico'] . "' ";
		$arrayFechaLimite = explode('/', $this->model->periodoActual['fechalimite']);
		$numFechaLimite = mktime(0, 0, 0, $arrayFechaLimite[1], $arrayFechaLimite[0], $arrayFechaLimite[2]);
		$numFechaActual = mktime();
		if ($numFechaActual > $numFechaLimite) {
			$filtroPlanPagos .= " and aplicafechalimite = 'S' ";
		}
		if (!empty($planpagos)) {
			$filtroPlanPagos .= " or planpagos = $planpagos ";
		}
		$arrayPlanPagos = cargarArregloBD('Co_PlanPagos', 'planpagos', 'nombre', 'nombre', $filtroPlanPagos);
		$selectPlanPagos = imprimirOpcionesArreglo($arrayPlanPagos, $planpagos, 'Seleccionar...');
		$this->tpl->setVariable('selectPlanPagos', $selectPlanPagos);
		$this->tpl->setVariable('valor', $valor);
		
		$tipocuenta = isset($this->model->cuenta['tipocuenta'])?$this->model->cuenta['tipocuenta']:'';
		$banco = isset($this->model->cuenta['banco'])?$this->model->cuenta['banco']:'';
		$numerocuenta = isset($this->model->cuenta['numerocuenta'])?$this->model->cuenta['numerocuenta']:'';
		$selectTipoCuenta = imprimirOpcionesArreglo($tipoCuenta, $tipocuenta, 'Seleccionar...');
		$this->tpl->setVariable('selectTipoCuenta', $selectTipoCuenta);
		$arrayBanco = cargarArregloBD('Co_Banco', 'banco', 'nombre', 'nombre', " pais = 'CO' ");
		$selectBanco = imprimirOpcionesArreglo($arrayBanco, $banco, 'Seleccionar...');
		$this->tpl->setVariable('selectBanco', $selectBanco);
		$this->tpl->setVariable('numerocuenta', $numerocuenta);
		
		$arrayMateriaI = array();
		$arraySeccionI = array();
		$curso = '';
		$seccion = '';
		if ($divTablaTipoLaborI == 'show') {
			$vMateria = array_shift($this->model->materias);
			$materia = isset($vMateria['materia'])?$vMateria['materia']:'';
			$textomateria = isset($vMateria['curso'])?$vMateria['curso']:'';
			$nombre = isset($vMateria['nombre'])?$vMateria['nombre']:'';
			$curso = isset($vMateria['curso'])?$vMateria['curso']:'';
			$crn = isset($vMateria['crn'])?$vMateria['crn']:'';
			$valorhora = isset($vMateria['valorhora'])?$vMateria['valorhora']:'';
			$horassemanales = isset($vMateria['horassemanales'])?$vMateria['horassemanales']:'';
			$seccion = isset($vMateria['seccion'])?$vMateria['seccion']:'';
		
			if (!empty($curso)) {
				$arrayMateriaI[$curso] = $curso;
			}
			if (!empty($seccion)) {
				$arraySeccionI[$seccion] = str_pad($seccion, 2, '0', STR_PAD_LEFT);
			}
			
			$this->tpl->setVariable('nombreI', $nombre);
			$this->tpl->setVariable('crnI', $crn);
			$this->tpl->setVariable('textomateriaI', $textomateria);
			
		} else {
			$this->tpl->setVariable('curso1000Disabled', 'disabled="disabled"');
			$this->tpl->setVariable('seccion1000Disabled', 'disabled="disabled"');
			$this->tpl->setVariable('crn1000Disabled', 'disabled="disabled"');
			$this->tpl->setVariable('nombre1000Disabled', 'disabled="disabled"');
		}
		$selectMateriaI = imprimirOpcionesArreglo($arrayMateriaI, $curso, 'Seleccionar...');
		$this->tpl->setVariable('selectMateriaI', $selectMateriaI);
	
		$selectSeccionI = imprimirOpcionesArreglo($arraySeccionI, $seccion, 'Seleccionar...');
		$this->tpl->setVariable('selectSeccionI', $selectSeccionI);
		
		$this->setValidacion($mensajeForma);
		if ($divTablaTipoLaborD == 'show') {
			$orden = 1;
			foreach ($this->model->materias as $vMateria) {
				$materia = isset($vMateria['materia'])?$vMateria['materia']:'';
				$textomateria = isset($vMateria['curso'])?$vMateria['curso']:'';
				$nombre = isset($vMateria['nombre'])?$vMateria['nombre']:'';
				$curso = isset($vMateria['curso'])?$vMateria['curso']:'';
				$crn = isset($vMateria['crn'])?$vMateria['crn']:'';
				$valorhora = isset($vMateria['valorhora'])?$vMateria['valorhora']:'';
				$horassemanales = isset($vMateria['horassemanales'])?$vMateria['horassemanales']:'';
				$seccion = isset($vMateria['seccion'])?$vMateria['seccion']:'';
				
				$this->tpl->setCurrentBlock("TABLAMATERIA");
				$arrayMateria = array($curso => $curso);
				$selectMateria = imprimirOpcionesArreglo($arrayMateria, $curso, 'Seleccionar...');
				$this->tpl->setVariable('selectMateria', $selectMateria);
	
				$arraySeccion = array($seccion => str_pad($seccion, 2, '0', STR_PAD_LEFT));
				$selectSeccion = imprimirOpcionesArreglo($arraySeccion, $seccion, 'Seleccionar...');
				$this->tpl->setVariable('selectSeccion', $selectSeccion);
	
				$selectHorasSemanalesD = imprimirOpcionesArreglo($horasSemanales, $horassemanales, 'Seleccionar...');
				$this->tpl->setVariable('selectHorasSemanalesD', $selectHorasSemanalesD);
	
				$this->tpl->setVariable('nombre', $nombre);
				$this->tpl->setVariable('crn', $crn);
				$this->tpl->setVariable('valorhoraD', $valorhora);
				$this->tpl->setVariable('seccion', $seccion);
				$this->tpl->setVariable('textomateria', $textomateria);
				
				$this->tpl->setVariable('orden', $orden);
				$this->tpl->parseCurrentBlock("TABLAMATERIA");
				$orden++;
			}
		}

		$orden = 1;
		foreach ($this->model->distribucion as $vDistribucion) {
			$this->tpl->setCurrentBlock("TABLADISTRIBUCION");
			$selectTipoObjeto = imprimirOpcionesArreglo($tipoObjeto, $vDistribucion['tipoobjeto'], 'Seleccionar...');
			$this->tpl->setVariable('selectTipoObjeto', $selectTipoObjeto);

			$vDistribucion['objetocosto'] = isset($vDistribucion['objetocosto'])?$vDistribucion['objetocosto']:'';
			$arrayObjetoCosto = array($vDistribucion['objetocosto'] => $vDistribucion['objetocosto']);
			$selectObjetoCosto = imprimirOpcionesArreglo($arrayObjetoCosto, $vDistribucion['objetocosto'], 'Seleccionar...');
			$this->tpl->setVariable('selectObjetoCosto', $selectObjetoCosto);

			$selectFondoPresupuestal = imprimirOpcionesArreglo($fondoPresupuestal, $vDistribucion['fondopresupuestal'], 'Seleccionar...', 100);
			$this->tpl->setVariable('selectFondoPresupuestal', $selectFondoPresupuestal);
			$this->tpl->setVariable('porcentaje', $vDistribucion['porcentaje']);
			
			$this->tpl->setVariable('ordenD', $orden);
			$this->tpl->parseCurrentBlock("TABLADISTRIBUCION");
			$orden++;
		}
		if ($usuario['tiporol'] == 'U') {
			$this->tpl->setCurrentBlock('ESTADOU');
			$this->tpl->setVariable('estadoU', $this->model->estado);
			$this->tpl->parseCurrentBlock('ESTADOU');
		} elseif ($usuario['tiporol'] == 'A') {
			$selectEstadoA = imprimirOpcionesArreglo($estadoConvenio, $this->model->estado, '-', 100);
			$this->tpl->setCurrentBlock('ESTADOA');
			$this->tpl->setVariable('selectEstadoA', $selectEstadoA);
			$this->tpl->parseCurrentBlock('ESTADOA');
		}
		if (empty($this->model->convenio)) {
			$this->tpl->touchBlock('SOLICITAR');
		} else {
			if ($this->model->estado == 'C' || $usuario['tiporol'] == 'A') {
				$this->tpl->touchBlock('ACTUALIZAR');
			}
			if ($this->model->estado == '') {
				$this->tpl->touchBlock('APROBARLISTADO');
			} else {
				$this->tpl->touchBlock('VOLVERLISTADO');
			}
		}
		if (!empty($mensajeForma)) {
			$this->tpl->setCurrentBlock("MENSAJE");
			$this->tpl->setVariable('mensaje', $mensajeForma);
			$this->tpl->parseCurrentBlock("MENSAJE");
 		}
    }
    
} // end Co_ConvenioItemView

/*
 * Co_ConvenioListView
 * 
 * Clase responsable de la definición de métodos de vista para la 
 * presentación de una lista por pantalla 
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_ConvenioListView extends Co_ConvenioView {

	var $unPaginacion;
	
    /**
     * Co_ConvenioListView::Co_ConvenioListView()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_ConvenioListView (&$model) {
        Co_ConvenioView::Co_ConvenioView($model);
        $this->unPaginacion = new Paginacion();
    } 

    /**
     * Co_ConvenioListView::_Co_ConvenioListView()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_ConvenioListView () {
    } 

    /**
     * Co_ConvenioListView::usrListar()
     * 
     * Método que despliega una lista por pantalla para la interfaz de Usuario
     * 
     * @param $arregloCampos
     * @return 
     */
    function usrListar($filtros = array(), $paginacion = array()) {
    	global $unSesion;
    	global $estadoConvenio;
    	
    	$usuario = $unSesion->obtenerVariable('usuario');
    	
    	$filtroPeriodoAcademico = isset($filtros['filtroPeriodoAcademico'])?$filtros['filtroPeriodoAcademico']:'';
    	$filtroDependencia = isset($filtros['filtroDependencia'])?$filtros['filtroDependencia']:'';
    	$filtroEstado = isset($filtros['filtroEstado'])?$filtros['filtroEstado']:'';
    	$filtroCodigo = isset($filtros['filtroCodigo'])?$filtros['filtroCodigo']:'';
    	
    	$this->tpl->loadTemplateFile('lstConvenio.tpl', true, true);
		$this->tpl->setVariable('cabezote', cargarCabezote());
		$this->tpl->setVariable('pie', cargarPie());
		$this->tpl->setVariable('URL_SITIO', URL_SITIO);
		$this->tpl->setVariable('queryHiddenSession', imprimirSessionString(FALSE));
		
		$periodos = cargarArregloBD('Co_PeriodoAcademico', 'periodoacademico', 'periodosemestre');
		$selectPeriodoAcademico = imprimirOpcionesArreglo($periodos, $filtroPeriodoAcademico, 'Seleccionar...');
		$this->tpl->setVariable('selectPeriodoAcademico', $selectPeriodoAcademico);
		
		$condicionDependencia = '';
		$tituloSelect = 'Todas';
		if ($usuario['tiporol'] == 'U') {
			$condicionDependencia = " DEPENDENCIA = '" . $usuario['dependencia'] . "' OR DEPENDENCIAPADRE = '" . $usuario['dependencia'] . "' ";
			$tituloSelect = '-';
		}
		$dependencias = cargarArregloBD('Co_Dependencia', 'dependencia', 'nombre', 'nombre', $condicionDependencia);
		$selectDependencia = imprimirOpcionesArreglo($dependencias, $filtroDependencia, $tituloSelect, 100);
		$this->tpl->setVariable('selectDependencia', $selectDependencia);
		
		$selectEstado = imprimirOpcionesArreglo($estadoConvenio, $filtroEstado, 'Todos');
		$this->tpl->setVariable('selectEstado', $selectEstado);
		
		$this->tpl->setVariable('filtroCodigo', $filtroCodigo);
		
		$this->tpl->setVariable('listadoConvenios', $this->mostrarListado(array_merge($paginacion, $filtros)));
		
    } 
    
    function mostrarListado($arregloCampos) {
    	global $estadoConvenio;
    	global $estadoConvenioMostrarPDF;
    	
    	$tpl = new HTML_Template_IT(TPL_DIR);
    	$tpl->loadTemplateFile('pagConvenio.tpl', true, true);
    	$noDatos = true;
    	foreach ($arregloCampos as $kCampo => $vCampo) {
    		$tpl->setVariable($kCampo, $vCampo);
    	}
    	
    	$paginacion = $this->unPaginacion->mostrarPaginacion($arregloCampos);
    	
    	$tpl->setVariable('paginacion', $paginacion);
    	
    	$campos = $this->model->table();
    	while ($this->model->fetch()) {
    		if (in_array($this->model->estado, $estadoConvenioMostrarPDF)) {
	    		$tpl->setCurrentBlock('MOSTRARPDF');
	    		$tpl->setVariable('convenio_mostrarpdf', $this->model->convenio);
	    		$tpl->parseCurrentBlock('MOSTRARPDF');
    		}
    		
    		$tpl->setCurrentBlock('CONVENIO');
    		foreach ($campos as $kCampo => $vCampo) {
    			$tpl->setVariable($kCampo, $this->model->$kCampo);
    		}
    		$nombreEstudiante = $this->model->nombres . ' ' . $this->model->apellidos;
    		$tpl->setVariable('nombreEstudiante', $nombreEstudiante);
    		$tpl->setVariable('nombreDependencia', $this->model->nombredependencia);
    		$tpl->setVariable('nombreEstado', $estadoConvenio[$this->model->estado]);
    		$tpl->parseCurrentBlock('CONVENIO');
    		$noDatos = false;
    	}
    	if ($noDatos) {
    		$tpl->setCurrentBlock('NODATOS');
    		$tpl->setVariable('noDatos', "No hay monitorias disponibles");
    		$tpl->parseCurrentBlock('NODATOS');
    	}
    	return $tpl->get();
    }
    
    /**
     * Co_ConvenioListView::usrReporteCsv()
     * 
     * @param $arregloCampos
     * @return 
     */
    function usrReporteCsv() {
    	$this->tpl->loadTemplateFile('rptConvenio.tpl', true, true);
		$this->tpl->setVariable('cabezote', cargarCabezote());
		$this->tpl->setVariable('pie', cargarPie());
		$this->tpl->setVariable('URL_SITIO', URL_SITIO);
		$this->tpl->setVariable('queryHiddenSession', imprimirSessionString(FALSE));
		
		$arrayPeriodoAcademico = cargarArregloBD('Co_PeriodoAcademico', 'periodoacademico', 'periodosemestre', 'periodosemestre');
		$selectPeriodoAcademico = imprimirOpcionesArreglo($arrayPeriodoAcademico, '', 'Seleccionar...');
		//$selectPeriodoAcademico = imprimirOpcionesArreglo($arrayEstudiante, $this->model->periodoActual['periodoacademico'], 'Seleccionar...');
		$this->tpl->setVariable('selectPeriodoAcademico', $selectPeriodoAcademico);
		
		$selectPlanPagos = imprimirOpcionesArreglo(array(), '', 'Seleccionar...');
		$this->tpl->setVariable('selectPlanPagos', $selectPlanPagos);
		
		$selectCorte = imprimirOpcionesArreglo(array(), '', 'Seleccionar...');
		$this->tpl->setVariable('selectCorte', $selectCorte);
    }

    /**
     * Co_ConvenioListView::usrAprobar()
     *
     * Método que despliega una lista por pantalla para la interfaz de Usuario 
     * con el fin de aprobar los pagos de los convenios
     *
     * @param $arregloCampos
     * @return
     */
    function usrAprobar($filtros, $paginacion, $mensaje = '') {
    	global $estadoConvenio;
    	
    	$periodo = $filtros['filtroPeriodoAcademico'];
    	$estado = $filtros['filtroEstado'];
    	
    	$this->tpl->loadTemplateFile('lstAprobar.tpl', true, true);
    	$this->tpl->setVariable('cabezote', cargarCabezote());
    	$this->tpl->setVariable('pie', cargarPie());
    	$this->tpl->setVariable('URL_SITIO', URL_SITIO);
    	$this->tpl->setVariable('queryHiddenSession', imprimirSessionString(FALSE));
    	
    	$arrayPeriodoAcademico = cargarArregloBD('Co_PeriodoAcademico', 'periodoacademico', 'periodosemestre', 'periodosemestre');
    	$selectPeriodoAcademico = imprimirOpcionesArreglo($arrayPeriodoAcademico, $periodo, 'Seleccionar...');
    	$this->tpl->setVariable('selectPeriodoAcademico', $selectPeriodoAcademico);
    	
    	$selectEstado = imprimirOpcionesArreglo($estadoConvenio, $estado, 'Seleccionar...');
    	$this->tpl->setVariable('selectEstado', $selectEstado);
    	
    	if ($estado == 'C') {
    		$this->tpl->touchBlock('BOTONCREADO');
    	}
    	if (!empty($mensaje)) {
    		$this->tpl->setCurrentBlock("MENSAJE");
    		$this->tpl->setVariable('mensaje', $mensaje);
    		$this->tpl->parseCurrentBlock("MENSAJE");
    	}
    	
    	$this->tpl->setVariable('listadoAprobar', $this->mostrarListadoAprobar(array_merge($paginacion, $filtros)));
    }

    function mostrarListadoAprobar($arregloCampos) {
    	global $estadoConvenio;
    	$tpl = new HTML_Template_IT(TPL_DIR);
    	$tpl->loadTemplateFile('pagAprobar.tpl', true, true);
    	$noDatos = true;
    	foreach ($arregloCampos as $kCampo => $vCampo) {
    		$tpl->setVariable($kCampo, $vCampo);
    	}
    
    	$paginacion = $this->unPaginacion->mostrarPaginacion($arregloCampos);
    
    	$tpl->setVariable('paginacion', $paginacion);
    
    	$campos = $this->model->table();
    	while ($this->model->fetch()) {
    		if ($this->model->estado == 'C') {
    			$tpl->setCurrentBlock('CREADO');
    			$tpl->setVariable('convenioC', $this->model->convenio);
    			$tpl->parseCurrentBlock('CREADO');
    		} elseif ($this->model->estado == 'A') {
    			$tpl->touchBlock('APROBADO');
    		} else {
    			$tpl->touchBlock('GENERADO');
    		}
    		$tpl->setCurrentBlock('CONVENIO');
    		
    		foreach ($campos as $kCampo => $vCampo) {
    			$tpl->setVariable($kCampo, $this->model->$kCampo);
    		}
    		
    		$nombreEstudiante = $this->model->nombres . ' ' . $this->model->apellidos;
    		$tpl->setVariable('nombreEstudiante', $nombreEstudiante);
    		$tpl->setVariable('nombreDependencia', $this->model->nombredependencia);
    		$tpl->parseCurrentBlock('CONVENIO');
    		$noDatos = false;
    	}
    	if ($noDatos) {
    		$tpl->setCurrentBlock('NODATOS');
    		$tpl->setVariable('noDatos', "No hay monitorias disponibles");
    		$tpl->parseCurrentBlock('NODATOS');
    	}
    	return $tpl->get();
/*    
    	$noDatos = true;
    	while ($this->model->fetch()) {
    		if ($this->model->estado == 'C') {
    			$this->tpl->setCurrentBlock('CREADO');
    			$this->tpl->setVariable('convenioC', $this->model->convenio);
    			$this->tpl->parseCurrentBlock('CREADO');
    		} elseif ($this->model->estado == 'A') {
    			$this->tpl->touchBlock('APROBADO');
    		} else {
    			$this->tpl->touchBlock('GENERADO');
    		}
    		$this->tpl->setCurrentBlock('CONVENIO');
    		$this->setAtributos();
    		$nombreEstudiante = $this->model->nombres . ' ' . $this->model->apellidos;
    		$this->tpl->setVariable('nombreEstudiante', $nombreEstudiante);
    		$this->tpl->setVariable('nombreDependencia', $this->model->nombredependencia);
    		$this->tpl->parseCurrentBlock('CONVENIO');
    		$noDatos = false;
    	}
    	if ($noDatos) {
    		$this->tpl->setCurrentBlock('NODATOS');
    		$this->tpl->setVariable('noDatos', "No hay monitorias disponibles");
    		$this->tpl->parseCurrentBlock('NODATOS');
    	}
*/
    }
    
    /**
     * Co_ConvenioListView::generarPDF()
     *
     * Método que genera las cuentas de cobro en archivo PDF
     *
     * @param $arregloCampos
     * @return
     */
    function generarPDF($informacionPDF) {
    	global $tipoCuenta;
    
    	$pdf = new FPDF('P', 'mm', 'Letter');
    
    	// DATOS DEL DOCUMENTO
    	$pdf->SetCreator("monitorias.uniandes.edu.co - By DTI Uniandes");
    	$pdf->SetSubject('Monitorias');
    	$pdf->SetDisplayMode('real');
    	$pdf->SetTitle('Monitorias :: Contrato ');
    
    	foreach ($informacionPDF as $vInfPDF) {
    		// Configuración inicial del documento
    		$pdf->AddPage();
    
    		//ESTILO DEL DOCUMENTO
    		//Márgenes
    		$pdf->SetMargins(20, 20);
    		//Fuente, estilo y tamaño
    		$pdf->SetFont('Arial', '', 10);
    		//altura de línea de texto, en mm
    		$h = 5.5;
    		//Color de líneas
    		$pdf->SetDrawColor(153);
    		//Color de relleno:
    		$pdf->SetFillColor(153);
    		// Ancho de columna, para el texto (en mm): 216mm(carta)/2 - 20mm (margen)= 88mm
    		$w = 88;
    		//ancho columnas de tabla
    		$wCol3 = 60;
    		$wCol2 = 90;
    		$wCol21 = 150;
    		$wCol22 = 30;
    		$wCol41 = 50;
    		$wCol42 = 25;
    		$wCol43 = 80;
    		$wCol44 = 25;
    		//altura después de tabla
    		$hSalto = 28;
    		//config. zona firmas
    		$wFirma = 75;
    		$wEspacio = 26;
    		$hFirma = 4.0;
    		
    		// CONTENIDO DEL DOCUMENTO
    
    		// Línea necesaria para evitar un bug (primera línea fuera del margen)
    		$pdf->Ln($h);
    
    		// Encabezado
    		$pdf->SetFont('', 'B');
    		$pdf->Cell(0, $h, 'LA UNIVERSIDAD DE LOS ANDES', 0, 1, 'C');
    		$pdf->Cell(0, $h, 'NIT. 860.007.386-1', 0, 1, 'C');
    		$pdf->Ln();
    		$pdf->SetFont('', 'B', 12);
    		$pdf->Cell(0, $h, "MONITORIA No. " . str_pad($vInfPDF['consecutivo'], 4, '0', STR_PAD_LEFT), 0, 1, 'C');

    		$pdf->SetFont('', 'B', 9);
    		foreach ($vInfPDF['pago'] as $kPago => $vPago) {
    			$pdf->Cell(0, $h, "CONSECUTIVO PAGO " . ($kPago + 1) . ": "  . $vPago, 0, 1, 'C');
    		}
    		
    		$pdf->SetFont('','', 10);
    		$pdf->Ln();
    
    		$pdf->MultiCell(0, $h, PDF_TXT_1);
    		$pdf->Ln();
    		
    		$pdf->SetFont('Arial', '', 9);
    		$pdf->Cell($wCol3, $h, 'Apellidos: ' . $vInfPDF['apellidos'], 1, 0, 'L');
    		$pdf->Cell($wCol3, $h, 'Nombres: ' . $vInfPDF['nombres'], 1, 0, 'L');
    		$pdf->Cell($wCol3, $h, 'Código: ' . $vInfPDF['codigo'], 1, 1, 'L');
    		
    		$pdf->Cell($wCol3, $h, 'Tipo Doc.: ' . $vInfPDF['tipodocumento'], 1, 0, 'L');
    		$pdf->Cell($wCol3, $h, 'Documento: ' . $vInfPDF['documento'], 1, 0, 'L');
    		$pdf->Cell($wCol3, $h, 'Lugar Exp.: ' . $vInfPDF['expediciondoc'], 1, 1, 'L');
    		
    		$pdf->Cell($wCol2, $h, 'Dirección: ' . $vInfPDF['direccion'], 1, 0, 'L');
    		$pdf->Cell($wCol2, $h, 'Teléfono: ' . $vInfPDF['telefono'], 1, 1, 'L');
    		
    		$pdf->Cell($wCol3, $h, 'Ciudad: ' . $vInfPDF['ciudad'], 1, 0, 'L');
    		$pdf->Cell($wCol3, $h, 'Departamento: ' . $vInfPDF['departamento'], 1, 0, 'L');
    		$pdf->Cell($wCol3, $h, 'País: ' . $vInfPDF['pais'], 1, 1, 'L');
    		$pdf->Ln();
    		
    		$pdf->SetFont('Arial', '', 10);
    		$pdf->MultiCell(0, $h, PDF_TXT_2);
    		$pdf->Ln();
    		
    		$pdf->SetFont('', 'B');
    		$pdf->Cell($wCol2, $h, 'ACTIVIDAD', 0, 0, 'C');
    		$pdf->Cell($wCol2, $h, 'DISTRIBUCIÓN DEL AUXILIO', 0, 1, 'C');
    		$pdf->SetFont('', '');
    		
    		$posXIni = $pdf->GetX();
    		$posYIni = $pdf->GetY();
    		$pdf->MultiCell($wCol2, $h, $vInfPDF['actividad']);
    		$posXFin = $pdf->GetX();
    		$posYFin = $pdf->GetY();
    		$pdf->SetXY($posXIni + $wCol2, $posYIni);
    		$pdf->Cell($wCol2, $h, $vInfPDF['distribucion'], 0, 1, 'C');
    		$pdf->SetXY($posXFin, $posYFin);
    		$pdf->Ln();
    		
    		$pdf->Cell(0, $h, 'En:', 0, 1);
    		$pdf->Ln();
    		
    		if ($vInfPDF['labor'] == 'D') {
    			//	Materias
    			$pdf->SetFont('Arial', '', 9);
    			$pdf->Cell($wCol41, $h, 'CURSO', 1, 0, 'C', 1);
    			$pdf->Cell($wCol42, $h, 'SEC.', 1, 0, 'C', 1);
    			$pdf->Cell($wCol43, $h, 'NOMBRE', 1, 0, 'C', 1);
    			$pdf->Cell($wCol44, $h, 'HORAS', 1, 1, 'C', 1);
    			$totalHoras = 0;
    			foreach ($vInfPDF['materia'] as $vMateria) {
    				$arrayCurso = explode('_', $vMateria['curso']);
    				$pdf->Cell($wCol41, $h, $arrayCurso[0], 'LRB', 0, 'C');
    				$pdf->Cell($wCol42, $h, $arrayCurso[1], 'LRB', 0, 'C');
    				$pdf->Cell($wCol43, $h, $vMateria['nombrecurso'], 'LRB', 0, 'L');
    				$pdf->Cell($wCol44, $h, $vMateria['horassemanalescurso'], 'LRB', 1, 'C');
    				$totalHoras += $vMateria['horassemanalescurso'];
    			}
    			$pdf->Cell($wCol41, $h, '', 0, 0, 'C');
    			$pdf->Cell($wCol42, $h, '', 0, 0, 'C');
    			$pdf->SetFont('', 'B');
    			$pdf->Cell($wCol43, $h, 'TOTAL HORAS SEMANA', 'LRB', 0, 'L');
    			$pdf->Cell($wCol44, $h, $totalHoras, 'LRB', 1, 'C');
    		} else {
    			$pdf->SetFont('Arial', 'B', 9);
    			$pdf->Cell($wCol21, $h, 'DESCRIPCIÓN DE LA INVESTIGACIÓN', 0, 0, 'C');
    			$pdf->Cell($wCol22, $h, 'HORAS', 0, 1, 'C');
    			$pdf->SetFont('Arial', '', 9);

    			$posXIni = $pdf->GetX();
    			$posYIni = $pdf->GetY();
    			$pdf->MultiCell($wCol21, $h, $vInfPDF['descripcion']);
    			$posXFin = $pdf->GetX();
    			$posYFin = $pdf->GetY();
    			$pdf->SetXY($posXIni + $wCol21, $posYIni);
    			$pdf->Cell($wCol22, $h, $vInfPDF['horassemanales'], 0, 1, 'C');
    			$pdf->SetXY($posXFin, $posYFin);
    			
				if (!empty($vInfPDF['materia'][0]['curso'])) {
					//	Materia
					$pdf->SetFont('Arial', '', 9);
					$pdf->Cell($wCol41, $h, 'CURSO', 1, 0, 'C', 1);
					$pdf->Cell($wCol42, $h, 'SEC.', 1, 0, 'C', 1);
					$pdf->Cell($wCol43 + $wCol44, $h, 'NOMBRE', 1, 1, 'C', 1);
					foreach ($vInfPDF['materia'] as $vMateria) {
						$arrayCurso = explode('_', $vMateria['curso']);
						$pdf->Cell($wCol41, $h, $arrayCurso[0], 'LRB', 0, 'C');
						$pdf->Cell($wCol42, $h, $arrayCurso[1], 'LRB', 0, 'C');
						$pdf->Cell($wCol43 + $wCol44, $h, $vMateria['nombrecurso'], 'LRB', 1, 'L');
					}
				}
    		}
    		$pdf->SetFont('', '');
			$pdf->Ln();
    		
    		$pdf->Cell($wCol3, $h, 'Fecha Inicio: ' . $vInfPDF['fechainicio'], 1, 0, 'L');
    		$pdf->Cell($wCol3, $h, 'Fecha Final: ' . $vInfPDF['fechafin'], 1, 0, 'L');
    		$pdf->Cell($wCol3, $h, 'Auxilio Educativo: ' . $vInfPDF['valor'], 1, 1, 'L');
    		
    		$pdf->Cell($wCol3, $h, 'Entidad:' . $vInfPDF['banco'], 1, 0, 'L');
    		$pdf->Cell($wCol3, $h, 'Tipo Cuenta: ' . $tipoCuenta[$vInfPDF['tipocuenta']], 1, 0, 'L');
    		$pdf->Cell($wCol3, $h, 'No. Cuenta: ' . $vInfPDF['numerocuenta'], 1, 1, 'L');
    		
    		$pdf->Cell($wCol2 * 2, $h, 'Dependencia: ' . $vInfPDF['dependencia'], 1, 1, 'L');
    		if (empty($vInfPDF['dependenciapadre'])) {
    			$dependenciapadre = '';
    		} else {
    			$dependenciapadre = 'Facultad: ' . $vInfPDF['dependenciapadre'];
    			$pdf->Cell($wCol2 * 2, $h, $dependenciapadre, 1, 1, 'L');
    		}
    		$pdf->SetFont('Arial', '', 10);
    		$pdf->Ln();
    		
    		$pdf->MultiCell(0, $h, PDF_TXT_3);
    		$pdf->Ln();
    		
    		$pdf_txt_4 = str_replace('{dia}', date('j'), PDF_TXT_4) ;
    		$pdf_txt_4 = str_replace('{mes}', strftime('%B'), $pdf_txt_4) ;
    		$pdf_txt_4 = str_replace('{ano}', date('Y'), $pdf_txt_4) ;
    		$pdf->MultiCell(0, $h, $pdf_txt_4);
    		$pdf->Ln();
    		$pdf->Ln();
    		$pdf->Ln();
    		
    		$pdf->Cell($wFirma, $h, 'LA UNIVERSIDAD', 0, 0, 'C');
    		$pdf->Cell($wEspacio, $h, '');
    		$pdf->Cell($wFirma, $h, 'EL ESTUDIANTE', 0, 1, 'C');
    		$pdf->Ln();
    		$pdf->Ln();
    		$pdf->Ln();
    		$pdf->Ln();
    		$pdf->Ln();
    		
    		$pdf->SetFont('Arial', '', 9);
    		$pdf->Cell($wFirma, $hFirma, 'DIRECTOR DEL DEPARTAMENTO', 'T', 0, 'C');
    		$pdf->Cell($wEspacio, $hFirma, '');
    		$pdf->Cell($wFirma, $hFirma, $vInfPDF['nombres'] . ' ' . $vInfPDF['apellidos'], 'T', 1, 'L');
    		
    		$pdf->Cell($wFirma, $hFirma, '', 0, 0, 'C');
    		$pdf->Cell($wEspacio, $hFirma, '');
    		$pdf->Cell($wFirma, $hFirma, 'DOC. IDENT. No. ' . $vInfPDF['documento'], 0, 1, 'L');
    		
    		$pdf->Cell($wFirma, $hFirma, '', 0, 0, 'C');
    		$pdf->Cell($wEspacio, $hFirma, '');
    		$pdf->Cell($wFirma, $hFirma, 'CÓDIGO ' . $vInfPDF['codigo'], 0, 1, 'L');
    	}
    
    	// CREACION (SALIDA) DEL DOCUMENTO
    	$pdf->Output('ConEdu-Contrato' . date('YmdHis') . '.pdf', 'D');
    }
    
} // end Co_ConvenioListView

?>