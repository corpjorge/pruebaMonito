  <tr>
    <td align="left" valign="middle" nowrap>Nombres {vnombres}:&nbsp;{nombres}
      <input type="hidden" name="estudiante[estadoestudiante]" id="estadoestudiante" value="00" />
      <input type="hidden" name="estudiante[estudiante]" id="estudiante" value="{estudiante}" />
      <input type="hidden" name="estudiante[nombres]" id="nombres" value="{nombres}" />
	</td>
    <td align="left" valign="middle" nowrap>Apellidos {vapellidos}:&nbsp;{apellidos}
      <input type="hidden" name="estudiante[apellidos]" id="apellidos" value="{apellidos}" />
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle" colspan="2" nowrap>
      <table border="0" cellspacing="0" cellpadding="0" width="100%" class="sin_borde">
        <tr>
          <td align="left" valign="middle" nowrap>Pa&iacute;s {vpais}:&nbsp;
            <select name="estudiante[pais]" id="pais" onchange="cambioPais('')">
              {selectPais}
            </select>
          </td>
          <td align="left" valign="middle" nowrap>Departamento {vdepartamento}:&nbsp;
            <select name="estudiante[departamento]" id="departamento" {departamentoDisabled} onchange="cambioDepartamento('')">
              {selectDepartamento}
            </select><span id="divDepartamento"></span>
          </td>
          <td align="left" valign="middle" nowrap>Ciudad {vciudad}:&nbsp;
            <select name="estudiante[ciudad]" id="ciudad" {ciudadDisabled}>
              {selectCiudad}
            </select><span id="divCiudad"></span>
          </td>
        </tr>
      </table>
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>Direcci&oacute;n {vdireccion}:&nbsp;
      <input type="text" name="estudiante[direccion]" id="direccion" size="30" value="{direccion}" maxlength= "200" />
	</td>
    <td align="left" valign="middle" nowrap>Tel&eacute;fono {vtelefono}:&nbsp;
      <input type="text" name="estudiante[telefono]" id="telefono" size="15" value="{telefono}" maxlength= "12" />
      <script type="text/javascript">
        $("#telefono").format({type:"phone-number",autofix:true});
      </script>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>Correo {vemail}:&nbsp;{email}
      <input type="hidden" name="estudiante[email]" id="email" value="{email}" />
	</td>
    <td align="left" valign="middle" nowrap>C&oacute;digo {vcodigo}:&nbsp;<strong>{codigo}</strong>
      <input type="hidden" name="estudiante[codigo]" id="codigo" value="{codigo}" />
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>Tipo Documento {vtipodocumento}:&nbsp;{nombreTipoDocumento}
      <input type="hidden" name="estudiante[tipodocumento]" id="tipodocumento" value="{tipodocumento}" />
    </td>
    <td align="left" valign="middle" nowrap>Documento {vdocumento}:&nbsp;<strong>{documento}</strong>
      <input type="hidden" name="estudiante[documento]" id="documento" value="{documento}" />
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>Lugar Expedici&oacute;n {vexpediciondoc}:&nbsp;
      <input type="text" name="estudiante[expediciondoc]" id="expediciondoc" size="30" value="{expediciondoc}" maxlength= "50" />
    </td>
    <td align="left" valign="middle" nowrap>G&eacute;nero {vgenero}:&nbsp;{nombreGenero}
      <input type="hidden" name="estudiante[genero]" id="genero" value="{genero}" />
	</td>
  </tr>