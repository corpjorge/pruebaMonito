{cabezote}
<script language="JavaScript" src="./js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="./js/jquery.format.1.05.js" type="text/javascript"></script>
<script language="JavaScript" src="./js/desplegables.js" type="text/javascript"></script>
<script language="JavaScript" SRC="./js/popup.js" TYPE="text/javascript"></script>
<script language="JavaScript">
	var url = "{URL_SITIO}index.php?{queryHiddenSession}";
	function enviarForma(accion) {
		if (accion != "Salir") {
			switch (accion) {
			case 'generarPagosCsv':
				if (validarForma()) {
					var periodoAcademico = "&periodoacademico=" + document.getElementById("periodoacademico").value;
					var corte = "&corte=" + document.getElementById("corte").value;
					var windowprops = "location=no,scrollbars=yes,menubar=yes,toolbar=yes,resizable=yes" + ",left=" + 20 + ",top=" + 20 + ",width=" + 120 + ",height=" + 80;
					popup = window.open(url + "&clase=Convenio&controlador=List&metodo=usrReporteCsv&accion=generarPagosCsv" + periodoAcademico + corte,"winPopup",windowprops);
					popup.focus();
				}
				break;
			case 'generarCuentasCsv':
				if (validarForma()) {
					var periodoAcademico = "&periodoacademico=" + document.getElementById("periodoacademico").value;
					var corte = "&corte=" + document.getElementById("corte").value;
					var windowprops = "location=no,scrollbars=yes,menubar=yes,toolbar=yes,resizable=yes" + ",left=" + 20 + ",top=" + 20 + ",width=" + 120 + ",height=" + 80;
					popup = window.open(url + "&clase=Convenio&controlador=List&metodo=usrReporteCsv&accion=generarCuentasCsv" + periodoAcademico + corte,"winPopup",windowprops);
					popup.focus();
				}
				break;
			case 'listarConvenio':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "List";
					document.getElementById("metodo").value = "usrListar";
					document.getElementById('rptConvenio').submit();
					break;
			}
		} else if (accion == "Salir") {
			document.getElementById("accion").value = accion;
			document.getElementById('frmConvenio').submit();
		}
	}

	function validarForma(formObject){
		if (document.getElementById("periodoacademico").value == "" || document.getElementById("corte").value == ""
		){
			alert('Por favor ingrese todos los parámetros de búsqueda');
			return false;
		}
		return true;
	}
</script>

<form name="rptConvenio" id="rptConvenio" method="post" action="">
{hiddenSession}
<input type="hidden" name="clase" id="clase" value="Convenio" />
<input type="hidden" name="controlador" id="controlador" value="List" />
<input type="hidden" name="metodo" id="metodo" value="" />
<input type="hidden" name="accion" id="accion" value="" />
<table border="0" cellspacing="0" cellpadding="4" width="100%" class="sin_borde">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>Reportes</h1></td>
  </tr>
  <!-- BEGIN MENSAJE -->
  <tr>
	<td align="center" valign="middle" colspan="2"><div class="Warning">{mensaje}</div></td>
  </tr>
  <!-- END MENSAJE -->
  <tr>
    <td align="center" valign="middle" colspan="2" nowrap>Periodo acad&eacute;mico {vperiodoacademico}:&nbsp;
      <select name="periodoacademico" id="periodoacademico" onchange="cambioPeriodoAcademicoR('')">
        {selectPeriodoAcademico}
      </select>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle" colspan="2" nowrap>Corte {vcorte}:&nbsp;
      <select name="corte" id="corte" disabled="disabled">
        {selectCorte}
      </select><span id="divCorte"></span>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle" colspan="2">
      <input type="button" name="generarPagos" id="generarPagos" value="Generar Pagos" class="button" onClick="javascript:enviarForma('generarPagosCsv');" />&nbsp;
      <input type="button" name="generarCuentas" id="generarCuentas" value="Generar Cuentas" class="button" onClick="javascript:enviarForma('generarCuentasCsv');" />&nbsp;
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" class="button" onClick="javascript:enviarForma('listarConvenio');" />
    </td>
  </tr>
</table>
</form>
{pie}