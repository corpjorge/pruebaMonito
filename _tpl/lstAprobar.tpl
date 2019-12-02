{cabezote}
<script language="JavaScript" src="./js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="./js/jquery.format.1.05.js" type="text/javascript"></script>
<script language="JavaScript" src="./js/desplegables.js" type="text/javascript"></script>
<script language="JavaScript">
	var url = "{URL_SITIO}index.php?{queryHiddenSession}";
	function enviarForma(accion, convenio) {
		if (accion == "Salir") {
			document.getElementById("accion").value = accion;
			document.getElementById('frmAprobacion').submit();
		} else {
			if (validarForma()) {
				switch (accion) {
					case 'aprobar':
						if (validarLista()) {
							document.getElementById("accion").value = accion;
							document.getElementById("controlador").value = "List";
							document.getElementById("metodo").value = "usrAprobar";
							document.getElementById('frmAprobacion').submit();
						}
						break;
					case 'buscar':
						document.getElementById("accion").value = accion;
						document.getElementById("controlador").value = "List";
						document.getElementById("metodo").value = "usrAprobar";
						document.getElementById('frmAprobacion').submit();
						break;
					case 'consultar':
						document.getElementById("accion").value = accion;
						document.getElementById("controlador").value = "Item";
						document.getElementById("metodo").value = "usrConsultarConvenio";
						document.getElementById("convenio").value = convenio;
						document.getElementById('frmAprobacion').submit();
						break;
				}
			}
		}
	}

	function validarForma(formObject){
		if (document.getElementById("periodoacademico").value == "" || document.getElementById("estado").value == ""
		){
			alert('Por favor ingrese todos los parámetros de búsqueda');
			return false;
		}
		return true;
	}
	
	function validarLista(){
		if ($("input[@name=convenios]:checked").length == 0) {
			alert('Por favor seleccione las monitorias');
			return false;
		}
		return true;
	}
	
	function marcarDesmarcar () {
		if ($("#seleccionar").is(":checked")) {
			$("input:checkbox").attr('checked', true);
		} else {
			$("input:checkbox").removeAttr("checked");
			//$("input[@name=convenios]:checked").removeAttr("checked");
		}
	} 

</script>

<form name="frmAprobacion" id="frmAprobacion" method="post" action="">
<input type="hidden" name="accion" id="accion" value="" />
<input type="hidden" name="clase" id="clase" value="Convenio" />
<input type="hidden" name="controlador" id="controlador" value="" />
<input type="hidden" name="metodo" id="metodo" value="" />
<input type="hidden" name="convenio" id="convenio" value="0" />
<table border="0" cellspacing="0" cellpadding="4" width="100%" class="sin_borde">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>Aprobaci&oacute;n de pagos</h1></td>
  </tr>
  <!-- BEGIN MENSAJE -->
  <tr>
	<td align="center" valign="middle" colspan="2"><div class="Info">{mensaje}</div></td>
  </tr>
  <!-- END MENSAJE -->
  <tr>
    <td align="center" valign="middle" colspan="2" nowrap>Periodo acad&eacute;mico {vperiodoacademico}:&nbsp;
      <select name="periodoacademico" id="periodoacademico">
        {selectPeriodoAcademico}
      </select>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle" colspan="2" nowrap>Estado {vestado}:&nbsp;
      <select name="estado" id="estado">
        {selectEstado}
      </select>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle" colspan="2">
      <input type="button" name="buscar" id="buscar" value="Buscar" class="button" onClick="javascript:enviarForma('buscar', 0);" />&nbsp;
      <!-- BEGIN BOTONCREADO -->
      <input type="button" name="aprobar" id="aprobar" value="Aprobar" class="button" onClick="javascript:enviarForma('aprobar', 0);" />
      <!-- END BOTONCREADO -->
    </td>
  </tr>
</table>
<div id="divListadoAprobar">
  {listadoAprobar}
</div>
</form>
{pie}