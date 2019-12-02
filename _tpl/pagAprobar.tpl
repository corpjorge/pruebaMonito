<script language="JavaScript" src="./js/listadoAprobar.js" type="text/javascript"></script>
<input type="hidden" name="paginacion[totalRegistros]" id="paginacion_totalRegistros" value="{totalRegistros}" />
<input type="hidden" name="paginacion[paginaActual]" id="paginacion_paginaActual" value="{paginaActual}" />
<input type="hidden" name="paginacion[pagina]" id="paginacion_pagina" value="{pagina}" />
<input type="hidden" name="paginacion[filtroPeriodoAcademico]" id="paginacion_filtroPeriodoAcademico" value="{filtroPeriodoAcademico}" />
<input type="hidden" name="paginacion[filtroDependencia]" id="paginacion_filtroDependencia" value="{filtroDependencia}" />
<input type="hidden" name="paginacion[filtroEstado]" id="paginacion_filtroEstado" value="{filtroEstado}" />
{paginacion}
<table border="0" cellpadding="0" cellspacing="2" width="100%">
  <tr>
    <th><input type="checkbox" name="seleccionar" id="seleccionar" onclick="marcarDesmarcar()" /></th>
    <th>Fecha Inicio</th>
    <th>Fecha Final</th>
    <th>Estudiante</th>
    <th>Dependencia</th>
    <th>Estado</th>    
  </tr>
  <!-- BEGIN NODATOS -->
  <tr>
    <td colspan="6" align="center" valign="middle">
      <div>{noDatos}</div>
    </td>
  </tr>
  <!-- END NODATOS -->
  <!-- BEGIN CONVENIO -->
  <tr>
    <td><input type="checkbox" name="convenios[]" value="{convenio}"/></td>
    <td>{fechainicio}</td>
    <td>{fechafin}</td>
    <td>{nombreEstudiante}</td>
    <td>{nombreDependencia}</td>
    <td align="center">
      <div id="divAprobar{convenio}">
        <img title="Ver Monitoria" src="./icons/book.png" style="cursor:pointer" onclick="javascript:enviarForma('consultar', {convenio})" />
        <!-- BEGIN CREADO -->
        <img style="cursor:pointer" src="./img/money_delete.png" title="Creado" onclick="aprobarPago('{convenioC}')">
        <!-- END CREADO -->
        <!-- BEGIN APROBADO -->
        <img src="./img/money_add.png" title="Aprobado">
        <!-- END APROBADO -->
        <!-- BEGIN GENERADO -->
        <img src="./img/money.png" title="Generado">
        <!-- END GENERADO -->
      </div>
    </td>    
  </tr>
  <!-- END CONVENIO -->
</table>
{paginacion}