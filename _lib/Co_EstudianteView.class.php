<?php
/*
 * Co_EstudianteView
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
require_once 'HTML/Template/IT.php';
require_once 'Funciones.php';

class Co_EstudianteView {
    var $model;
    var $tpl;
    var $_interfaz;

    function Co_EstudianteView (&$model) {
        $this->model = &$model;
        $this->tpl = new HTML_Template_IT(TPL_DIR);
    } 

    function _Co_EstudianteView () {
    } 

	/**
	 * Co_EstudianteView::setAtributos()
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
	 * Co_EstudianteView::setValidacion()
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
	 * Co_EstudianteView::setMensaje()
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
     * Co_EstudianteView::display()
     * 
     * Método que despliega la información de uno o varios registros
     * 
     * @return 
     */
    function display () {
        $this->tpl->show();
    } 

    /**
     * Co_EstudianteView::get()
     * 
     * Método que captura la información de uno o varios registros
     * 
     * @return 
     */
    function get () {
        return $this->tpl->get();
    } 

} // end Co_EstudianteView

/*
 * Co_EstudianteItemView
 * 
 * Clase responsable de la definición de métodos de vista para la 
 * presentación de la información por pantalla 
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_EstudianteItemView extends Co_EstudianteView {

    /**
     * Co_EstudianteItemView::Co_EstudianteItemView()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_EstudianteItemView (&$model) {
        Co_EstudianteView::Co_EstudianteView($model);
    } 

    /**
     * Co_EstudianteItemView::_Co_EstudianteItemView()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_EstudianteItemView () {
    } 

    /**
     * Co_EstudianteItemView::mostrarValidacionEstudiante()
     * 
     * Método que despliega el formulario de validación de estudiante por pantalla
     * 
     * @return 
     */
    function mostrarValidacionEstudiante() {
    	$mensajeForma = NULL;
        $this->tpl->loadTemplateFile('frmValidacionEstudiante.tpl', true, true);
		$this->tpl->setVariable('cabezote', cargarCabezote());
		$this->tpl->setVariable('pie', cargarPie());

		$this->tpl->setVariable('codigo', $this->model->codigo);

		$this->tpl->setVariable('periodoacademico', $this->model->periodoActual['periodosemestre']);
		
 		$this->setValidacionEstudiante($mensajeForma);
 		if (!empty($mensajeForma)) {
			$this->tpl->setCurrentBlock("MENSAJE");
			$this->tpl->setVariable('mensaje', $mensajeForma);
			$this->tpl->parseCurrentBlock("MENSAJE");
 		}
    } 

	/**
	 * Co_EstudianteItemView::setValidacionEstudiante()
	 * 
	 * Remplaza los {tags} de validacion por las alertas respectivas, adicionalmente 
	 * carga la variable mensaje forma con la lista de errores ocurridos.
	 * 
	 * @param $mensajeForma
	 * @return 
	 **/
	function setValidacionEstudiante(& $mensajeForma){

        if (sizeof($this->model->validacion->acumuladoErrores) > 0) {
        	$errores = $this->model->validacion->acumuladoErrores;
			$mensajeForma .= '<ul>'. "\n";
			foreach ($errores as $campo => $mensaje) {
            	$this->tpl->setVariable('v' . $campo, muestreAlerta($mensaje));
				$mensajeForma .= "\t" .'<li>' . ucfirst(strtolower($mensaje)). "\n";
            }
			$mensajeForma .= '</ul>'. "\n";
        } else {
        	$muestreRequerido = muestreRequerido();
        	$this->tpl->setVariable('vcodigo', $muestreRequerido);
        	$this->tpl->setVariable('vdocumento', $muestreRequerido);
        	$this->tpl->setVariable('vperiodoacademico', $muestreRequerido);
        }
	}
    
    /**
     * Co_EstudianteItemView::usrMensaje()
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
     * Co_EstudianteItemView::mostrarInformacionEstudiante()
     * 
     * Método que despliega el formulario con la información del estudiante por pantalla
     * 
     * @return 
     */
    function mostrarInformacionEstudiante() {
    	global $genero;
    	
    	$mensajeForma = NULL;
        $this->tpl->loadTemplateFile('frmInformacionEstudiante.tpl', true, true);
		$this->tpl->setVariable('cabezote', cargarCabezote());
		$this->tpl->setVariable('pie', cargarPie());
		
		$this->setAtributos();

		$paises = cargarArregloBD('G_Pais', 'pais', 'nombre', 'nombre');
		$selectPais = imprimirOpcionesArreglo($paises, $this->model->pais, 'Seleccionar...');
		$this->tpl->setVariable('selectPais', $selectPais);
		
		$departamentos = cargarArregloBD('G_Departamento', 'departamento', 'nombre', 'nombre', " pais = '" . $this->model->pais . "' ");
		$selectDepartamento = imprimirOpcionesArreglo($departamentos, $this->model->departamento, 'Seleccionar...');
		$this->tpl->setVariable('selectDepartamento', $selectDepartamento);
		if (count($departamentos) < 1) {
			$this->tpl->setVariable('departamentoDisabled', ' disabled="disabled" ');;
		}
		
		$ciudades = cargarArregloBD('G_Ciudad', 'ciudad', 'nombre', 'nombre', " pais = '" . $this->model->pais . "' and departamento = '" . $this->model->departamento . "' ");
		$selectCiudad = imprimirOpcionesArreglo($ciudades, $this->model->ciudad, 'Seleccionar...');
		$this->tpl->setVariable('selectCiudad', $selectCiudad);
		if (count($ciudades) < 1) {
			$this->tpl->setVariable('ciudadDisabled', ' disabled="disabled" ');;
		}

		$tipoDocumento = cargarArregloBD('G_TipoDocumento', 'tipodocumento', 'nombre');
		$nombreTipoDocumento = $tipoDocumento[$this->model->tipodocumento];
		$this->tpl->setVariable('nombreTipoDocumento', $nombreTipoDocumento);
		
		$this->tpl->setVariable('nombreGenero', $genero[$this->model->genero]);
		
		$this->setValidacion($mensajeForma);
 		if (!empty($mensajeForma)) {
			$this->tpl->setCurrentBlock("MENSAJE");
			$this->tpl->setVariable('mensaje', $mensajeForma);
			$this->tpl->parseCurrentBlock("MENSAJE");
 		}
    }
    
} // end Co_EstudianteItemView

/*
 * Co_EstudianteListView
 * 
 * Clase responsable de la definición de métodos de vista para la 
 * presentación de una lista por pantalla 
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_EstudianteListView extends Co_EstudianteView {

    /**
     * Co_EstudianteListView::Co_EstudianteListView()
     * 
     * Método Constructor de la clase
     * 
     * @return 
     */
    function Co_EstudianteListView (&$model) {
        Co_EstudianteView::Co_EstudianteView($model);
    } 

    /**
     * Co_EstudianteListView::_Co_EstudianteListView()
     * 
     * Método Destructor de la clase
     * 
     * @return 
     */
    function _Co_EstudianteListView () {
    } 

    /**
     * Co_EstudianteListView::usrListar()
     * 
     * Método que despliega una lista por pantalla para la interfaz de Usuario
     * 
     * @param $arregloCampos
     * @return 
     */
    function usrListar() {
/*
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
*/
    } 

} // end Co_EstudianteListView

?>