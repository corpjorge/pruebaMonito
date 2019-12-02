<?php
require_once 'HTML/Template/IT.php';

class Paginacion {

	var $totalRegistros = 0;
	var $regInicio = 0;
	var $regFin = 0;
	var $paginaActual = 0;
	var $numeroPaginas = 0;
	var $paginaInicial = 0;
	var $paginaFinal = 0;

	function Paginacion(){
	}

	function calcularPaginacion($arregloCampos) {
		$paginaActual = $arregloCampos['paginaActual'];
		$pagina = $arregloCampos['pagina'];
		$totalRegistros = $arregloCampos['totalRegistros'];
		$numeroRegistrosPagina = $arregloCampos['numeroRegistros'];
		$verPaginas = $arregloCampos['numeroPaginas'];
		
		$res = $totalRegistros % $numeroRegistrosPagina;
		$div = $totalRegistros / $numeroRegistrosPagina;
		$numeroPaginas = ($res > 0)?$div + 1:$div;
		$numeroPaginas = floor($numeroPaginas);
		if ($pagina == '<<') {
			$paginaActual = 1;
		} else if ($pagina == '<' && $paginaActual > 1) {
			$paginaActual--;
		} else if ($pagina == '>' && $paginaActual < $numeroPaginas) {
			$paginaActual++;
		} else if ($pagina == '>>') {
			$paginaActual = $numeroPaginas;
		}

		if ($paginaActual > $numeroPaginas) {
			$paginaActual = 1;
		}

		$regInicio = (($paginaActual - 1) * $numeroRegistrosPagina) + 1;
		$regFin = (($paginaActual - 1) * $numeroRegistrosPagina) + $numeroRegistrosPagina;

		$paginaInicial = 0;
		$paginaFinal = 0;
		$totalPaginas = ($verPaginas * 2) + 1;
		if ($paginaActual > $verPaginas) {
			if ($paginaActual > ($numeroPaginas - $verPaginas)) {
				$paginaFinal = $numeroPaginas;
				$paginaInicial = $numeroPaginas - $totalPaginas + 1;
				$paginaInicial = ($paginaInicial < 1)?1:$paginaInicial;
			} else {
				$paginaInicial = $paginaActual - $verPaginas;
				$paginaFinal = $paginaActual + $verPaginas;
			}
		} else {
			$paginaInicial = 1;
			$paginaFinal = ($numeroPaginas > $totalPaginas)?$totalPaginas:$numeroPaginas;
		}

//		$this->totalRegistros = $totalPaginas;
		$this->totalRegistros = $totalRegistros;
		$this->regInicio = $regInicio;
		$this->regFin = $regFin;
		$this->paginaActual = $paginaActual;
		$this->numeroPaginas = $numeroPaginas;
		$this->paginaInicial = $paginaInicial;
		$this->paginaFinal = $paginaFinal;
	}

	function mostrarPaginacion($arregloCampos) {
		$tpl = new HTML_Template_IT(TPL_DIR);
		$tpl->loadTemplateFile('paginacion.tpl', true, true);
	
		$tpl->setVariable('paginaActual', $this->paginaActual);
		$tpl->setVariable('numeroPaginas', $this->numeroPaginas);
		$tpl->setVariable('totalRegistros', $this->totalRegistros);
	
		for ($numPagina = $this->paginaInicial; $numPagina <= $this->paginaFinal; $numPagina++) {
			$classPagina = ($this->paginaActual == $numPagina)?"paginaActual":"pagina";
			$tpl->setCurrentBlock('PAGINA');
			$tpl->setVariable('classPagina', $classPagina);
			$tpl->setVariable('numPagina', $numPagina);
			$tpl->parseCurrentBlock('PAGINA');
		}
		return $tpl->get();
	}
	
}

	
?>