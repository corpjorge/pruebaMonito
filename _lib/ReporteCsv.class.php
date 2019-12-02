<?php
require_once 'File/CSV.php';

class ReporteCsv {

	var $archivoCsv;
	var $conf;
	var $error;
	var $nombreArchivo;
	var $rutaArchivo;
	
	function ReporteCsv() {
	}
	
	function generarPagosConvenios(&$unObjeto){
		$this->conf = array(
			'fields' => 46,
			'sep' => "\t"
		);
		$estandarConvenios = PREFIJO;
		$this->archivoCsv = new File_CSV();
		$this->archivoCsv->_conf($this->error, $this->conf);
		$this->nombreArchivo = 'ZF-FI-AP-' . date('dmY') . '-' . $estandarConvenios .'-01.txt';
		$this->rutaArchivo = TMP_DIR . $this->nombreArchivo;
		
		$parametros = cargarArregloBD('Co_Parametro', 'nombre', 'valor', 'nombre', " NOMBRE LIKE 'ARCHIVO_P_%' ");

		$this->archivoCsv->getPointer($this->rutaArchivo, $this->conf, FILE_MODE_WRITE);
		$i = 1;
		while ($unObjeto->fetch()) {
			$referencia = $estandarConvenios . $unObjeto->convenio . $unObjeto->pago;
			$linea1 = array(
				0 => $i,
				1 => date('dmY'),
				2 => $parametros['ARCHIVO_P_CLASE_DOCUMENTO_LINEA_1'],
				3 => $parametros['ARCHIVO_P_SOCIEDAD_LINEA_1'],
				4 => date('dmY'),
				5 => date('m'),
				6 => $parametros['ARCHIVO_P_MONEDA_LINEA_1'],
				7 => '',
				8 => '',
				9 => $referencia,
				10 => $parametros['ARCHIVO_P_TEXTO_CABECERA_LINEA_1'],
				11 => $parametros['ARCHIVO_P_CLAVE_CONTABLE_LINEA_1'],
				12 => substr($unObjeto->documento, 0, 12),
				13 => '',
				14 => $parametros['ARCHIVO_P_CUENTA_CONTABLE_LINEA_1'],
				15 => round($unObjeto->valor, 0),
				16 => '',
				17 => $parametros['ARCHIVO_P_TIPO_RET1_LINEA_1'],
				18 => $parametros['ARCHIVO_P_IND_RET1_LINEA_1'],
				19 => '',
				20 => $parametros['ARCHIVO_P_TIPO_RET2_LINEA_1'],
				21 => $parametros['ARCHIVO_P_IND_RET2_LINEA_1'],
				22 => '',
				23 => '',
				24 => '',
				25 => '',
				26 => '',
				27 => '',
				28 => '',
				29 => '',
				30 => '',
				31 => '',
				32 => '',
				33 => '',
				34 => '',
				35 => '',
				36 => '',
				37 => '',
				38 => '',
				39 => '',
				40 => $parametros['ARCHIVO_P_CONDICION_PAGO_LINEA_1'],
				41 => substr($unObjeto->documento, 0, 12),
				42 => substr($unObjeto->tipomonitor, 0, 40),
				43 => '',
				44 => '',
				45 => ''
			);
			$linea2 = array(
				0 => $i,
				1 => date('dmY'),
				2 => $parametros['ARCHIVO_P_CLASE_DOCUMENTO_LINEA_1'],
				3 => $parametros['ARCHIVO_P_SOCIEDAD_LINEA_1'],
				4 => date('dmY'),
				5 => date('m'),
				6 => $parametros['ARCHIVO_P_MONEDA_LINEA_1'],
				7 => '',
				8 => '',
				9 => $referencia,
				10 => $parametros['ARCHIVO_P_TEXTO_CABECERA_LINEA_1'],
				11 => $parametros['ARCHIVO_P_CLAVE_CONTABLE_LINEA_2'],
				12 => $parametros['ARCHIVO_P_CODIGO_CUENTA_LINEA_2'],
				13 => '',
				14 => '',
				15 => round($unObjeto->valor, 0),
				16 => $parametros['ARCHIVO_P_INDICADOR_IMPUESTOS_LINEA_2'],
				17 => '',
				18 => '',
				19 => '',
				20 => '',
				21 => '',
				22 => '',
				23 => '',
				24 => '',
				25 => '',
				26 => $unObjeto->objetocosto,
				27 => '',
				28 => '',
				29 => '',
				30 => '',
				31 => '',
				32 => '',
				33 => '',
				34 => '',
				35 => '',
				36 => '',
				37 => $unObjeto->fondopresupuestal,
				38 => '',
				39 => '',
				40 => '',
				41 => substr($unObjeto->documento, 0, 12),
				42 => substr($unObjeto->tipomonitor, 0, 40),
				43 => '',
				44 => '',
				45 => ''
			);
			$this->archivoCsv->write($this->rutaArchivo, $linea1, $this->conf);
			$this->archivoCsv->write($this->rutaArchivo, $linea2, $this->conf);
			$i++;
		}
	}

	function generarCuentaConvenios(&$unObjeto){
		$this->conf = array(
				'fields' => 7,
				'sep' => "\t"
		);
		$estandarConvenios = 'ConEdu';
		$this->archivoCsv = new File_CSV();
		$this->archivoCsv->_conf($this->error, $this->conf);
		$this->nombreArchivo = 'Cuentas-Bancarias-' . date('dmY') . '-' . $estandarConvenios .'-' . date('Hi') . '.txt';
		$this->rutaArchivo = TMP_DIR . $this->nombreArchivo;
	
		$parametros = cargarArregloBD('Co_Parametro', 'nombre', 'valor', 'nombre', " NOMBRE LIKE 'ARCHIVO_C_%' ");
	
		$this->archivoCsv->getPointer($this->rutaArchivo, $this->conf, FILE_MODE_WRITE);
		while ($unObjeto->fetch()) {
			$linea = array(
					0 => substr($unObjeto->documento, 0, 16),
					1 => $unObjeto->pais,
					2 => $unObjeto->banco,
					3 => $unObjeto->cuenta,
					4 => $unObjeto->tipocuenta,
					5 => $parametros['ARCHIVO_C_TIP_BANCO_INTERL'],
					6 => substr($unObjeto->titular, 0, 60)
			);
			$this->archivoCsv->write($this->rutaArchivo, $linea, $this->conf);
		}
	}

	function enviarCsv() {
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$this->nombreArchivo");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		readfile($this->rutaArchivo);
		exit(0);
	}
	
}
?>