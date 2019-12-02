{cabezote}
<script type="text/javascript" src="./js/form_validation.js"></script>
<script language="JavaScript">
	function enviarForma(accion) {
		if (accion != "Salir") {
			switch (accion) {
				case 'validarEstudiante':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "Item";
					document.getElementById("metodo").value = "usrSolicitarConvenio";
					document.getElementById('frmValidacionEstudiante').submit();
					break;
				case 'listarConvenio':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "List";
					document.getElementById("metodo").value = "usrListar";
					document.getElementById('frmValidacionEstudiante').submit();
					break;
			}
		} else if (accion == "Salir") {
			document.getElementById("accion").value = accion;
			document.getElementById('frmConvenio').submit();
		}
	}

	function validarForma(formObject){
/*
		if (document.getElementById("codigo").value == "") {
			alert("Digite el código del estudiante");
			document.getElementById("codigo").focus();
			return false;
		}
		if (document.getElementById("documento").value == "") {
			alert("Digite el documento del estudiante");
			document.getElementById("documento").focus();
			return false;
		}
		if (document.getElementById("periodoacademico").value == "") {
			alert("Seleccione el periodo");
			document.getElementById("periodoacademico").focus();
			return false;
		}
*/
		return true;
	}
</script>

<form name="frmValidacionEstudiante" id="frmValidacionEstudiante" method="post" action="">
{hiddenSession}
<input type="hidden" name="clase" id="clase" value="Convenio" />
<input type="hidden" name="controlador" id="controlador" value="Item" />
<input type="hidden" name="metodo" id="metodo" value="usrSolicitarConvenio" />
<input type="hidden" name="accion" id="accion" value="validarEstudiante" />
<table border="0" cellspacing="0" cellpadding="4" width="100%" class="sin_borde">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>Creaci&oacute;n de Monitoria</h1></td>
  </tr>
  <!-- BEGIN MENSAJE -->
  <tr>
	<td align="center" valign="middle" colspan="2"><div class="Warning">{mensaje}</div></td>
  </tr>
  <!-- END MENSAJE -->
  <tr>
    <td align="center" valign="middle" colspan="2" nowrap>C&oacute;digo del estudiante {vcodigo}:&nbsp;
      <input type="text" name="codigo" id="codigo" size="12" value="{codigo}" maxlength= "18" />
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle" colspan="2" nowrap>
      Periodo acad&eacute;mico actual:&nbsp;{periodoacademico}
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle" colspan="2">
      <input type="button" name="ingresar" id="ingresar" value="Ingresar" class="button" onClick="javascript:enviarForma('validarEstudiante');" />&nbsp;
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" class="button" onClick="javascript:enviarForma('listarConvenio');" />
    </td>
  </tr>
</table>
</form>
{pie}