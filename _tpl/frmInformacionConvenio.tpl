{cabezote}
<link href="./js/jscalendar/calendar-blue.css" rel="stylesheet" type="text/css" ></link>
<script type="text/javascript" src="./js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="./js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="./js/jscalendar/calendar-setup.js"></script>
<script language="JavaScript" src="./js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="./js/jquery.format.1.05.js" type="text/javascript"></script>
<script language="JavaScript" src="./js/desplegables.js" type="text/javascript"></script>
<script language="JavaScript" src="./js/materia.js" type="text/javascript"></script>
<script language="JavaScript" src="./js/distribucion.js" type="text/javascript"></script>
<script language="JavaScript">
	var url = "{URL_SITIO}index.php?{queryHiddenSession}";
	function enviarForma(accion) {
		if (accion == "Salir") {
			document.getElementById("accion").value = accion;
			document.getElementById('frmSolicitudConvenio').submit();
		} else {
			switch (accion) {
				case 'solicitarConvenio':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "Item";
					document.getElementById("metodo").value = "usrSolicitarConvenio";
					document.getElementById('frmSolicitudConvenio').submit();
					break;
				case 'mostrarValidacionEstudiante':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "Item";
					document.getElementById("metodo").value = "usrSolicitarConvenio";
					document.getElementById('frmSolicitudConvenio').submit();
					break;
				case 'actualizarConvenio':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "Item";
					document.getElementById("metodo").value = "usrActualizarConvenio";
					document.getElementById('frmSolicitudConvenio').submit();
					break;
				case 'listarConvenios':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "List";
					document.getElementById("metodo").value = "usrListar";
					document.getElementById('frmSolicitudConvenio').submit();
					break;
				case 'aprobarConvenios':
					document.getElementById("accion").value = accion;
					document.getElementById("controlador").value = "List";
					document.getElementById("metodo").value = "usrAprobar";
					document.getElementById('frmSolicitudConvenio').submit();
					break;
			}
		}
	}
</script>
<form name="frmSolicitudConvenio" id="frmSolicitudConvenio" method="post" action="">
{hiddenSession}
<input type="hidden" name="clase" id="clase" value="Convenio" />
<input type="hidden" name="controlador" id="controlador" value="Item" />
<input type="hidden" name="metodo" id="metodo" value="usrSolicitarConvenio" />
<input type="hidden" name="accion" id="accion" value="" />
<div id="divErroresCalculoValorConvenio">
</div>
<!-- BEGIN MENSAJE -->
<table border="0" cellspacing="0" cellpadding="1" width="100%" class="sin_borde">
  <tr>
	<td align="center" valign="middle" colspan="2"><div class="Warning">{mensaje}</div></td>
  </tr>
</table>
<!-- END MENSAJE -->
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>Informaci&oacute;n del Estudiante</h1></td>
  </tr>
  {informacionEstudiante}
</table>
<input type="hidden" name="convenio[convenio]" id="convenio" value="{convenio}" />
<!-- BEGIN ESTADOU -->
<input type="hidden" name="convenio[estado]" id="estado" value="{estadoU}" />
<!-- END ESTADOU -->
<input type="hidden" name="convenio[consecutivo]" id="consecutivo" value="{consecutivo}" />
<input type="hidden" name="convenio[estudiante]" id="estudiante" value="{estudiante}" />
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>Informaci&oacute;n de la Monitoria</h1></td>
  </tr>
  <tr>
	<td align="center" valign="middle" colspan="2"><div class="Info">Recuerde que el Periodo Acad&eacute;mico empieza el {fechaInicioPeriodo} y termina el {fechaFinPeriodo}</div></td>
	<!-- <td align="center" valign="middle" colspan="2"><div class="Info">Recuerde que el Periodo Acad&eacute;mico empieza el 22/01/2018 y termina el 22/05/2018</div></td> -->
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>Fecha de Inicio {vfechainicio}:&nbsp;
      <input type="text" name="convenio[fechainicio]" id="fechainicio" size="12" value="{fechainicio}" maxlength= "10" readonly="readonly" />
      <img src="./img/btnCalendario.gif" NAME="btFechaInicio" ID="btFechaInicio">
	</td>
    <td align="left" valign="middle" nowrap>Fecha de finalizaci&oacute;n {vfechafin}:&nbsp;
      <input type="text" name="convenio[fechafin]" id="fechafin" size="12" value="{fechafin}" maxlength= "10" readonly="readonly" />
      <img src="./img/btnCalendario.gif" NAME="btFechaFin" ID="btFechaFin">
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle" colspan="2" nowrap>Facultad {vdependenciapadre}:&nbsp;
      <select name="convenio[dependenciapadre]" id="dependenciapadre" onchange="cambioDependenciaPadre('')">
        {selectDependenciaPadre}
      </select>
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle" colspan="2" nowrap>Departamento {vdependencia}:&nbsp;
      <select name="convenio[dependencia]" id="dependencia" onchange="cambioDependencia('')">
        {selectDependencia}
      </select><span id="divDependencia"></span>
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>Tipo de Labor {vtipolabor}:&nbsp;
      <select name="convenio[tipolabor]" id="tipolabor" onchange="cambioTipoLabor('')">
        {selectTipoLabor}
      </select><span id="divTipoLabor"></span>
    </td>
    <td align="left" valign="middle" nowrap>Tipo de Monitor {vtipomonitor}:&nbsp;
      <select name="convenio[tipomonitor]" id="tipomonitor">
        {selectTipoMonitor}
      </select><span id="divTipoMonitor"></span>
    </td>
  </tr>
  <!-- BEGIN ESTADOA -->
  <tr>
    <td align="left" valign="middle" colspan="2" nowrap>Estado de la Monitoria:&nbsp;
      <select name="convenio[estado]" id="estado">
        {selectEstadoA}
      </select>
    </td>
  </tr>
  <!-- END ESTADOA -->
</table>
<script language="JavaScript">
  Calendar.setup({
    inputField : "fechainicio",
    ifFormat : "%d/%m/%Y",
    showsTime : false,
    button : "btFechaInicio",
    step : 1
  });
  Calendar.setup({
    inputField : "fechafin",
    ifFormat : "%d/%m/%Y",
    showsTime : false,
    button : "btFechaFin",
    step : 1
  });
</script>
<div id="divTablaTipoLabor">
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>Informaci&oacute;n Tipo de Labor <span id="divTituloTipoLabor">{divTituloTipoLabor}</span> </h1></td>
  </tr>
</table>
</div>
<div id="divTablaTipoLaborI">
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
    <td align="left" valign="middle" colspan="3" nowrap>Descripci&oacute;n {vdescripcion}:&nbsp;<br>
      <textarea rows="4" cols="80" name="convenio[descripcion]" id="descripcion">{descripcion}</textarea>
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>C&oacute;digo Materia:&nbsp;
      <input type="text" id="textomateria1000" nombre="materias[1000][textomateria]" value="{textomateriaI}" size="10"  />
      <input type="button" id="buscarmateria1000" nombre="materias[1000][buscarmateria]" value="Buscar" class="button" />
    </td>
    <td align="left" valign="middle" nowrap>Materia *:&nbsp;
      <select name="materias[1000][curso]" id="curso1000" onchange="cambioMateria(1000, '')" {curso1000Disabled}>
        {selectMateriaI}
      </select>
    </td>
    <td align="left" valign="middle" nowrap>Secci&oacute;n *:&nbsp;
      <select name="materias[1000][seccion]" id="seccion1000" onchange="cambioSeccion(1000)" {seccion1000Disabled}>
        {selectSeccionI}
      </select><span id="divSeccionMateria1000"></span>
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle" colspan="2" nowrap>Nombre *:&nbsp;
      <input type="text" name="materias[1000][nombre]" id="nombre1000" size="60" value="{nombreI}" readonly="readonly" {nombre1000Disabled} /><span id="divNombreMateria1000"></span>
    </td>
    <td align="left" valign="middle" nowrap>CRN:&nbsp;
      <input type="text" name="materias[1000][crn]" id="crn1000" size="10" value="{crnI}" readonly="readonly" {crn1000Disabled} /><span id="divCrnMateria1000"></span>
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle" colspan="2" nowrap>Horas Semanales {vhoassemanales}:&nbsp;
      <select name="convenio[horassemanales]" id="horassemanales">
        {selectHorasSemanales}
      </select>
	</td>
    <td align="left" valign="middle" nowrap>Valor Hora {vvalorhora}:&nbsp;
      <input type="text" name="convenio[valorhora]" id="valorhora" size="15" value="{valorhora}" />
      <script type="text/javascript">
        $("#valorhora").format({precision: 3,autofix:true});
      </script>
    </td>
  </tr>
</table>
</div>
<script language="JavaScript">
    $("#buscarmateria1000").click(function () {
      buscarMateria(1000);
    });
</script>

<div id="divTablaMateria">
<!-- BEGIN TABLAMATERIA -->
<div id="divTablaMateria{orden}">
<table border="0" cellspacing="4" cellpadding="4" width="100%">
  <tr>
    <td align="left" valign="middle" nowrap>C&oacute;digo Materia:&nbsp;
      <input type="text" id="textomateria{orden}" nombre="materias[{orden}][textomateria]" value="{textomateria}" size="10"  />
      <input type="button" id="buscarmateria{orden}" nombre="materias[{orden}][buscarmateria]" value="Buscar" class="button" />
    </td>
    <td align="left" valign="middle" nowrap>Materia *:&nbsp;
      <select name="materias[{orden}][curso]" id="curso{orden}" onchange="cambioMateria({orden}, '')">
        {selectMateria}
      </select>
    </td>
    <td align="left" valign="middle" nowrap>Secci&oacute;n *:&nbsp;
      <select name="materias[{orden}][seccion]" id="seccion{orden}" onchange="cambioSeccion({orden})">
        {selectSeccion}
      </select><span id="divSeccionMateria{orden}"></span>
    </td>
    <td align="left" valign="middle" rowspan="3" nowrap>
      <img src="./img/delete.png" style="cursor:pointer" id="eliminarmateria{orden}" nombre="materias[{orden}][eliminarmateria]" value="-" />
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle" colspan="2" nowrap>Nombre *:&nbsp;
      <input type="text" name="materias[{orden}][nombre]" id="nombre{orden}" size="60" value="{nombre}" readonly="readonly" /><span id="divNombreMateria{orden}"></span>
    </td>
    <td align="left" valign="middle" nowrap>CRN:&nbsp;
      <input type="text" name="materias[{orden}][crn]" id="crn{orden}" size="10" value="{crn}" readonly="readonly" /><span id="divCrnMateria{orden}"></span>
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle" colspan="2" nowrap>Horas Semanales *:&nbsp;
      <select name="materias[{orden}][horassemanales]" id="horassemanales{orden}">
        {selectHorasSemanalesD}
      </select>
	</td>
    <td align="left" valign="middle" nowrap>Valor Hora *:&nbsp;
      <input type="text" name="materias[{orden}][valorhora]" id="valorhora{orden}" size="15" value="{valorhoraD}" />
      <script type="text/javascript">
        $("#valorhora{orden}").format({precision: 0,autofix:true});
      </script>
	</td>
  </tr>
</table>
</div>
<script language="JavaScript">
/*
	$("#materia{orden}").ready(function(){
		cambioMateria({orden}, '{seccion}');
	});
	$("#seccion{orden}").ready(function(){
		cambioSeccion({orden});
	});
*/
    $("#buscarmateria{orden}").click(function () {
      buscarMateria({orden});
    });
    $("#eliminarmateria{orden}").click(function () {
      eliminarMateria({orden});
    });
</script>
<!-- END TABLAMATERIA -->
</div>
<div id="divTablaTipoLaborD">
<table border="0" cellspacing="0" cellpadding="4" width="100%" class="sin_borde">
  <tr>
    <td align="center" valign="middle" colspan="2" nowrap>
      <input type="button" id="adicionarmateria" nombre="adicionarmateria" value="Adicionar Materia" class="button" />
    </td>
  </tr>
</table>
</div>
<script language="JavaScript">
	$("#divTablaMateria").{divTablaMateria}();
	$("#divTablaTipoLabor").{divTablaTipoLabor}();
	$("#divTablaTipoLaborI").{divTablaTipoLaborI}();
	$("#divTablaTipoLaborD").{divTablaTipoLaborD}();
	var numeroMaterias = {numeromaterias};
	var minHoras = {minhoras};
	var maxHoras = {maxhoras};
    $("#adicionarmateria").click(function () {
      adicionarMateria();
    });
</script>

<div id="divTablaDistribucion">
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>Distribuci&oacute;n de Costos</h1></td>
  </tr>
</table>
<!-- BEGIN TABLADISTRIBUCION -->
<div id="divTablaDistribucion{ordenD}">
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
    <td align="left" valign="middle" nowrap>Tipo Objeto *:&nbsp;
      <select name="distribucion[{ordenD}][tipoobjeto]" id="tipoobjeto{ordenD}" onchange="cambioTipoObjeto({ordenD})">
        {selectTipoObjeto}
      </select>
    </td>
    <td align="left" valign="middle" nowrap>Objeto de Costo *:&nbsp;
      <select name="distribucion[{ordenD}][objetocosto]" id="objetocosto{ordenD}">
        {selectObjetoCosto}
      </select><span id="divObjetoCosto{ordenD}"></span>
    </td>
    <td align="left" valign="middle" rowspan="3" nowrap>
      <img src="./img/delete.png" style="cursor:pointer" id="eliminardistribucion{ordenD}" nombre="distribucion[{ordenD}][eliminardistribucion]" value="-" />
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle" colspan="2" nowrap>Fondo Presupuestal *:&nbsp;
      <select name="distribucion[{ordenD}][fondopresupuestal]" id="fondopresupuestal{ordenD}">
        {selectFondoPresupuestal}
      </select>
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle" colspan="2" nowrap>Porcentaje *:&nbsp;
      <input type="text" name="distribucion[{ordenD}][porcentaje]" id="porcentaje{ordenD}" size="10" value="{porcentaje}" />
      <script type="text/javascript">
        $("#porcentaje{ordenD}").format({precision: 3,autofix:true});
      </script>
	</td>
  </tr>
</table>
</div>
<script language="JavaScript">
    $("#eliminardistribucion{ordenD}").click(function () {
      eliminarDistribucion({ordenD});
    });
</script>
<!-- END TABLADISTRIBUCION -->
</div>
<table border="0" cellspacing="0" cellpadding="4" width="100%" class="sin_borde">
  <tr>
    <td align="center" valign="middle" colspan="2" nowrap>
      <input type="button" id="adicionardistribucion" nombre="adicionardistribucion" value="Adicionar Distribución" class="button" />
    </td>
  </tr>
</table>
<script language="JavaScript">
	var numeroDistribucion = {numerodistribucion};
	{arrayTipoObjeto}
	{arrayFondoPresupuestal}
    $("#adicionardistribucion").click(function () {
      adicionarDistribucion();
    });
	if (numeroDistribucion == 0) {
		adicionarDistribucion();
	}
</script>
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>C&aacute;lculo Auxilio Educativo</h1></td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>Plan de Pagos {vplanpagos}:&nbsp;
      <select name="planpagos[planpagos]" id="planpagos">
        {selectPlanPagos}
      </select>
    </td>
    <td align="left" valign="middle" nowrap>
      <input type="button" id="calcularvalorconvenio" nombre="calcularvalorconvenio" value="Calcular Valor de la Monitoria" class="button" />&nbsp;
      Valor de la Monitoria {vvalor}:
      <input type="text" name="planpagos[valor]" id="valor" size="20" value="{valor}" readonly="readonly" /><span id="divValor"></span>&nbsp;
    </td>
  </tr>
</table>
<script language="JavaScript">
    $("#calcularvalorconvenio").click(function () {
      calcularValorConvenio();
    });
</script>
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
	<td align="center" valign="middle" colspan="3"><h1>Informaci&oacute;n de la Cuenta Bancaria</h1></td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>Tipo {vtipocuenta}:&nbsp;
      <select name="cuenta[tipocuenta]" id="tipocuenta">
        {selectTipoCuenta}
      </select>
    </td>
    <td align="left" valign="middle" nowrap>Banco {vbanco}:&nbsp;
      <select name="cuenta[banco]" id="banco">
        {selectBanco}
      </select>
    </td>
    <td align="left" valign="middle" nowrap>Cuenta {vnumerocuenta}:
      <input type="text" name="cuenta[numerocuenta]" id="numerocuenta" size="30" value="{numerocuenta}" />
      <script type="text/javascript">
        $("#numerocuenta").format({precision: 0,autofix:true});
      </script>
    </td>
  </tr>
</table>

<table border="0" cellspacing="0" cellpadding="4" width="100%" class="sin_borde">
  <tr>
    <td align="center" valign="middle" colspan="2">
      <!-- BEGIN SOLICITAR -->
      <input type="button" name="solicitar" value="Crear Monitoria" onClick="javascript:enviarForma('solicitarConvenio');" class="button" />&nbsp;
      <input type="button" name="volver" value="Volver" onClick="javascript:enviarForma('mostrarValidacionEstudiante');" class="button" />
      <!-- END SOLICITAR -->
      <!-- BEGIN ACTUALIZAR -->
      <input type="button" name="Actualizar" value="Actualizar" onClick="javascript:enviarForma('actualizarConvenio');" class="button" />&nbsp;
      <!-- END ACTUALIZAR -->
      <!-- BEGIN VOLVERLISTADO -->
      <input type="button" name="volver" value="Volver" onClick="javascript:enviarForma('listarConvenios');" class="button" />
      <!-- END VOLVERLISTADO -->
      <!-- BEGIN APROBARLISTADO -->
      <input type="button" name="volver" value="Volver" onClick="javascript:enviarForma('aprobarConvenios');" class="button" />
      <!-- END APROBARLISTADO -->
    </td>
  </tr>
</table>
</form>
{pie}
