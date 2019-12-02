function adicionarDistribucion() {
	var htmlDistribucion = "";
	var horasSemanales = new Array();
	numeroDistribucion++;
	htmlDistribucion = crearHtmlDistribucion(numeroDistribucion);
	$(htmlDistribucion).appendTo('#divTablaDistribucion');
	$('#tipoobjeto' + numeroDistribucion).html(llenarElementosActivo(arrayTipoObjeto, ''));
	$('#fondopresupuestal' + numeroDistribucion).html(llenarElementosActivo(arrayFondoPresupuestal, ''));
	$("#divTablaDistribucion" + numeroDistribucion).show("slow");
}

function eliminarDistribucion(orden) {
	$("#divTablaDistribucion" + orden).remove();
}

function crearHtmlDistribucion(orden) {
	var distribucion = '';
	distribucion = distribucion + '<div id="divTablaDistribucion' + orden + '">';
	distribucion = distribucion + '<table border="0" cellspacing="0" cellpadding="4" width="100%">';
	distribucion = distribucion + '  <tr>';
	distribucion = distribucion + '    <td align="left" valign="middle" nowrap>Tipo Objeto *:&nbsp;';
	distribucion = distribucion + '      <select name="distribucion[' + orden + '][tipoobjeto]" id="tipoobjeto' + orden + '" onchange="cambioTipoObjeto(' + orden + ')">';
	distribucion = distribucion + '      </select>';
	distribucion = distribucion + '    </td>';
	distribucion = distribucion + '    <td align="left" valign="middle" nowrap>Objeto de Costo *:&nbsp;';
	distribucion = distribucion + '      <select name="distribucion[' + orden + '][objetocosto]" id="objetocosto' + orden + '" disabled="disabled">';
	distribucion = distribucion + '        <option value="">Seleccionar...</option>';
	distribucion = distribucion + '      </select><span id="divObjetoCosto' + orden + '"></span>';
	distribucion = distribucion + '    </td>';
	distribucion = distribucion + '    <td align="left" valign="middle" rowspan="3" nowrap>';
	distribucion = distribucion + '      <img src="./icons/delete.png" style="cursor:pointer" id="eliminardistribucion' + orden + '" nombre="distribucion[' + orden + '][eliminardistribucion]" value="-" />';
	distribucion = distribucion + '    </td>';
	distribucion = distribucion + '  </tr>';
	distribucion = distribucion + '  <tr>';
	distribucion = distribucion + '    <td align="left" valign="middle" colspan="2" nowrap>Fondo Presupuestal *:&nbsp;';
	distribucion = distribucion + '      <select name="distribucion[' + orden + '][fondopresupuestal]" id="fondopresupuestal' + orden + '">';
	distribucion = distribucion + '      </select>';
	distribucion = distribucion + '	   </td>';
	distribucion = distribucion + '  </tr>';
	distribucion = distribucion + '  <tr>';
	distribucion = distribucion + '    <td align="left" valign="middle" colspan="2" nowrap>Porcentaje *:&nbsp;';
	distribucion = distribucion + '      <input type="text" name="distribucion[' + orden + '][porcentaje]" id="porcentaje' + orden + '" size="30" value="" />';
	distribucion = distribucion + '      <script type="text/javascript">';
	distribucion = distribucion + '        $("#porcentaje' + orden + '").format({precision: 3,autofix:true});';
	distribucion = distribucion + '      </script>';
	distribucion = distribucion + '	   </td>';
	distribucion = distribucion + '  </tr>';
	distribucion = distribucion + '</table>';
	distribucion = distribucion + '</div>';
	distribucion = distribucion + '<script language="JavaScript">';
	distribucion = distribucion + '    $("#eliminardistribucion' + orden + '").click(function () {';
	distribucion = distribucion + '      eliminarDistribucion(' + orden + ');';
	distribucion = distribucion + '    });';
	distribucion = distribucion + '</script>';
	return distribucion;
}

/*
function crearHtmlDistribucion(orden) {
	var distribucion = '';
	distribucion = distribucion + '<div id="divTablaDistribucion' + orden + '">';
	distribucion = distribucion + '<table border="0" cellspacing="0" cellpadding="4" width="100%">';
	distribucion = distribucion + '  <tr>';
	distribucion = distribucion + '    <td align="left" valign="middle" nowrap>Tipo Objeto *:&nbsp;';
	distribucion = distribucion + '      <select name="distribucion[' + orden + '][tipoobjeto]" id="tipoobjeto' + orden + '" onchange="cambioTipoObjeto(' + orden + ')">';
	distribucion = distribucion + '      </select>';
	distribucion = distribucion + '    </td>';
	distribucion = distribucion + '    <td align="left" valign="middle" nowrap>Objeto de Costo *:&nbsp;';
	distribucion = distribucion + '      <select name="distribucion[' + orden + '][objetocosto]" id="objetocosto' + orden + '" disabled="disabled">';
	distribucion = distribucion + '        <option value="">Seleccionar...</option>';
	distribucion = distribucion + '      </select><span id="divObjetoCosto' + orden + '"></span>';
	distribucion = distribucion + '    </td>';
	distribucion = distribucion + '    <td align="left" valign="middle" rowspan="2" nowrap>';
	distribucion = distribucion + '      <img src="./img/delete.png" style="cursor:pointer" id="eliminardistribucion' + orden + '" nombre="distribucion[' + orden + '][eliminardistribucion]" value="-" />';
	distribucion = distribucion + '    </td>';
	distribucion = distribucion + '  </tr>';
	distribucion = distribucion + '  <tr>';
	distribucion = distribucion + '    <td align="left" valign="middle" nowrap>Fondo Presupuestal *:&nbsp;';
	distribucion = distribucion + '      <select name="distribucion[' + orden + '][fondopresupuestal]" id="fondopresupuestal' + orden + '">';
	distribucion = distribucion + '      </select>';
	distribucion = distribucion + '	   </td>';
	distribucion = distribucion + '    <td align="left" valign="middle" nowrap>Porcentaje *:&nbsp;';
	distribucion = distribucion + '      <input type="text" name="distribucion[' + orden + '][porcentaje]" id="porcentaje' + orden + '" size="30" value="" />';
	distribucion = distribucion + '      <script type="text/javascript">';
	distribucion = distribucion + '        $("#porcentaje' + orden + '").format({precision: 3,autofix:true});';
	distribucion = distribucion + '      </script>';
	distribucion = distribucion + '	   </td>';
	distribucion = distribucion + '  </tr>';
	distribucion = distribucion + '</table>';
	distribucion = distribucion + '</div>';
	distribucion = distribucion + '<script language="JavaScript">';
	distribucion = distribucion + '    $("#eliminardistribucion' + orden + '").click(function () {';
	distribucion = distribucion + '      eliminarDistribucion(' + orden + ');';
	distribucion = distribucion + '    });';
	distribucion = distribucion + '</script>';
	return distribucion;
}
*/