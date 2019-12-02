<?php
/*
 * Co_PeriodoAcademicoView
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
require_once 'HTML/Template/IT.php';
require_once 'Funciones.php';

class Co_PeriodoAcademicoView {
    var $model;
    var $tpl;
    var $_interfaz;

    function Co_PeriodoAcademicoView (&$model) {
        $this->model = &$model;
        $this->tpl = new HTML_Template_IT(TPL_DIR);
    } 

    function _Co_PeriodoAcademicoView () {
    } 

	/**
	 * Co_PeriodoAcademicoView::setAtributos()
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
	 * Co_PeriodoAcademicoView::setValidacion()
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
	 * Co_PeriodoAcademicoView::setMensaje()
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
     * Co_PeriodoAcademicoView::display()
     * 
     * Método que despliega la información de uno o varios Periodo Academico
     * 
     * @return 
     */
    function display () {
        $this->tpl->show();
    } 

    /**
     * Co_PeriodoAcademicoView::get()
     * 
     * Método que captura la información de uno o varias Periodo Academico
     * 
     * @return 
     */
    function get () {
        return $this->tpl->get();
    } 

} // end Co_PeriodoAcademicoView

/*
 * Co_PeriodoAcademicoItemView
 * 
 * Clase responsable de la definición de métodos de vista para la 
 * presentación de la información por pantalla 
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_PeriodoAcademicoItemView extends Co_PeriodoAcademicoView {

    /**
     * Co_PeriodoAcademicoItemView::Co_PeriodoAcademicoItemView()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_PeriodoAcademicoItemView (&$model) {
        Co_PeriodoAcademicoView::Co_PeriodoAcademicoView($model);
    } 

    /**
     * Co_PeriodoAcademicoItemView::_Co_PeriodoAcademicoItemView()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_PeriodoAcademicoItemView () {
    } 

    /**
     * Co_PeriodoAcademicoItemView::usrForma()
     * 
     * Método que despliega la información por pantalla
     * 
     * @return 
     */
    function usrForma() {
    	$mensajeForma = NULL;
        $this->tpl->loadTemplateFile('frmPeriodoAcademico.tpl', true, true);
		$this->tpl->setVariable('cabezote', cargarCabezote());
		$this->tpl->setVariable('pie', cargarPie());
 		$this->setAtributos();
 		$accionDB = 'Actualizar';
 		if (empty($this->model->periodoacademico)) {
 			$accionDB = 'Insertar';
 		}
 		$this->tpl->setVariable('accionDB', $accionDB);
 		
 		$planpagos0 = isset($this->model->planpagos[0]['planpagos'])?$this->model->planpagos[0]['planpagos']:'';
 		$this->tpl->setVariable('planpagos0', $planpagos0);
 		$aplicafechalimite0 = isset($this->model->planpagos[0]['aplicafechalimite'])?$this->model->planpagos[0]['aplicafechalimite']:'';

 		$porcentajepagos0 = isset($this->model->porcentajepagos[0]['porcentajepagos'])?$this->model->porcentajepagos[0]['porcentajepagos']:'';
 		$this->tpl->setVariable('porcentajepagos0', $porcentajepagos0);
 		$fecha0 = isset($this->model->porcentajepagos[0]['fecha'])?$this->model->porcentajepagos[0]['fecha']:'';
 		$this->tpl->setVariable('fecha0', $fecha0);
 		
 		$planpagos1 = isset($this->model->planpagos[1]['planpagos'])?$this->model->planpagos[1]['planpagos']:'';
 		$this->tpl->setVariable('planpagos1', $planpagos1);
 		$aplicafechalimite1 = isset($this->model->planpagos[1]['aplicafechalimite'])?$this->model->planpagos[1]['aplicafechalimite']:'';
 		$aplicafechalimite1Checked = ($aplicafechalimite1 == 'S')?'CHECKED':'';
 		$this->tpl->setVariable('aplicafechalimite1Checked', $aplicafechalimite1Checked);
 		$porcentajepagos1 = isset($this->model->porcentajepagos[1]['porcentajepagos'])?$this->model->porcentajepagos[1]['porcentajepagos']:'';
 		$this->tpl->setVariable('porcentajepagos1', $porcentajepagos1);
 		$fecha1 = isset($this->model->porcentajepagos[1]['fecha'])?$this->model->porcentajepagos[1]['fecha']:'';
 		$this->tpl->setVariable('fecha1', $fecha1);
 		$this->tpl->setVariable('fechaPrimerCorte', $fecha1);
 		$porcentajepagos2 = isset($this->model->porcentajepagos[2]['porcentajepagos'])?$this->model->porcentajepagos[2]['porcentajepagos']:'';
 		$this->tpl->setVariable('porcentajepagos2', $porcentajepagos2);
 		$fecha2 = isset($this->model->porcentajepagos[2]['fecha'])?$this->model->porcentajepagos[2]['fecha']:'';
 		$this->tpl->setVariable('fecha2', $fecha2);
 		$this->tpl->setVariable('fechaSegundoCorte', $fecha2);
 		
 		$this->setValidacion($mensajeForma);
 		if (!empty($mensajeForma)) {
			$this->tpl->setCurrentBlock("MENSAJE");
			$this->tpl->setVariable('mensaje', $mensajeForma);
			$this->tpl->parseCurrentBlock("MENSAJE");
 		}
    } 

    /**
     * Co_PeriodoAcademicoItemView::usrMensaje()
     * 
     * Método que despliega un mensaje por pantalla
     * 
     * @return 
     */
    function usrMensaje($mensaje) {
        $this->tpl->loadTemplateFile('frmMensaje.tpl', true, true);
		$this->tpl->setVariable('cabezote', cargarCabezote());
		$this->tpl->setVariable('pie', cargarPie());
 		$this->tpl->setVariable('clase', 'PeriodoAcademico');
 		$this->tpl->setVariable('controlador', 'List');
 		$this->tpl->setVariable('metodo', 'usrListar');
 		$this->tpl->setVariable('mensaje', $mensaje);
    }
    
} // end Co_PeriodoAcademicoItemView

/*
 * Co_PeriodoAcademicoListView
 * 
 * Clase responsable de la definición de métodos de vista para la 
 * presentación de una lista por pantalla 
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_PeriodoAcademicoListView extends Co_PeriodoAcademicoView {

    /**
     * Co_PeriodoAcademicoListView::Co_PeriodoAcademicoListView()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_PeriodoAcademicoListView (&$model) {
        Co_PeriodoAcademicoView::Co_PeriodoAcademicoView($model);
    } 

    /**
     * Co_PeriodoAcademicoListView::_Co_PeriodoAcademicoListView()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_PeriodoAcademicoListView () {
    } 

    /**
     * Co_PeriodoAcademicoListView::listar()
     * 
     * Método que despliega una lista por pantalla para la interfaz de Usuario
     * 
     * @param $arregloCampos
     * @return 
     */
    function usrListar() {
        $this->tpl->loadTemplateFile('lstPeriodoAcademico.tpl', true, true);
		$this->tpl->setVariable('cabezote', cargarCabezote());
		$this->tpl->setVariable('pie', cargarPie());
        
        $noDatos = true;
        while ($this->model->fetch()) {
            $this->tpl->setCurrentBlock('PERIODOACADEMICO');
			$this->setAtributos();
			$this->tpl->parseCurrentBlock('PERIODOACADEMICO');
			$noDatos = false;
        }
		if ($noDatos) {
            $this->tpl->setCurrentBlock('NODATOS');
			$this->tpl->setVariable('noDatos', "No se encontró ningún Periodo Académico!!!");
            $this->tpl->parseCurrentBlock('NODATOS');
		}
    } 

} // end Co_PeriodoAcademicoListView

?>