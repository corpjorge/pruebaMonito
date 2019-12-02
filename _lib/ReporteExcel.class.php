<?php
require_once 'Spreadsheet/Excel/Writer.php';

class ReporteExcel {

	var $workbook;
	var $worksheet;
	var $arrayFormatTitle;
	var $arrayFormatText;
	var $arrayFormatColumnName;
	var $arrayFormatNumber;
	var $arrayFormatString;

	function ReporteExcel($nombreArchivo) {
		$this->arrayFormatTitle = array(
			'Align' => 'center',
			'Bold' => '1',
			'Size' =>'9',
			'Border' => '0',
			'BorderColor' => 'black',
			'FontFamily' => 'Verdana'
		);
		$this->arrayFormatText = array(
			'Align' => 'left',
			'Size' =>'9',
			'Border' => '0',
			'FontFamily' => 'Verdana'
		);
		$this->arrayFormatColumnName = array(
			'Align' => 'center',
			'Bold' => '1',
			'Border' => '',
			'BorderColor' => 'black',
			'FontFamily' => 'Verdana'
		);
		$this->arrayFormatNumber = array(
			'Align' => 'center',
			'Border' => '0',
			'BorderColor' => 'black',
			'FontFamily' => 'Verdana'
		);
		$this->arrayFormatString = array(
			'Align' => 'left',
			'VAlign' => 'vcenter',
			'Border' => '0',
			'BorderColor' => 'black',
			'FontFamily' => 'Verdana'
		);
		$this->workbook = new Spreadsheet_Excel_Writer();
		$this->workbook->setTempDir(TMP_DIR);
		$this->workbook->setVersion(8);
		$this->workbook->send($nombreArchivo . '.xls');
	}

	function generarConvenios($convenios, $arregloCampos){
		global $tipoObjeto;
		global $estadoConvenio;
		$nombrePeriodoAcademico = 'TODOS';
		if (!empty($arregloCampos['periodoAcademico'])) {
			$periodoAcademico = $arregloCampos['periodoAcademico'];
			$periodosAcademicos = cargarArregloBD('Co_PeriodoAcademico', 'periodoacademico', 'periodosemestre', 'periodosemestre', " PERIODOACADEMICO = '$periodoAcademico' ");
			$nombrePeriodoAcademico = $periodosAcademicos[$periodoAcademico];
		}
		$nombreDependencia = 'TODAS';
		if (!empty($arregloCampos['dependencia'])) {
			$dependencia = $arregloCampos['dependencia'];
			$dependencias = cargarArregloBD('Co_Dependencia', 'dependencia', 'nombre', 'nombre', " DEPENDENCIA = '$dependencia' ");
			$nombreDependencia = $dependencias[$dependencia];
		}
		$nombreEstado = 'TODOS';
		if (!empty($arregloCampos['estado'])) {
			$estado = $arregloCampos['estado'];
			$nombreEstado = $estadoConvenio[$estado];
		}
		
		$formatTitle =& $this->workbook->addFormat($this->arrayFormatTitle);
		$formatText =& $this->workbook->addFormat($this->arrayFormatText);
		$formatColumnName =& $this->workbook->addFormat($this->arrayFormatColumnName);
		$formatNumber =& $this->workbook->addFormat($this->arrayFormatNumber);
		$formatString =& $this->workbook->addFormat($this->arrayFormatString);

		$nombreHoja = empty($dependencia)?'Hoja1':$dependencia;
		$this->worksheet =& $this->workbook->addWorksheet($nombreHoja);
		$this->worksheet->setRow(0, 15);
		
		$tcols = 14;
		$nrows = 0;
		$ncols = 0;
		
		$this->worksheet->writeString($nrows, $ncols++, 'UNIVERSIDAD DE LOS ANDES', $formatTitle);
		$this->worksheet->mergeCells($nrows, $ncols - 1, $nrows, $tcols);
		$nrows++;
		$ncols = 0;
		$this->worksheet->writeString($nrows, $ncols++, 'REPORTE CUENTAS DE COBRO', $formatTitle);
		$this->worksheet->mergeCells($nrows, $ncols - 1, $nrows, $tcols);
		$nrows++;
		$nrows++;
		$ncols = 0;
		$this->worksheet->writeString($nrows, $ncols++, 'PERIODOACADEMICO: ' . $nombrePeriodoAcademico, $formatTitle);
		$this->worksheet->mergeCells($nrows, $ncols - 1, $nrows, $tcols);
		$nrows++;
		$ncols = 0;
		$this->worksheet->writeString($nrows, $ncols++, 'DEPENDENCIA: ' . $nombreDependencia, $formatTitle);
		$this->worksheet->mergeCells($nrows, $ncols - 1, $nrows, $tcols);
		$nrows++;
		$ncols = 0;
		$this->worksheet->writeString($nrows, $ncols++, 'ESTADO: ' . $nombreEstado, $formatTitle);
		$this->worksheet->mergeCells($nrows, $ncols - 1, $nrows, $tcols);
		$nrows++;
		$nrows++;
		$ncols = 0;
		
		$this->worksheet->writeString($nrows, $ncols++, 'DOCUMENTO', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'CODIGO', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'APELLIDOS', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'NOMBRES', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'NUM. CONT.', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'VALOR', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'FORMA PAGO', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'LABOR', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'DEPENDENCIA', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'MATERIA', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'DESCRIPCION', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'HORAS SEMANALES', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'VALOR HORA', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'FECHA INICIO', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'FECHA FIN', $formatColumnName);
		//agrega columnas adicionales
		$this->worksheet->writeString($nrows, $ncols++, 'CODIGO TIPO PERIODO', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'DESCRIPCION TIPO PERIODO', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'FECHA PAGO 1', $formatColumnName);
		$this->worksheet->writeString($nrows, $ncols++, 'FECHA PAGO 2', $formatColumnName);
		
		$nrows++;
		
		foreach ($convenios as $convenio) {
/*
			$ncols = 0;
			$this->worksheet->writeString($nrows, $ncols++, $convenio['documento'], $formatString);
			$this->worksheet->writeString($nrows, $ncols++, $convenio['codigo'], $formatString);
			$this->worksheet->writeString($nrows, $ncols++, $convenio['apellidos'], $formatString);
			$this->worksheet->writeString($nrows, $ncols++, $convenio['nombres'], $formatString);
			$this->worksheet->writeString($nrows, $ncols++, $convenio['consecutivo'], $formatString);
			$this->worksheet->writeString($nrows, $ncols++, $convenio['valor'], $formatString);
			$this->worksheet->writeString($nrows, $ncols++, $convenio['distribucion'], $formatString);
			$this->worksheet->writeString($nrows, $ncols++, $convenio['labor'], $formatString);
			$this->worksheet->writeString($nrows, $ncols++, $convenio['nombredependencia'], $formatString);
*/
			if ($convenio['tipolabor'] == 'D') {
//				$numMaterias = count($convenio['materia']);
//				$primero = TRUE;
				foreach ($convenio['materia'] as $materia) {
//					if ($primero) {
//						for ($i = 0; $i < 8; $i++) {
//							$this->worksheet->mergeCells($nrows, $i, $nrows + $numMaterias - 1, $i);
//						}
//						$primero = FALSE;
//					} else {
//						$ncols = 8;
//					}

					$ncols = 0;
					$this->worksheet->writeString($nrows, $ncols++, $convenio['documento'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $convenio['codigo'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $convenio['apellidos'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $convenio['nombres'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $convenio['consecutivo'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $convenio['valor'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $convenio['distribucion'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $convenio['labor'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $convenio['nombredependencia'], $formatString);
					
					
					$this->worksheet->writeString($nrows, $ncols++, $materia['curso'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $materia['nombrecurso'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $materia['horassemanalescurso'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $materia['valorhoracurso'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $convenio['fechainicio'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $convenio['fechafin'], $formatString);
					//AGREGA COLUMNAS ADICIONALES
					$this->worksheet->writeString($nrows, $ncols++, $materia['tipoperiodo'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $materia['desctipoperiodo'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $materia['fechaprimerpago'], $formatString);
					$this->worksheet->writeString($nrows, $ncols++, $materia['fechasegundopago'], $formatString);
					$nrows++;
				}
			} else {
				$ncols = 0;
				$this->worksheet->writeString($nrows, $ncols++, $convenio['documento'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['codigo'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['apellidos'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['nombres'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['consecutivo'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['valor'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['distribucion'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['labor'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['nombredependencia'], $formatString);
				
				$curso = (!isset($convenio['materia'][0]['curso']) || empty($convenio['materia'][0]['curso']))?$convenio['labor']:$convenio['materia'][0]['curso'];
				$this->worksheet->writeString($nrows, $ncols++, $curso, $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['descripcion'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['horassemanales'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['valorhora'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['fechainicio'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $convenio['fechafin'], $formatString);
				//AGREGA COLUMNAS ADICIONALES
				$this->worksheet->writeString($nrows, $ncols++, $materia['tipoperiodo'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $materia['desctipoperiodo'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $materia['fechaprimerpago'], $formatString);
				$this->worksheet->writeString($nrows, $ncols++, $materia['fechasegundopago'], $formatString);
				$nrows++;
			}
		} // while
	}
		
	function cerrarArchivoExcel(){
		$this->workbook->close();
	}

}
?>