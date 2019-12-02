function adicionarMateria() {
	var htmlMateria = "";
	var horasSemanales = new Array();
	numeroMaterias++;
	htmlMateria = crearHtmlMateria(numeroMaterias);
	$(htmlMateria).appendTo('#divTablaMateria');
	$("#divTablaMateria" + numeroMaterias).show("slow");
	for(i = minHoras; i <= maxHoras; i++) {
		horasSemanales[i] = i;
	}
	$('#horassemanales' + numeroMaterias).html(llenarElementosActivo(horasSemanales, ''));
}

function eliminarMateria(orden) {
	$("#divTablaMateria" + orden).remove();
}

function crearHtmlMateria(orden) {
	var materia = '';
	materia = materia + '<div id="divTablaMateria' + orden + '">';
	materia = materia + '<table border="0" cellspacing="4" cellpadding="4" width="100%">';
	materia = materia + '  <tr>';
	materia = materia + '    <td align="left" valign="middle" nowrap>C&oacute;digo Materia:&nbsp;';
	materia = materia + '      <input type="text" id="textomateria' + orden + '" nombre="materias[' + orden + '][textomateria]" size="10" />';
	materia = materia + '      <input type="button" id="buscarmateria' + orden + '" nombre="materias[' + orden + '][buscarmateria]" value="Buscar" class="button" />';
	materia = materia + '    </td>';
	materia = materia + '    <td align="left" valign="middle" nowrap>Materia:&nbsp;';
	materia = materia + '      <select name="materias[' + orden + '][curso]" id="curso' + orden + '" disabled="disabled" onchange="cambioMateria(' + orden + ')">';
	materia = materia + '        <option value="">Seleccionar...</option>';
	materia = materia + '      </select>';
	materia = materia + '    </td>';
	materia = materia + '    <td align="left" valign="middle" nowrap>Secci&oacute;n:&nbsp;';
	materia = materia + '      <select name="materias[' + orden + '][seccion]" id="seccion' + orden + '" onchange="cambioSeccion(' + orden + ')">';
	materia = materia + '        <option value="">Seleccionar...</option>';
	materia = materia + '      </select><span id="divSeccionMateria' + orden + '"></span>';
	materia = materia + '    </td>';
	materia = materia + '    <td align="left" valign="middle" rowspan="3" nowrap>';
	materia = materia + '      <img src="./img/delete.png" style="cursor:pointer" id="eliminarmateria' + orden + '" nombre="materias[' + orden + '][eliminarmateria]" value="-" />';
	materia = materia + '    </td>';
	materia = materia + '  </tr>';
	materia = materia + '  <tr>';
	materia = materia + '    <td align="left" valign="middle" colspan="2" nowrap>Nombre:&nbsp;';
	materia = materia + '      <input type="text" name="materias[' + orden + '][nombre]" id="nombre' + orden + '" size="60" value="" readonly="readonly" /><span id="divNombreMateria' + orden + '"></span>';
	materia = materia + '    </td>';
	materia = materia + '    <td align="left" valign="middle" nowrap>CRN:&nbsp;';
	materia = materia + '      <input type="text" name="materias[' + orden + '][crn]" id="crn' + orden + '" size="10" value="" readonly="readonly" /><span id="divCrnMateria' + orden + '"></span>';
	materia = materia + '    </td>';
	materia = materia + '  </tr>';
	materia = materia + '  <tr>';
	materia = materia + '    <td align="left" valign="middle" colspan="2" nowrap>Horas Semanales:&nbsp;';
	materia = materia + '      <select name="materias[' + orden + '][horassemanales]" id="horassemanales' + orden + '">';
	materia = materia + '        <option value="">Seleccionar...</option>';
	materia = materia + '      </select>';
	materia = materia + '	</td>';
	materia = materia + '    <td align="left" valign="middle" nowrap>Valor Hora:&nbsp;';
	materia = materia + '      <input type="text" name="materias[' + orden + '][valorhora]" id="valorhora' + orden + '" size="15" value="" />';
	materia = materia + '      <script type="text/javascript">';
	materia = materia + '        $("#valorhora' + orden + '").format({precision: 0,autofix:true});';
	materia = materia + '      </script>';
	materia = materia + '	</td>';
	materia = materia + '  </tr>';
	materia = materia + '</table>';
	materia = materia + '</div>';
	materia = materia + '<script language="JavaScript">';
	materia = materia + '    $("#divTablaMateria' + orden + '").hide();';
	materia = materia + '    $("#buscarmateria' + orden + '").click(function () {';
	materia = materia + '      buscarMateria(' + orden + ');';
	materia = materia + '    });';
	materia = materia + '    $("#eliminarmateria' + orden + '").click(function () {';
	materia = materia + '      eliminarMateria(' + orden + ');';
	materia = materia + '    });';
	materia = materia + '</script>';
	return materia;
}
