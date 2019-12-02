<script language="JavaScript" src="./js/listadoConvenios.js" type="text/javascript"></script>
<input type="hidden" name="paginacion[totalRegistros]" id="paginacion_totalRegistros" value="{totalRegistros}" />
<input type="hidden" name="paginacion[paginaActual]" id="paginacion_paginaActual" value="{paginaActual}" />
<input type="hidden" name="paginacion[pagina]" id="paginacion_pagina" value="{pagina}" />
<input type="hidden" name="paginacion[filtroPeriodoAcademico]" id="paginacion_filtroPeriodoAcademico" value="{filtroPeriodoAcademico}" />
<input type="hidden" name="paginacion[filtroDependencia]" id="paginacion_filtroDependencia" value="{filtroDependencia}" />
<input type="hidden" name="paginacion[filtroEstado]" id="paginacion_filtroEstado" value="{filtroEstado}" />
<input type="hidden" name="paginacion[filtroCodigo]" id="paginacion_filtroCodigo" value="{filtroCodigo}" />
{paginacion}
<table border="0" cellpadding="0" cellspacing="2" width="100%">
  <tr>
    <th><input type="checkbox" name="seleccionar" id="seleccionar" onclick="marcarDesmarcar()" /></th>
    <th>Fecha Inicio</th>
    <th>Fecha Final</th>
    <th>Estudiante</th>
    <th>Dependencia</th>
    <th>Estado</th>
    <th>Opciones</th>    
  </tr>
  <!-- BEGIN NODATOS -->
  <tr>
    <td colspan="7" align="center" valign="middle">
      <div>{noDatos}</div>
    </td>
  </tr>
  <!-- END NODATOS -->
  <!-- BEGIN CONVENIO -->
  <tr>
    <td><input type="checkbox" name="convenios[]" value="{convenio}"/></td>
    <td align="center" valign="middle">{fechainicio}</td>
    <td align="center" valign="middle">{fechafin}</td>
    <td>{nombreEstudiante}</td>
    <td>{nombreDependencia}</td>
    <td align="center" valign="middle">{nombreEstado}</td>
    <td align="center" valign="middle">
	  <img title="Actualizar" src="./icons/book_edit.png" style="cursor:pointer" onclick="javascript:enviarForma('Actualizar', {convenio})" />
	  <img title="Eliminar" src="./icons/book_delete.png" style="cursor:pointer" onclick="javascript:enviarForma('Eliminar', {convenio})" />
	  <!-- BEGIN MOSTRARPDF -->
	    <img title="Mostrar PDF" src="./icons/page_white_text.png" style="cursor:pointer" onclick="javascript:enviarForma('MostrarPDF', {convenio_mostrarpdf})" />
	  <!-- END MOSTRARPDF --> 
    </td>    
  </tr>
  <!-- END CONVENIO -->
</table>
{paginacion}