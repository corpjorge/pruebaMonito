{cabezote}
<script language="JavaScript" SRC="./js/form_validation.js" TYPE="text/javascript"></SCRIPT>
<script language="JavaScript">
	function validarForma(formObject){
		if (!checkString(formObject.login, 'Usuario, contiene caracteres invalidos!'))
			return false;
		if (!checkString(formObject.clave, 'Clave, contiene caracteres invalidos!'))
			return false;
		return true;
	}
</script>

<form name="frmAutenticacion" id="frmAutenticacion" method="post" action="" onSubmit="return validarForma(frmAutenticacion);">
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>Sistema de Monitorias<br>Autenticación de usuario</h1></td>
  </tr>
  <!-- BEGIN MENSAJE -->
  <tr>
	<td align="center" valign="middle" colspan="2"><div class="Warning">{mensaje}</div></td>
  </tr>
  <!-- END MENSAJE -->
  <tr>
    <td width="40%" align="right" valign="middle" nowrap>Usuario</td>
    <td>
	  <input maxlength="50" type="text" size="30" name="username" id="username" value="{username}" />
	</td>
  </tr>
  <tr>
    <td width="40%" align="right" valign="middle" nowrap>Clave</td>
    <td>
	  <input maxlength="50" type="password" size="30" name="password" id="password" value="" />
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle" colspan="2">
      <input type="submit" name="accion" value="Ingresar" class="button" />
    </td>
  </tr>
</table>
</form>
{pie}