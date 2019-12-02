<?php

require_once("Co_Estudiante.php");
require_once("G_Pais.php");
require_once("G_Departamento.php");
require_once("G_Ciudad.php");
require_once("Co_PeriodoAcademico.class.php");
require_once("ClienteWebService.class.php");
require_once("Validacion.class.php");
/*
 * Co_Estudiante
 * 
 * @author Edwin Lasso <elasso@uniandes.edu.co>
 **/
class Co_Estudiante extends DOCo_Estudiante
{

	var $validacion;
	var $validacionCampos;
	var $periodosFuturos;
	var $periodoActual;
	var $arrayPais;

	/**
	 * M�todo Constructor de la clase
	 * 
	 * @return 
	 */
	function Co_Estudiante()
	{
		$this->validacionCampos = array(
			'nombres' => array(
				'fnc' => 'esCadenaValida',
				'max' => 250,
				'req' => true,
				'msg' => 'El nombre no es un dato válido.'
			),
			'apellidos' => array(
				'fnc' => 'esCadenaValida',
				'max' => 250,
				'req' => true,
				'msg' => 'El apellido no es un dato válido.'
			),
			'direccion' => array(
				'fnc' => 'esCadenaValida',
				'max' => 250,
				'req' => true,
				'msg' => 'La dirección no es un dato válido.'
			),
			'telefono' => array(
				'fnc' => 'esCadenaValida',
				'max' => 50,
				'req' => true,
				'msg' => 'El teléfono no es un dato válido.'
			),
			'email' => array(
				'fnc' => 'esCorreoValido',
				'max' => 100,
				'req' => true,
				'msg' => 'El correo electrónico no es un dato válido.'
			),
			'genero' => array(
				'fnc' => 'esCadenaValida',
				'max' => 1,
				'req' => true,
				'msg' => 'El genero no es un dato válido.'
			),
			'expediciondoc' => array(
				'fnc' => 'esCadenaValida',
				'max' => 100,
				'req' => true,
				'msg' => 'El lugar de expedición no es un dato válido.'
			),
			'codigo' => array(
				'fnc' => 'esCadenaValida',
				'max' => 16,
				'req' => true,
				'msg' => 'El código no es un dato válido.'
			),
			'documento' => array(
				'fnc' => 'esCadenaValida',
				'max' => 32,
				'req' => true,
				'msg' => 'El documento no es un dato válido.'
			),
			'estadoestudiante' => array(
				'fnc' => 'esCadenaValida',
				'max' => 32,
				'req' => true,
				'msg' => 'El estado del estudiante no es un dato válido.'
			),
			'ciudad' => array(
				'fnc' => 'esCadenaValida',
				'max' => 32,
				'req' => true,
				'msg' => 'La ciudad no es un dato válido.'
			),
			'departamento' => array(
				'fnc' => 'esCadenaValida',
				'max' => 32,
				'req' => true,
				'msg' => 'La departamento no es un dato válido.'
			),
			'pais' => array(
				'fnc' => 'esCadenaValida',
				'max' => 32,
				'req' => true,
				'msg' => 'La pais no es un dato válido.'
			),
			'tipodocumento' => array(
				'fnc' => 'esEntero',
				'max' => 32,
				'req' => true,
				'msg' => 'El tipo de documento no es un dato válido.'
			)
		);
		$this->validacion = &new Validacion($this);
	}

	/**
	 * Co_Estudiante::insertar()
	 * 
	 * @return 
	 */
	function insertar()
	{
		$this->insert();

		//Manejamos errores.
		if ($this->_lastError) {
			$this->validacion->acumuladoErrores['insertarEstudiante'] = 'Se produjo un error insertando el estudiante';
			return FALSE;
		} else {
			return TRUE;
		}
	} // end insertar  

	/**
	 * Co_Estudiante::insertarEstudiante()
	 * 
	 * @return 
	 */
	function insertarEstudiante($arregloCampos)
	{
		$returnValue = FALSE;
		if ($this->asignar($arregloCampos)) {
			if ($this->validar()) {
				if (empty($this->estudiante)) {
					$returnValue = $this->insertar();
				} else {
					$returnValue = $this->actualizar();
				}
			}
		}
		return $returnValue;
	}

	/**
	 * Co_Estudianteo::actualizar()
	 * 
	 * @return 
	 */
	function actualizar()
	{
		$clon = Co_Estudiante::staticGet($this->estudiante);
		$rows = 0;
		if ($clon) {
			$rows = $this->update($clon);
		}

		//Manejamos errores.
		if (
			$rows == 0
			|| ($this->_lastError && $this->_lastError->getCode() == DB_DATAOBJECT_ERROR_NODATA)
		) {
			$this->validacion->acumuladoErrores['actualizarEstudiante'] = 'No se encontro el Estudiante a Actualizar';
			return FALSE;
		} elseif ($this->_lastError) {
			$this->validacion->acumuladoErrores['actualizarEstudiante'] = 'No se pudo Actualizar el Estudiante';
			return FALSE;
		} else {
			return TRUE;
		}
	} // end actualizar

	/**
	 * Co_Estudiante::eliminar()
	 * 
	 * @param  $idEstudiante
	 * @return 
	 */
	function eliminar($id)
	{
		$this->estudiante = $id;
		$rows = $this->delete();
		//Manejamos errores.
		if ($this->_lastError) {
			$this->raiseError('No se pudo Eliminar el Estudiante!', 10004);
			return FALSE;
		} else {
			if ($rows === FALSE || $rows == 0) {
				$this->raiseError('No se encontro el Estudiante a Eliminar!', 10005);
				return FALSE;
			} else {
				return TRUE;
			}
		}
	} // end eliminar

	/**
	 * Co_Estudiante::buscar()
	 * 
	 * @param  $campoValorOperador 
	 * @return 
	 */
	function buscar($id)
	{
		$rows = $this->get($id);

		if ($this->_lastError) {
			$this->raiseError('No se pudo Buscar el Estudiante!', 10006);
			return FALSE;
		}

		if ($rows == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	} // end buscar

	/**
	 * Co_Estudiante::buscarPorParametro()
	 * 
	 * @param  
	 * @return 
	 */
	function buscarPorParametro($campo, $valor)
	{
		$this->$campo = $valor;
		$this->find();

		if ($this->_lastError) {
			$this->raiseError('No se pudo Buscar por parametro!', 10006);
			return FALSE;
		}

		if ($rows == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	} // end buscar

	/**
	 * Co_Estudiante::listar()
	 * 
	 * @param 
	 * @return 
	 */
	function listar($registroComienzoPagina, $registroFinalPagina, $condiciones = '')
	{
		if (!empty($condiciones)) {
			$this->whereAdd($condiciones);
		}
		$this->orderBy('estudiante');
		if ($registroComienzoPagina > 0 and $registroFinalPagina > 0) {
			$this->limit($registroComienzoPagina, $registroFinalPagina);
		}
		$this->find();
	} // end listar

	/**
	 * Co_Estudiante::asignar()
	 * 
	 * @param  $atributos 
	 * @return 
	 */
	function asignar($arregloCampos)
	{
		$llaves = $this->keys();
		foreach ($llaves as $unLlave) {
			$this->$unLlave = isset($arregloCampos[$unLlave]) ? $arregloCampos[$unLlave] : null;
		}
		$returnValue = $this->setFrom($arregloCampos);
		if ($returnValue) {
			return $returnValue;
		} else {
			$this->validacion->acumuladoErrores['insertarEstudiante'] = 'No se pudo asignar los valores de estudiante';
			return $returnValue;
		}
	} // end asignar    

	/**
	 * Co_Estudiante::validar()
	 * 
	 * @return 
	 */
	function validar()
	{
		$returnValue = true;
		$returnValue = $this->validacion->multiple($this->validacionCampos);
		return $returnValue;
	} // end validar  		 

	/**
	 * Co_Estudiante::cargarPeriodoActual()
	 *
	 * @return
	 */
	function cargarPeriodoActual()
	{
		$unPeriodoAcademico = new Co_PeriodoAcademico();
		$this->periodoActual = $unPeriodoAcademico->cargarPeriodoActual();
	}


	/**
	 * Co_Estudiante::validarDatos()
	 * 
	 * @return 
	 */
	function validarDatos($arregloCampos)
	{
		$datosValidos = TRUE;
		$this->codigo = (isset($arregloCampos['codigo']) && !empty($arregloCampos['codigo'])) ? $arregloCampos['codigo'] : '';
		$this->documento = '';
		if ($this->validacion->esNumero($this->codigo, 9, 'codigo', 'C�digo', true, 'C�digo no es un dato válido')) {
			$datosBasicos = $this->cargarDatosBasicosBanner($this->codigo);
			$this->documento = isset($datosBasicos['documento']) ? $datosBasicos['documento'] : '';
		} else {
			$datosValidos = FALSE;
		}
		$this->cargarPeriodoActual();
		$this->periodoacademico = $this->periodoActual['periodoacademico'];
		$datosValidos = $this->validacion->esCadenaValida($this->documento, 16, 'Documento', true, 'Documento no es un dato válido') && $datosValidos;
		$datosValidos = $this->validacion->esNumero($this->periodoacademico, 8, 'periodoacademico', 'Periodo Acad�mico', true, 'Periodo Acad�mico no es un dato válido') && $datosValidos;
		return $datosValidos;
	}

	/**
	 * Co_Estudiante::esEstudiantePregradoMatriculado()
	 * 
	 * Valida en BANNER si un estudiante se encuentra matr�culado en pregrado
	 * 
	 * @return 
	 */
	function esEstudiantePregradoMatriculado()
	{
		// return true;
		$esEstudiantePregradoMatriculado = FALSE;
		$unPeriodo = new Co_PeriodoAcademico();
		$unPeriodo->buscar($this->periodoacademico);
		$sentencia = "
			SELECT esEstudiantePrMatriculado@NIFE('" . $unPeriodo->periodosemestre . "', '" . $this->codigo . "') esMatriculado
			FROM DUAL
		";

		$unEstudiante = new Co_Estudiante();
		$unEstudiante->query($sentencia);
		if ($unEstudiante->fetch()) {
			if ($unEstudiante->esmatriculado == 'S') {
				$esEstudiantePregradoMatriculado = TRUE;
			}
		}

		if (!$esEstudiantePregradoMatriculado) {

			$periodoAcademico = $unPeriodo->periodosemestre;
			if (substr($unPeriodo->periodosemestre, -2) == "19" || substr($unPeriodo->periodosemestre, -2) == "18") {
				$periodoAcademico = substr($unPeriodo->periodosemestre, 0, 4) . "10";
			}

			$sentencia = "
    			SELECT esEstudiantePrMatriculado@NIFE('" . $periodoAcademico . "', '" . $this->codigo . "') esMatriculado
    			FROM DUAL
    		";

			$unEstudiante1 = new DB_DataObject();
			$unEstudiante1->query($sentencia);
			if ($unEstudiante1->fetch()) {
				if ($unEstudiante1->esmatriculado == 'S') {
					$esEstudiantePregradoMatriculado = TRUE;
				}
			}

			if (!$esEstudiantePregradoMatriculado) {
				$this->validacion->acumuladoErrores['esEstudiantePregradoMatriculado'] = 'El estudiante no est� matriculado en un programa de pregrado';
			}
		}
		return $esEstudiantePregradoMatriculado;
	}

	/**
	 * Co_Estudiante::esEstudianteEnPruebaAcademica()
	 * 
	 * Valida en BANNER si un estudiante se encuentra en prueba acad�mica
	 * 
	 * @return 
	 */
	function esEstudianteEnPruebaAcademica()
	{
		$esEstudianteEnPruebaAcademica = FALSE;
		$unPeriodo = new Co_PeriodoAcademico();
		$unPeriodo->buscar($this->periodoacademico);

		$sentencia = "
			SELECT esEstudianteEnPruebaA@NIFE('" . $unPeriodo->periodosemestre . "', '" . $this->codigo . "') esPruebaAcademica
			FROM DUAL
    	";
		$unEstudiante = new Co_Estudiante();
		$unEstudiante->query($sentencia);
		if ($unEstudiante->fetch()) {
			if ($unEstudiante->espruebaacademica == 'S') {
				$esEstudianteEnPruebaAcademica = TRUE;
			}
		}
		if ($esEstudianteEnPruebaAcademica) {
			$this->validacion->acumuladoErrores['esEstudianteEnPruebaAcademica'] = 'El estudiante se encuentra en prueba acad�mica';
		}
		return $esEstudianteEnPruebaAcademica;
	}

	/**
	 * Co_Estudiante::esEstudianteEnPruebaAcademicaValidar()
	 * 
	 * Valida en BANNER si un estudiante se encuentra en prueba acad�mica
	 * 
	 * @return 
	 */
	function esEstudianteEnPruebaAcademicaValidar($codigo = "")
	{
		$esEstudianteEnPruebaAcademica = FALSE;
		$unPeriodo = new Co_PeriodoAcademico();
		$unPeriodo->buscar($this->periodoacademico);
		$sentencia = "
			SELECT esEstudianteEnPruebaA@NIFE('" . $_SESSION['periodonombre'] . "', '" . $codigo . "') esPruebaAcademica
			FROM DUAL
    	";

		$unEstudiante = new Co_Estudiante();
		$unEstudiante->query($sentencia);
		if ($unEstudiante->fetch()) {
			if ($unEstudiante->espruebaacademica == 'S') {
				$esEstudianteEnPruebaAcademica = TRUE;
			}
		}
		if ($esEstudianteEnPruebaAcademica) {
			$this->validacion->acumuladoErrores['esEstudianteEnPruebaAcademica'] = 'El estudiante se encuentra en prueba acad�mica';
		}

		return $esEstudianteEnPruebaAcademica;
	}

	/**
	 * Co_Estudiante::esEstudianteEnPruebaDiciplinaria()
	 * 
	 * Valida en BANNER si un estudiante se encuentra en prueba diciplinaria
	 * 
	 * @return 
	 */
	function esEstudianteEnPruebaDiciplinaria()
	{
		$esEstudianteEnPruebaDiciplinaria = FALSE;
		$unPeriodo = new Co_PeriodoAcademico();
		$unPeriodo->buscar($this->periodoacademico);

		$sentencia = "
			SELECT esEstudianteEnPruebaD@NIFE('" . $unPeriodo->periodosemestre . "', '" . $this->codigo . "') esPruebaDiciplinaria
			FROM DUAL
    	";
		$unEstudiante = new Co_Estudiante();
		$unEstudiante->query($sentencia);
		if ($unEstudiante->fetch()) {
			if ($unEstudiante->espruebadiciplinaria == 'S') {
				$esEstudianteEnPruebaDiciplinaria = TRUE;
			}
		}
		if ($esEstudianteEnPruebaDiciplinaria) {
			$this->validacion->acumuladoErrores['esEstudianteEnPruebaDiciplinaria'] = 'El estudiante se encuentra en prueba diciplinaria';
		}
		return $esEstudianteEnPruebaDiciplinaria;
	}

	/**
	 * Co_Estudiante::tieneContratoActivoLO()
	 * 
	 * Valida en Labores Ocasionales si un estudinate tiene contrato activo
	 * 
	 * @return 
	 */
	function tieneContratoActivoLO()
	{
		$tieneContratoActivoLO = FALSE;
		$unPeriodo = new Co_PeriodoAcademico();
		$unPeriodo->buscar($this->periodoacademico);
		$sentencia = "
			SELECT COUNT(*) CONTRATOS 
			FROM LO_ESTUDIANTE E, LO_INSCRIPCION I, LO_LABOR L, LO_PERIODOACADEMICO P
			WHERE E.ESTUDIANTE = I.ESTUDIANTE
			  AND I.LABOR = L.LABOR
			  AND P.PERIODOACADEMICO = L.PERIODOACADEMICO
			  AND P.ESTADO = 'A'
			  AND P.PERIODOSEMESTRE = '" . $unPeriodo->periodosemestre . "'
			  AND E.CODIGO = '" . $this->codigo . "'
			  AND I.ESTADO IN ('C', 'S')
			  AND TO_DATE(L.FECHA, 'DD/MM/YYYY') >= TO_DATE(SYSDATE, 'DD/MM/YYYY')
		";
		$this->query($sentencia);
		if ($this->fetch()) {
			if (!empty($this->contratos) && $this->contratos > 0) {
				$tieneContratoActivoLO = TRUE;
			}
		}
		if ($tieneContratoActivoLO) {
			$this->validacion->acumuladoErrores['tieneContratoActivoLO'] = 'El estudiante tiene un contrato activo en Labores Ocasionales';
		}
		return $tieneContratoActivoLO;
	}

	/**
	 * Co_Estudiante::tieneContratoActivoCT()
	 * 
	 * Valida en SAP si un estudiante tiene un contrato de trabajo activo
	 * 
	 * @return 
	 */
	function tieneContratoActivoCT()
	{
		global $estadoLaboral;
		$tieneContratoActivoCT = FALSE;
		$unEmpleado = new ClienteWebService();
		$datosEmpleado = $unEmpleado->consultaInfoEmpleado($this->documento);

		if ($datosEmpleado && $datosEmpleado != "N") {
			$estadoLaboralTemp = isset($datosEmpleado->ESTADO_LABORAL) ? $datosEmpleado->ESTADO_LABORAL : '';
			if (!empty($estadoLaboralTemp) && !array_key_exists($estadoLaboralTemp, $estadoLaboral)) {
				$tieneContratoActivoCT = TRUE;
			}
		} else if ($datosEmpleado && $datosEmpleado == "N") {
			$tieneContratoActivoCT = FALSE;
		} elseif ($datosEmpleado === FALSE) {
			$this->validacion->acumuladoErrores['tieneContratoActivoCT'] = 'No fue posible consultar el estado del contrato de trabajo';
			return TRUE;
		}

		if ($tieneContratoActivoCT) {
			$this->validacion->acumuladoErrores['tieneContratoActivoCT'] = 'El estudiante tiene un contrato de trabajo activo con la universidad';
		}
		return $tieneContratoActivoCT;
	}

	/**
	 * Co_Estudiante::tieneContratoActivoCC()
	 * 
	 * Valida en SAP si un estudiante tiene un contrato civil activo
	 * 
	 * @return 
	 */
	function tieneContratoActivoCC()
	{
		$tieneContratoActivoCC = FALSE;
		$unClienteWS = new ClienteWebService();
		$contratoCivil = $unClienteWS->contratoService($this->documento);
		if (isset($contratoCivil) && $contratoCivil == 'S') {
			$tieneContratoActivoCC = TRUE;
		} elseif ($contratoCivil === FALSE) {
			unset($contratoCivil);
			$contratoCivil = $unClienteWS->contratoCivilConsultar($this->documento);

			if (!($contratoCivil === FALSE)) {
				$contrato = isset($contratoCivil) ? $contratoCivil : '';
				if ($contrato == 'S') {
					$tieneContratoActivoCC = TRUE;
				}
			} else {
				$this->validacion->acumuladoErrores['tieneContratoActivoCC'] = 'No fue posible consultar el estado del contrato civil';
				return TRUE;
			}
		}
		if ($tieneContratoActivoCC) {
			$this->validacion->acumuladoErrores['tieneContratoActivoCC'] = 'El estudiante tiene un contrato civil activo con la universidad';
		}
		return $tieneContratoActivoCC;
	}

	/**
	 * Co_Estudiante::tieneEstadoValido()
	 * 
	 * Trae el estado del estudiante de BANNER y valida si est� dentro de los estados válidos
	 * 
	 * @return 
	 */
	function tieneEstadoValido()
	{
		$tieneEstadoValido = FALSE;
		$unPeriodo = new Co_PeriodoAcademico();
		$unPeriodo->buscar($this->periodoacademico);

		$sentencia = "
			SELECT pk_estudiante.estado@NIFE('" . $this->codigo . "', '" . $unPeriodo->periodosemestre . "') estado
			FROM DUAL
    	";
		$unEstudiante = new Co_Estudiante();
		$unEstudiante->query($sentencia);
		if ($unEstudiante->fetch()) {
			$estadosBanner[] = $unEstudiante->estado;
		}
		$estadoEstudiante = cargarArregloBD('Co_EstadoEstudiante', 'estadoestudiante', 'nombre', '', "activo = 'S'");
		foreach ($estadosBanner as $estado) {
			if (array_key_exists($estado, $estadoEstudiante)) {
				$tieneEstadoValido = TRUE;
				continue;
			}
		}
		if (!$tieneEstadoValido) {
			$this->validacion->acumuladoErrores['tieneEstadoValido'] = 'El estado del estudiante no se encuentra entre los estados válidos para ser monitor';
		}
		return $tieneEstadoValido;
	}

	/**
	 * Co_Estudiante::tieneHorasDisponibles()
	 * 
	 * Valida si el estudiante tiene horas disponibles por semana
	 * 
	 * @return 
	 */
	function tieneHorasDisponibles($periodoAcademico, $codigo, $cantidad = 0, $convenio = '', $vice = false)
	{
		$tieneHorasDisponibles = TRUE;
		$unPeriodo = new Co_PeriodoAcademico();
		$unPeriodo->buscar($periodoAcademico);
		$condicion = '';
		if (!empty($convenio)) {
			$condicion = " AND C.CONVENIO NOT IN ($convenio) ";
		}
		/*
		* Jhonatan Holguín
		* Permite llevar la cuenta por periodo 8A y 8B
		*/
		$total = array(
			'p1' => $cantidad,
			'p2' => $cantidad,
		);

		$sentenciaI = "
			SELECT C.HORASSEMANALES AS CANTIDAD, N.CODE_PARTE_PERIODO AS TIPO_PERIODO
			FROM CO_CONVENIO C, CO_ESTUDIANTE E, CO_TIPOLABOR L, CO_MATERIA M, MATERIA@NIFE N
			WHERE E.ESTUDIANTE = C.ESTUDIANTE
			  AND C.TIPOLABOR = L.TIPOLABOR
			  AND C.CONVENIO = M.CONVENIO
			  AND N.mat_semestre = '{$unPeriodo->periodosemestre}'
			  AND M.CRN = N.crn
			  AND N.SECCION = (select TO_NUMBER(regexp_substr(M.CURSO, '[^_]+', 1, 2)) as SECCION from dual) 		  
			  AND C.PERIODOACADEMICO = $periodoAcademico
			  AND E.CODIGO = '$codigo'
			  AND C.ESTADO <> 'N'
			  AND L.LABOR = 'I'
			  $condicion
		";
		$unEstudianteI = new Co_Estudiante();
		//echo $sentenciaI . '<br/>';
		$unEstudianteI->query($sentenciaI);

		while ($unEstudianteI->fetch()) {
			//echo $unEstudianteI->tipo_periodo;
			if ($unEstudianteI->tipo_periodo == '8A') { //lo suma en el primer periodo
				$total['p1'] += $unEstudianteI->cantidad;
			} elseif ($unEstudianteI->tipo_periodo == '8B') { //lo suma en el segundo periodo
				$total['p2'] += $unEstudianteI->cantidad;
			} else { //si no 8A u 8B, lo suma en los 2
				$total['p1'] += $unEstudianteI->cantidad;
				$total['p2'] += $unEstudianteI->cantidad;
			}
			$cantidad += $unEstudianteI->cantidad;
		}
		/*
		echo '<pre>';
		var_dump($total);
		echo '</pre>';
		* Se modificala el query para cruzar con MATERIAS@NIFE y obtener el campo CODE_PARTE_PERIODO
		*/
		$sentencia2 = "
			SELECT M.HORASSEMANALES AS CANTIDAD, N.CODE_PARTE_PERIODO AS TIPO_PERIODO
			FROM CO_CONVENIO C, CO_ESTUDIANTE E, CO_TIPOLABOR L, CO_MATERIA M, MATERIA@NIFE N
			WHERE E.ESTUDIANTE = C.ESTUDIANTE
			  AND C.TIPOLABOR = L.TIPOLABOR
			  AND C.CONVENIO = M.CONVENIO
			  AND N.mat_semestre = '{$unPeriodo->periodosemestre}'
			  AND M.CRN = N.crn
			  AND N.SECCION = (select TO_NUMBER(regexp_substr(M.CURSO, '[^_]+', 1, 2)) as SECCION from dual) 		  
			  AND C.PERIODOACADEMICO = $periodoAcademico
			  AND E.CODIGO = '$codigo'
			  AND C.ESTADO <> 'N'
			  AND L.LABOR = 'D'
			  $condicion
		";

		$unEstudiante2 = new Co_Estudiante();
		//echo $sentencia2 . '<br/>';
		$unEstudiante2->query($sentencia2);
		while ($unEstudiante2->fetch()) {
			//echo $unEstudianteI->tipo_periodo;
			if ($unEstudiante2->tipo_periodo == '8A') { //lo suma en el primer periodo
				$total['p1'] += $unEstudiante2->cantidad;
			} elseif ($unEstudiante2->tipo_periodo == '8B') { //lo suma en el segundo periodo
				$total['p2'] += $unEstudiante2->cantidad;
			} else { //si no 8A u 8B, lo suma en los 2
				$total['p1'] += $unEstudiante2->cantidad;
				$total['p2'] += $unEstudiante2->cantidad;
			}
			$cantidad += $unEstudiante2->cantidad;
		}
		/*
		echo '<pre>';
		var_dump($total);
		echo '</pre>';die();
		* Verifica según la cantidad de horas
		*/
		if (!$vice) {
			if ((int) $unPeriodo->maxhoras < $total['p1'] && (int) $unPeriodo->maxhoras < $total['p2']) {
				$this->validacion->acumuladoErrores['tieneHorasDisponibles'] = 'El estudiante excede el maximo de ' . $unPeriodo->maxhoras . ' horas. permitidas para el periodo. Se han consumido: ' . (empty($unEstudiante1->cantidad) ? '' : ' [' . $unEstudiante1->cantidad . ' horas en Investigacion] ') . (empty($unEstudiante2->cantidad) ? '' : ' [' . $unEstudiante2->cantidad . ' horas en Docencia] ');
				$tieneHorasDisponibles = FALSE;
			}
		} else {

			if (24 < $total['p1'] && 24 < $total['p2']) {
				$this->validacion->acumuladoErrores['tieneHorasDisponibles'] = 'El estudiante excede el maximo de 24 horas permitidas para el periodo. Se han consumido: ' . (empty($unEstudiante1->cantidad) ? '' : ' [' . $unEstudiante1->cantidad . ' horas en Investigacion] ') . (empty($unEstudiante2->cantidad) ? '' : ' [' . $unEstudiante2->cantidad . ' horas en Docencia] ');
				$tieneHorasDisponibles = FALSE;
			}
		}
		return $tieneHorasDisponibles;
	}


	/**
	 * Co_Estudiante::tieneHorasDisponiblesXPeriodo()
	 * 
	 * Cristian Arenas  05-08-2019
	 * Valida si el estudiante tiene horas disponibles por periodo, para periodo 8A y 8B se valida cada una
	 * segun el maximo horas por semestre, en caso diferente de 8A y 8B, se valida por el maximo de horas por semestre 
	 * 
	 * @return 
	 */
	function tieneHorasDisponiblesXPeriodo($periodoAcademico, $codigo, $cantidad = array(), $convenio = '', $vice = false)
	{
		/*
		* Cristian Arenas  05-08-2019
		* Permite agregar la cantidad de horas puestas en el formulario la cuenta por periodo 8A y 8B
		*/
		$total = array("p1" => 0, "p2" => 0, "otro" => 0);
		$totalxMonitoria = array("D" => 0, "I" => 0);
		$tieneHorasDisponibles = TRUE;
		$unPeriodo = new Co_PeriodoAcademico();
		$unPeriodo->buscar($periodoAcademico);
		$condicion = '';
		if (!empty($convenio)) {
			$condicion = " AND C.CONVENIO NOT IN ($convenio) ";
		}

		/*
		* Cristian Arenas  05-08-2019
		* Permite agregar la cantidad de horas puestas en el formulario la cuenta por periodo 8A y 8B
		*/
		foreach ($cantidad as $tipoPeriodo => $cantidad) {
			if ($tipoPeriodo == '8A') { //lo suma en el primer periodo
				$total['p1'] += $cantidad;
			} else if ($tipoPeriodo == '8B') { //lo suma en el segundo periodo
				$total['p2'] += $cantidad;
			} else { //si no 8A u 8B, su comportamiento es normal
				$total['otro'] += $cantidad;
			}
		}

		/*
		* Jhonatan Holgu�n
		* Permite llevar la cuenta por periodo 8A y 8B
		* 2019-08-12 -> Se Modfica la consulta para filtrar por la seccion del curso entre Co_MATERIA y MATERIA@NIFE
		*/
		$sentencia1 = "
			SELECT C.HORASSEMANALES AS CANTIDAD, N.CODE_PARTE_PERIODO AS TIPO_PERIODO
			FROM CO_CONVENIO C, CO_ESTUDIANTE E, CO_TIPOLABOR L, CO_MATERIA M, MATERIA@NIFE N
			WHERE E.ESTUDIANTE = C.ESTUDIANTE
			  AND C.TIPOLABOR = L.TIPOLABOR
			  AND C.CONVENIO = M.CONVENIO 
			  AND M.CRN = N.crn			  
              AND N.SECCION = (select TO_NUMBER(regexp_substr(M.CURSO, '[^_]+', 1, 2)) as SECCION from dual) 		  
			  AND N.mat_semestre = '{$unPeriodo->periodosemestre}'
			  AND C.PERIODOACADEMICO = $periodoAcademico
			  AND E.CODIGO = '$codigo'
			  AND C.ESTADO <> 'N'
			  AND L.LABOR = 'I'
			  $condicion
		";
		$unEstudiante1 = new Co_Estudiante();
		$unEstudiante1->query($sentencia1);

		while ($unEstudiante1->fetch()) {
			//echo $unEstudianteI->tipo_periodo;
			if ($unEstudiante1->tipo_periodo == '8A') { //lo suma en el primer periodo
				$total['p1'] += $unEstudiante1->cantidad;
			} elseif ($unEstudiante1->tipo_periodo == '8B') { //lo suma en el segundo periodo
				$total['p2'] += $unEstudiante1->cantidad;
			}
				
			$total['otro'] += $unEstudiante1->cantidad;//si no 8A u 8B, lo suma en otros
			$totalxMonitoria["I"] += $unEstudiante1->cantidad;
		}

		/*
		* Se modificala el query para cruzar con MATERIAS@NIFE y obtener el campo CODE_PARTE_PERIODO
		* 2019-08-12 -> Se Modfica la consulta para filtrar por la seccion del curso entre Co_MATERIA y MATERIA@NIFE
		*/
		$sentencia2 = "
			SELECT M.HORASSEMANALES AS CANTIDAD, N.CODE_PARTE_PERIODO AS TIPO_PERIODO
			FROM CO_CONVENIO C, CO_ESTUDIANTE E, CO_TIPOLABOR L, CO_MATERIA M, MATERIA@NIFE N
			WHERE E.ESTUDIANTE = C.ESTUDIANTE
			  AND C.TIPOLABOR = L.TIPOLABOR
			  AND C.CONVENIO = M.CONVENIO
			  AND M.CRN = N.crn	
			  AND N.SECCION = (select TO_NUMBER(regexp_substr(M.CURSO, '[^_]+', 1, 2)) as SECCION from dual) 
			  AND N.mat_semestre = '{$unPeriodo->periodosemestre}' 
              AND C.PERIODOACADEMICO = $periodoAcademico 
			  AND E.CODIGO = '$codigo'
			  AND C.ESTADO <> 'N'
			  AND L.LABOR = 'D'
			  $condicion
		";

		$unEstudiante2 = new Co_Estudiante();
		$unEstudiante2->query($sentencia2);

		while ($unEstudiante2->fetch()) {
			//echo $unEstudianteI->tipo_periodo;
			if ($unEstudiante2->tipo_periodo == '8A') { //lo suma en el primer periodo
				$total['p1'] += $unEstudiante2->cantidad;
			} elseif ($unEstudiante2->tipo_periodo == '8B') { //lo suma en el segundo periodo
				$total['p2'] += $unEstudiante2->cantidad;
			} 

			$total['otro'] += $unEstudiante2->cantidad;//si no 8A u 8B, lo suma en otros
			$totalxMonitoria["D"] += $unEstudiante2->cantidad;
		}
		/*
		echo '<pre>';
		var_dump($total);
		echo '</pre>';die();
		* Verifica seg�n la cantidad de horas
		*/

		if (!$vice) {
			/*
			* Cristian Arenas  05-08-2019
			* Valida la cantidad de horas por materias puestas en el formulario por periodo 8A y 8B
			*/
			if ((int) $unPeriodo->maxhoras < $total['p1']) {
				$this->validacion->acumuladoErrores['tieneHorasDisponibles'] = 'El estudiante excede el maximo de ' . $unPeriodo->maxhoras . ' horas permitidas para el periodo 8A ' . $unPeriodo->periodosemestre . '. Se han consumido: ' . ($totalxMonitoria["I"] == 0 ? '' : ' [' . $totalxMonitoria["I"] . ' horas en Investigacion] ') . ($totalxMonitoria["D"] == 0 ? '' : ' [' . $totalxMonitoria["D"] . ' horas en Docencia] ');
				$tieneHorasDisponibles = FALSE;
			} else if ((int) $unPeriodo->maxhoras < $total['p2']) {
				$this->validacion->acumuladoErrores['tieneHorasDisponibles'] = 'El estudiante excede el maximo de ' . $unPeriodo->maxhoras . ' horas permitidas para el periodo 8B ' . $unPeriodo->periodosemestre . '. Se han consumido: ' . ($totalxMonitoria["I"] == 0 ? '' : ' [' . $totalxMonitoria["I"] . ' horas en Investigacion] ') . ($totalxMonitoria["D"] == 0 ? '' : ' [' . $totalxMonitoria["D"] . ' horas en Docencia] ');
				$tieneHorasDisponibles = FALSE;
			} else if ((int) $unPeriodo->maxhoras < $total['otro']) {
				$this->validacion->acumuladoErrores['tieneHorasDisponibles'] = 'El estudiante excede el maximo de ' . $unPeriodo->maxhoras . ' horas permitidas para el periodo ' . $unPeriodo->periodosemestre . '. Se han consumido: ' . ($totalxMonitoria["I"] == 0 ? '' : ' [' . $totalxMonitoria["I"] . ' horas en Investigacion] ') . ($totalxMonitoria["D"] == 0 ? '' : ' [' . $totalxMonitoria["D"] . ' horas en Docencia] ');
				$tieneHorasDisponibles = FALSE;
			}
		} else {
			if (24 < $total['p1'] && 24 < $total['p2']) {
				$this->validacion->acumuladoErrores['tieneHorasDisponibles'] = 'El estudiante excede el maximo de 24 horas permitidas para el periodo ' . $unPeriodo->periodosemestre . '. Se han consumido: ' . (empty($unEstudiante1->cantidad) ? '' : ' [' . $unEstudiante1->cantidad . ' horas en Investigacion] ') . (empty($unEstudiante2->cantidad) ? '' : ' [' . $unEstudiante2->cantidad . ' horas en Docencia] ');
				$tieneHorasDisponibles = FALSE;
			}
		}

		return $tieneHorasDisponibles;
	}

	/**
	 * Co_Estudiante::cargarInformacionEstudianteCO()
	 * 
	 * Extrae la información del estudiante de la base de datos local (Convenios)
	 * 
	 * @return 
	 */
	function cargarInformacionEstudianteCO($arregloCampos)
	{
		$informacionEstudiante = array();
		$codigo = (isset($arregloCampos['codigo']) && !empty($arregloCampos['codigo'])) ? $arregloCampos['codigo'] : '';
		$sentencia = "
			SELECT 
			  E.ESTUDIANTE,
			  E.NOMBRES,
			  E.APELLIDOS,
			  E.DIRECCION,
			  E.TELEFONO,
			  E.EMAIL,
			  E.GENERO,
			  E.EXPEDICIONDOC,
			  E.CODIGO,
			  E.DOCUMENTO,
			  E.TIPODOCUMENTO,
			  E.ESTADOESTUDIANTE,
			  E.CIUDAD,
			  E.DEPARTAMENTO,
			  E.PAIS
			FROM CO_ESTUDIANTE E
			WHERE E.CODIGO = '$codigo'
    	";
		$unEstudiante = new Co_Estudiante();
		$unEstudiante->query($sentencia);
		if ($unEstudiante->_lastError) {
			$unEstudiante->raiseError('No se pudo Buscar los datos b�sicos del estudiante en CO!', 10006);
		}
		if ($unEstudiante->fetch()) {
			$informacionEstudiante = $unEstudiante->toArray();
		}
		return $informacionEstudiante;
	}

	/**
	 * Co_Estudiante::cargarInformacionEstudianteBanner()
	 * 
	 * Extrae la información del estudiante de la base de datos BANNER
	 * 
	 * @return 
	 */
	function cargarInformacionEstudianteBanner($arregloCampos)
	{
		$codigo = (isset($arregloCampos['codigo']) && !empty($arregloCampos['codigo'])) ? $arregloCampos['codigo'] : '';
		$informacionEstudiante = $this->cargarDatosBasicosBanner($codigo);
		$informacionEstudiante = array_merge($informacionEstudiante, $this->cargarTelefonoBanner($codigo));
		$informacionEstudiante = array_merge($informacionEstudiante, $this->cargarEmailBanner($codigo));
		return $informacionEstudiante;
	}

	/**
	 * Co_Estudiante::cargarDatosBasicosBanner()
	 * 
	 * Extrae los datos básicos del estudiante de la base de datos BANNER
	 * 
	 * @return 
	 */
	function cargarDatosBasicosBanner($codigo)
	{
		global $tipoDocumentoBanner;
		$datosBasicos = array();
		$sentencia = "
			SELECT DISTINCT 
			  SPRIDEN_LAST_NAME APELLIDOS,
			  RTRIM(SPRIDEN_FIRST_NAME||' '||SPRIDEN_MI) NOMBRES,
			  SPBPERS_SEX GENERO,
			  PKG_COMUN.F_TIPO_DOC_IDENT(SPRIDEN_PIDM) TIPODOCUMENTO,
			  SPBPERS_SSN DOCUMENTO,
			  SPRADDR_STREET_LINE1 DIRECCION,
			  SPRADDR_ACTIVITY_DATE
			FROM SPRIDEN@PROD_MANOBI,
			  SPRADDR@PROD_MANOBI,
			  SPBPERS@PROD_MANOBI
			WHERE SPRIDEN_PIDM = SPRADDR_PIDM (+)
			  AND SPRIDEN_PIDM = SPBPERS_PIDM
			  AND SPRIDEN_CHANGE_IND IS NULL
			  AND SPRADDR_STATUS_IND IS NULL
			  AND SPRADDR_ATYP_CODE = 'RE'
			  AND SPRIDEN_ID = '$codigo'
			ORDER BY SPRADDR_ACTIVITY_DATE DESC
		";
		$unBanner = new Co_Estudiante();
		$unBanner->query($sentencia);
		if ($unBanner->fetch()) {
			$datosBasicos['apellidos'] = $unBanner->apellidos;
			$datosBasicos['nombres'] = $unBanner->nombres;
			$datosBasicos['genero'] = $unBanner->genero;
			$datosBasicos['documento'] = $unBanner->documento;
			$datosBasicos['tipodocumento'] = isset($tipoDocumentoBanner[$unBanner->tipodocumento]) ? $tipoDocumentoBanner[$unBanner->tipodocumento] : '';
			$datosBasicos['direccion'] = $unBanner->direccion;
		}
		return $datosBasicos;
	}

	/**
	 * Co_Estudiante::cargarTelefonoBanner()
	 * 
	 * Extrae el teléfono del estudiante de la base de datos BANNER
	 * 
	 * @return 
	 */
	function cargarTelefonoBanner($codigo)
	{
		$telefono = array();
		$sentencia = "
			SELECT DISTINCT 
			  SPRTELE_PHONE_NUMBER TELEFONO
			FROM SPRIDEN@PROD_MANOBI,
			  SPRTELE@PROD_MANOBI
			WHERE SPRIDEN_PIDM = SPRTELE_PIDM
			  AND SPRTELE_STATUS_IND IS NULL
			  AND SPRIDEN_ID = '$codigo'
			  AND SPRTELE_TELE_CODE = 'RE'
		";
		$unBanner = new Co_Estudiante();
		$unBanner->query($sentencia);
		if ($unBanner->fetch()) {
			$telefono['telefono'] = $unBanner->telefono;
		}
		return $telefono;
	}

	/**
	 * Co_Estudiante::cargarEmailBanner()
	 * 
	 * Extrae el email del estudiante de la base de datos BANNER
	 * 
	 * @return 
	 */
	function cargarEmailBanner($codigo)
	{
		$email = array();
		$sentencia = "
			SELECT GOREMAL_EMAIL_ADDRESS EMAIL
			FROM SPRIDEN@PROD_MANOBI,
			  GOREMAL@PROD_MANOBI 
			WHERE SPRIDEN_PIDM = GOREMAL_PIDM  (+)
			  AND GOREMAL_EMAL_CODE = 'EUNI'
			  AND SPRIDEN_ID = '$codigo'
		";
		$unBanner = new Co_Estudiante();
		$unBanner->query($sentencia);
		if ($unBanner->fetch()) {
			$email['email'] = $unBanner->email;
		}
		return $email;
	}
} // end Co_Estudiante
