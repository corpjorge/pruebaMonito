<?php

require_once("Co_PeriodoAcademico.class.php");
require_once("Co_PeriodoAcademicoView.class.php");

/*
 * Co_PeriodoAcademicoController
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_PeriodoAcademicoController {
    var $model;
    var $view;
    var $_interfaz;

    /**
     * Co_PeriodoAcademicoController::Co_PeriodoAcademicoController()
     * 
     * @return 
     */
    function Co_PeriodoAcademicoController () {
        $this->model = &new Co_PeriodoAcademico();
    } 

    /**
     * Co_PeriodoAcademicoController::_Co_PeriodoAcademicoController()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_PeriodoAcademicoController () {
    } 

    /**
     * Co_PeriodoAcademicoController::getView()
     * 
     * Método que obtiene la clase de vista a desplegar
     * 
     * @return 
     */
    function &getView () {
        return $this->view;
    } 
} // end Co_PeriodoAcademicoController

/**
 * Co_PeriodoAcademicoItemController
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 */
class Co_PeriodoAcademicoItemController extends Co_PeriodoAcademicoController {

	/**
     * Co_PeriodoAcademicoItemController::Co_PeriodoAcademicoItemController()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_PeriodoAcademicoItemController () {
        Co_PeriodoAcademicoController::Co_PeriodoAcademicoController();
        $this->view = &new Co_PeriodoAcademicoItemView($this->model);
    } 

    /**
     * Co_PeriodoAcademicoItemController::_Co_PeriodoAcademicoItemController()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_PeriodoAcademicoItemController () {
    } 

    /**
     * Co_PeriodoAcademicoItemController::usrInsertar()
     * 
	 * Inserta un periodo
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function usrInsertar($arregloCampos) {
		if ($this->model->insertarPeriodo($arregloCampos)) {
			$this->view->usrMensaje('El Periodo Académico fue insertado exitosamente.');
		} else {
			$this->view->usrForma();
		}
	}

    /**
     * Co_PeriodoAcademicoItemController::usrActualizar()
     * 
	 * Actualiza un periodo
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function usrActualizar($arregloCampos) {
		if ($this->model->actualizarPeriodo($arregloCampos)) {
			$this->view->usrMensaje('El Periodo Académico fue actualizado exitosamente.');
		} else {
			$this->view->usrForma();
		}
	}

    /**
     * Co_PeriodoAcademicoItemController::usrEliminar()
     * 
	 * Actualiza un periodo
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function usrEliminar($arregloCampos) {
		$error = FALSE;
		$periodoAcademico = isset($arregloCampos['periodoacademico'])?$arregloCampos['periodoacademico']:'';
		if ($this->model->tieneConvenios($periodoAcademico)) {
			$error = TRUE;
		} else {
			if ($this->model->eliminarPlanPagos($arregloCampos)) {
				if (!$this->model->eliminarPeriodo($arregloCampos)) {
					$error = TRUE;
				}
			} else {
				$error = TRUE;
			}
		}
		if ($error) {
			$mensajeForma = NULL;
			$this->view->setValidacion($mensajeForma);
		} else {
			$mensajeForma = 'El periodo Académico fue eliminado exitosamente';
		}
		$this->view->usrMensaje($mensajeForma);
	}

	/**
     * Co_PeriodoAcademicoItemController::usrForma()
     * 
	 * Prepara la forma 
	 * 
     * @param $arregloCampos
     * @return 
     **/
	function usrForma($arregloCampos) {
		$this->model->buscar($arregloCampos['periodoacademico']);
		$this->model->buscarPlanPagos($arregloCampos['periodoacademico']);
		$this->view->usrForma();
	}
	
} 

/**
 * Co_PeriodoAcademicoListController
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 */
class Co_PeriodoAcademicoListController extends Co_PeriodoAcademicoController {

	var $_registroComienzoPagina;
	var $_registroFinalPagina;
	var $_condicion;
	
    /**
     * Co_PeriodoAcademicoListController::Co_PeriodoAcademicoListController()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_PeriodoAcademicoListController () {
        Co_PeriodoAcademicoController::Co_PeriodoAcademicoController();
        $this->view = &new Co_PeriodoAcademicoListView($this->model);
    } 

    /**
     * Co_PeriodoAcademicoListController::_Co_PeriodoAcademicoListController()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_PeriodoAcademicoListController () {
    } 

    /**
     * Co_PeriodoAcademicoListController::usrListar()
     * 
     * @param mixed $arregloCampos
     * @param mixed $template
     * @return 
     **/
    function usrListar () {
        $this->model->listar(0, 0);
        $this->view->usrListar();
    } 

}

?>