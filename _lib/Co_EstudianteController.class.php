<?php

require_once("Co_Estudiante.class.php");
require_once("Co_EstudianteView.class.php");

/*
 * Co_EstudianteController
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_EstudianteController {
    var $model;
    var $view;
    var $_interfaz;

    /**
     * Co_EstudianteController::Co_EstudianteController()
     * 
     * @return 
     */
    function Co_EstudianteController () {
        $this->model = &new Co_Estudiante();
    } 

    /**
     * Co_EstudianteController::_Co_EstudianteController()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_EstudianteController () {
    } 

    /**
     * Co_EstudianteController::getView()
     * 
     * Método que obtiene la clase de vista a desplegar
     * 
     * @return 
     */
    function &getView () {
        return $this->view;
    } 
} // end Co_EstudianteController

/**
 * Co_EstudianteItemController
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 */
class Co_EstudianteItemController extends Co_EstudianteController {

	/**
     * Co_EstudianteItemController::Co_EstudianteItemController()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_EstudianteItemController () {
        Co_EstudianteController::Co_EstudianteController();
        $this->view = &new Co_EstudianteItemView($this->model);
    } 

    /**
     * Co_EstudianteItemController::_Co_EstudianteItemController()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_EstudianteItemController () {
    } 

	/**
     * Co_EstudianteItemController::usrForma()
     * 
	 * Prepara la forma 
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function usrForma($arregloCampos) {
		$this->model->buscar($arregloCampos['estudiante']);
		$this->view->usrForma();
	}

	/**
     * Co_EstudianteItemController::mostrarValidacionEstudiante()
     * 
	 * Prepara la forma 
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function mostrarValidacionEstudiante($arregloCampos) {
		$this->model->cargarPeriodoActual();
		list($dia, $mes, $ano) = explode('/', $this->model->periodoActual['fechalimite']);
		$numFechaLimite = mktime(0, 0, 0, $mes, $dia, $ano);
		$numFechaActual = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		if ($numFechaActual > $numFechaLimite) {
			$this->view->usrMensaje('No es posible crear la monitoria debido a que la fecha límite es ' . $this->model->periodoActual['fechalimite']);
		} else {
			$this->model->codigo = (isset($arregloCampos['codigo']) && !empty($arregloCampos['codigo']))?$arregloCampos['codigo']:'';
			$this->view->mostrarValidacionEstudiante();
		}
	}
	
	/**
     * Co_EstudianteItemController::validarEstudiante()
     * 
	 * Valida el estudiante
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function validarEstudiante($arregloCampos) {
        $tmp = explode("-", $arregloCampos['codigo']);
        $vice = false;
        if(count($tmp) > 1){

            $arregloCampos['codigo'] = $tmp[0];
            if($tmp[1] == 'VICE3001' || $tmp[1] == 'VICE3002'){
                $vice = true;
            }
           
        }
        
		$estudianteValido = true;
		if ($this->model->validarDatos($arregloCampos)) {
			$estudianteValido = $this->model->esEstudiantePregradoMatriculado() && $estudianteValido;
			//$estudianteValido = !$this->model->esEstudianteEnPruebaAcademica() && $estudianteValido;
			$estudianteValido = !$this->model->esEstudianteEnPruebaDiciplinaria() && $estudianteValido;
//			$estudianteValido = !$this->model->tieneContratoActivoLO() && $estudianteValido;
			$estudianteValido = !$this->model->tieneContratoActivoCT() && $estudianteValido;
			$estudianteValido = !$this->model->tieneContratoActivoCC() && $estudianteValido;
			$estudianteValido = $this->model->tieneEstadoValido() && $estudianteValido;
			$estudianteValido = $this->model->tieneHorasDisponibles($this->model->periodoacademico, $this->model->codigo, 1, '', $vice) && $estudianteValido;
		} else {
			$estudianteValido = false;
		}
		
		if (!$estudianteValido) {
			$this->mostrarValidacionEstudiante($arregloCampos);
		}

		return $estudianteValido;
	}

	/**
     * Co_EstudianteItemController::cargarInformacionEstudiante()
     * 
	 * Extrae la información del estudiante de la base de datos local o de BANNER
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function cargarInformacionEstudiante($arregloCampos) {
        $tmp = explode("-", $arregloCampos['codigo']);
        if(count($tmp) > 1){
            $arregloCampos['codigo'] = $tmp[0];
        }
		$datosBasicos = $this->model->cargarInformacionEstudianteCO($arregloCampos);
		if ($datosBasicos === FALSE || count($datosBasicos) < 1) {
			$datosBasicos = $this->model->cargarInformacionEstudianteBanner($arregloCampos);
		} else {
			$codigo = (isset($arregloCampos['codigo']) && !empty($arregloCampos['codigo']))?$arregloCampos['codigo']:'';
			$datosBasicosTmp = $this->model->cargarDatosBasicosBanner($codigo);
			$datosBasicos['documento'] = $datosBasicosTmp['documento'];
			$datosBasicos['tipodocumento'] = $datosBasicosTmp['tipodocumento'];
		}
		return $datosBasicos;
	}
	
	/**
     * Co_EstudianteItemController::mostrarInformacionEstudiante()
     * 
	 * Muestra el formulario de la información del estudiante
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function mostrarInformacionEstudiante($arregloCampos) {
		if (is_array($arregloCampos)) {
			$this->model->asignar($arregloCampos);
		}
		$this->view->mostrarInformacionEstudiante();
		return $this->view->get();
	}
	
	/**
     * Co_EstudianteItemController::insertarEstudiante()
     * 
	 * Muestra el formulario de la información del estudiante
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function insertarEstudiante($arregloCampos) {
		return $this->model->insertarEstudiante($arregloCampos);
	}
	
} 

/**
 * Co_EstudianteListController
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 */
class Co_EstudianteListController extends Co_EstudianteController {

	var $_registroComienzoPagina;
	var $_registroFinalPagina;
	var $_condicion;
	
    /**
     * Co_EstudianteListController::Co_EstudianteListController()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_EstudianteListController () {
        Co_EstudianteController::Co_EstudianteController();
        $this->view = &new Co_EstudianteListView($this->model);
    } 

    /**
     * Co_EstudianteListController::_Co_EstudianteListController()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_EstudianteListController () {
    } 

    /**
     * Co_EstudianteListController::usrListar()
     * 
     * @param mixed $arregloCampos
     * @param mixed $template
     * @return 
     **/
    function usrListar () {
        $this->model->listar(0, 0);
        $this->view->usrListar();
    } 

    /**
     * Co_EstudianteListController::usrCambioPais()
     * 
     * Genera el select de departamentos según el país para ser cargado a través de ajax
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrCambioPais($arregloCampos) {
    	$longitud = 40;
		$pais = (isset($arregloCampos['pais']) && !empty($arregloCampos['pais']))?$arregloCampos['pais']:'';
		$departamentos = cargarArregloBD('G_Departamento', 'departamento', 'nombre', 'nombre', " pais = '$pais'");
		if (is_array($departamentos)) {
			foreach ($departamentos as $kDepartamentos => $vDepartamentos) {
				$departamentos[$kDepartamentos] = htmlentities(substr($vDepartamentos, 0, $longitud)) . (strlen($vDepartamentos) > $longitud?'...':'');
			}
		} else {
			$departamentos = array();
		}
		return json_encode($departamentos);
    } 

    /**
     * Co_EstudianteListController::usrCambioDepartamento()
     * 
     * Genera el select de ciudades según el país para ser cargado a través de ajax
     * 
     * @param mixed $arregloCampos
     * @return 
     **/
    function usrCambioDepartamento($arregloCampos) {
    	$longitud = 40;
		$pais = (isset($arregloCampos['pais']) && !empty($arregloCampos['pais']))?$arregloCampos['pais']:'';
		$departamento = (isset($arregloCampos['departamento']) && !empty($arregloCampos['departamento']))?$arregloCampos['departamento']:'';
		$ciudades = cargarArregloBD('G_Ciudad', 'ciudad', 'nombre', 'nombre', " pais = '$pais' and departamento = '$departamento' ");
		if (is_array($ciudades)) {
			foreach ($ciudades as $kCiudad => $vCiudad) {
				$ciudades[$kCiudad] = htmlentities(substr($vCiudad, 0, $longitud)) . (strlen($vCiudad) > $longitud?'...':'');
			}
		} else {
			$ciudades = array();
		}
		return json_encode($ciudades);
    } 
    
}

?>