{cabezote}
<form name="frmMensaje" id="frmMensaje" method="post" action="">
{hiddenSession}
<input type="hidden" name="accion" value="" />
<input type="hidden" name="clase" id="clase" value="{clase}" />
<input type="hidden" name="controlador" id="controlador" value="{controlador}" />
<input type="hidden" name="metodo" id="metodo" value="{metodo}" />
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
	<td align="center" valign="middle" colspan="2"><div class="Notice">{mensaje}</div></td>
  </tr>
  <tr>
    <td align="center" valign="middle" colspan="2">
      <input type="submit" name="accion" value="Regresar" class="button" />
    </td>
  </tr>
</table>
</form>
{pie}