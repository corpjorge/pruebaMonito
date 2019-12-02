{cabezote}
<script language="JavaScript" src="./js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" SRC="./js/popup.js" TYPE="text/javascript"></script>
<script language="JavaScript">
	var url = "{URL_SITIO}index.php?{queryHiddenSession}";
	function enviarForma(accion, convenio) {
		if (accion == "Salir") {
			document.getElementById("accion").value = accion;
			document.getElementById('frmConvenio').submit();
		} else {
			switch (accion) {
				case 'Insertar':
					document.getElementById("accion").value = '';
					document.getElementById("controlador").value = "Item";
					document.getElementById("metodo").value = "usrSolicitarConvenio";
					document.getElementById('frmConvenio').submit();
					break;
				case 'Actualizar':
					document.getElementById("accion").value = 'mostrarConvenio';
					document.getElementById("controlador").value = "Item";
					document.getElementById("metodo").value = "usrActualizarConvenio";
					document.getElementById("convenio").value = convenio;
					document.getElementById('frmConvenio').submit();
					break;
				case 'Eliminar':
					if (confirm("¿Está seguro que desea eliminar la monitoria?")) {
						document.getElementById("accion").value = accion;
						document.getElementById("controlador").value = "Item";
						document.getElementById("metodo").value = "usrEliminarConvenio";
						document.getElementById("convenio").value = convenio;
						document.getElementById('frmConvenio').submit();
					}
					break;
				case 'MostrarPDF':
					var queryConvenio = '';
					if (convenio == 0 || convenio == '') {
						if (validarLista()) {
							queryConvenio = "&" + $("input[@name=convenios]:checked").serialize();
						} else {
							return false;
						}
					} else {
						queryConvenio = "&convenios[]=" + convenio;
					}
					var windowprops = "location=no,scrollbars=yes,menubar=no,toolbar=no,resizable=yes" + ",left=" + 10 + ",top=" + 10 + ",width=" + 120 + ",height=" + 80;
					popup = window.open(url + "&clase=Convenio&controlador=List&metodo=usrMostrarPDF&accion=" + accion + queryConvenio,"winPopup",windowprops);
					popup.focus();
					break;
/*				case 'MostrarReporteCsv':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "List";
					document.getElementById("metodo").value = "usrReporteCsv";
					document.getElementById('frmConvenio').submit();
					break;
				case 'Aprobar':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "List";
					document.getElementById("metodo").value = "usrAprobar";
					document.getElementById('frmConvenio').submit();
					break;*/
				case 'Listar':
					if (validarForma()) {
						document.getElementById("accion").value = accion;
						document.getElementById("controlador").value = "List";
						document.getElementById("metodo").value = "usrListar";
						document.getElementById('frmConvenio').submit();
					}
					break;
				case 'GenerarReporte':
					if (validarForma()) {
						var filtroPeriodoAcademico = "&filtroPeriodoAcademico=" + document.getElementById("filtroPeriodoAcademico").value;
						var filtroDependencia = "&filtroDependencia=" + document.getElementById("filtroDependencia").value;
						var filtroEstado = "&filtroEstado=" + document.getElementById("filtroEstado").value;
						var filtroCodigo = "&filtroCodigo=" + document.getElementById("filtroCodigo").value;
						var windowprops = "location=no,scrollbars=yes,menubar=no,toolbar=no,resizable=yes" + ",left=" + 20 + ",top=" + 20 + ",width=" + 120 + ",height=" + 80;
						popup = window.open(url + "&clase=Convenio&controlador=List&metodo=usrReporteConvenios&accion=generar" + filtroPeriodoAcademico + filtroDependencia + filtroEstado + filtroCodigo,"winPopup",windowprops);
						popup.focus();
					}
					break;
			}
		}
	}

	function validarForma(){
		if (document.getElementById("filtroPeriodoAcademico").value == ""){
			alert('Por favor ingrese los parámetros de búsqueda');
			return false;
		}
		return true;
	}
	
	function validarLista(){
		if ($("input[@name=convenios]:checked").length == 0) {
			alert('Por favor seleccione los convenios');
			return false;
		}
		return true;
	}

	function marcarDesmarcar () {
		if ($("#seleccionar").is(":checked")) {
			$("input:checkbox").attr('checked', true);
		} else {
			$("input:checkbox").removeAttr("checked");
		}
	} 

</script>

<form name="frmConvenio" id="frmConvenio" method="post" action="">
<table border="0" cellpadding="0" cellspacing="2" width="100%">
  <tr>
	<td align="center" valign="middle"><h1>Listado de Monitorias</h1></td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap>Periodo Acad&eacute;mico {vperiodoacademico}:&nbsp;
      <select name="filtroPeriodoAcademico" id="filtroPeriodoAcademico">
        {selectPeriodoAcademico}
      </select>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap>Dependencia {vfiltrodependencia}:&nbsp;
      <select name="filtroDependencia" id="filtroDependencia">
        {selectDependencia}
      </select>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap>Estado {vfiltroestado}:&nbsp;
      <select name="filtroEstado" id="filtroEstado">
        {selectEstado}
      </select>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap>C&oacute;digo Estudiante {vfiltrocodigo}:&nbsp;
      <input type="text" name="filtroCodigo" id="filtroCodigo" size="12" value="{filtroCodigo}" maxlength= "9" />
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle">
      <input type="button" name="consultar" id="consultar" value="Consultar" class="button" onClick="javascript:enviarForma('Listar');" />&nbsp;
      <input type="button" name="mostrarpdf" id="mostrarpdf" value="Mostrar PDF" class="button" onClick="javascript:enviarForma('MostrarPDF', 0);" />&nbsp;
      <input type="button" name="generarreporte" id="generarreporte" value="Generar Reporte Excel" class="button" onClick="javascript:enviarForma('GenerarReporte', 0);" />&nbsp;
      
      <!-- <input type="button" name="insertar" id="insertar" value="Insertar" class="button" onClick="javascript:enviarForma('Insertar', 0);" />
      <input type="button" name="reporte" id="reporte" value="Reporte" class="button" onClick="javascript:enviarForma('MostrarReporteCsv', 0);" />
      <input type="button" name="aprobar" id="aprobar" value="Aprobar Pagos" class="button" onClick="javascript:enviarForma('Aprobar', 0);" /> -->
      <input type="hidden" name="accion" id="accion" value="" />
      <input type="hidden" name="clase" id="clase" value="Convenio" />
      <input type="hidden" name="controlador" id="controlador" value="" />
      <input type="hidden" name="metodo" id="metodo" value="" />
      <input type="hidden" name="convenio" id="convenio" value="0" />
    </td>
  </tr>
</table>
<div id="divListadoConvenios">
  {listadoConvenios}
</div>
</form>
{pie}