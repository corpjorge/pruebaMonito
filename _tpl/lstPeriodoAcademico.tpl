{cabezote}
<script language="JavaScript">
	function enviarForma(accion, periodo) {
		if (accion != "Salir") {
			switch (accion) {
				case 'Insertar':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "Item";
					document.getElementById("metodo").value = "usrForma";
					document.getElementById('frmPeriodo').submit();
					break;
				case 'Actualizar':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "Item";
					document.getElementById("metodo").value = "usrForma";
					document.getElementById("periodoacademico").value = periodo;
					document.getElementById('frmPeriodo').submit();
					break;
				case 'Eliminar':
					if (confirm("¿Está seguro que desea eliminar el periodo académico?")) {
						document.getElementById("accion").value = accion;
						document.getElementById("controlador").value = "Item";
						document.getElementById("metodo").value = "usrEliminar";
						document.getElementById("periodoacademico").value = periodo;
						document.getElementById('frmPeriodo').submit();
					}
					break;
			}
		} else if (accion == "Salir") {
			document.getElementById("accion").value = accion;
			document.getElementById('frmPeriodo').submit();
		}
	}
</script>
<form name="frmPeriodo" id="frmPeriodo" method="post" action="">
<table border="0" cellpadding="0" cellspacing="2" width="100%">
  <tr>
	<td colspan="8" align="center" valign="middle"><h1>Listado de periodos acad&eacute;micos</h1></td>
  </tr>
  <tr>
    <td colspan="8" align="left" valign="middle">
      <input type="button" name="insertar" id="insertar" value="Crear Periodo Académico" class="button" onClick="javascript:enviarForma('Insertar', 0);" />
      <input type="hidden" name="accion" id="accion" value="" />
      <input type="hidden" name="clase" id="clase" value="PeriodoAcademico" />
      <input type="hidden" name="controlador" id="controlador" value="" />
      <input type="hidden" name="metodo" id="metodo" value="" />
      <input type="hidden" name="periodoacademico" id="periodoacademico" value="0" />
    </td>
  </tr>
  <tr>
    <th>Periodo</th>
    <th>Fecha Inicial</th>
    <th>Fecha Final</th>
    <th>Receso Desde</th>
    <th>Receso Hasta</th>
    <th>Rango N&uacute;m. Horas</th>
    <th>Rango Valor Hora</th>
    <th>Opciones</th>    
  </tr>
  <!-- BEGIN NODATOS -->
  <tr>
    <td colspan="8" align="center" valign="middle">
      <div>{noDatos}</div>
    </td>
  </tr>
  <!-- END NODATOS -->
  <!-- BEGIN PERIODOACADEMICO -->
  <tr>
    <td align="center" valign="middle">{periodosemestre}</td>
    <td align="center" valign="middle">{fechainicio}</td>
    <td align="center" valign="middle">{fechafin}</td>
    <td align="center" valign="middle">{fechainicioreceso}</td>
    <td align="center" valign="middle">{fechafinreceso}</td>
    <td align="center" valign="middle">{minhoras} - {maxhoras}</td>
    <td align="center" valign="middle">{minvalorhora} - {maxvalorhora}</td>
    <td align="center" valign="middle">
	  <img title="Actualizar" src="./icons/book_edit.png" style="cursor:pointer" onclick="javascript:enviarForma('Actualizar', {periodoacademico})" />
	  <img title="Eliminar" src="./icons/book_delete.png" style="cursor:pointer" onclick="javascript:enviarForma('Eliminar', {periodoacademico})" />
    </td>    
  </tr>
  <!-- END PERIODOACADEMICO -->
</table>
</form>
{pie}