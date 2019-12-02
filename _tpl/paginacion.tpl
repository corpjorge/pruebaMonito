<table border="0" cellpadding="0" cellspacing="2" width="100%" class="sin_borde">
  <tr>
    <td align="left">
      P&aacute;gina&nbsp;{paginaActual}&nbsp;de&nbsp;{numeroPaginas}&nbsp;-&nbsp;[{totalRegistros}&nbsp;Registros]
    </td>
    <td align="right">
      <span class="divLoadListado"></span>&nbsp;
      &nbsp;<a onclick="javascript:enviarPaginacion('', '<<')" class="pagina"><<</a>&nbsp;
      &nbsp;<a onclick="javascript:enviarPaginacion('', '<')" class="pagina"><</a>&nbsp;
      <!-- BEGIN PAGINA -->
      &nbsp;<a onclick="javascript:enviarPaginacion('{numPagina}', '')" class="{classPagina}">{numPagina}</a>&nbsp;
      <!-- END PAGINA -->
      &nbsp;<a onclick="javascript:enviarPaginacion('', '>')" class="pagina">></a>&nbsp;
      &nbsp;<a onclick="javascript:enviarPaginacion('', '>>')" class="pagina">>></a>&nbsp;
    </td>
  </tr>
</table>