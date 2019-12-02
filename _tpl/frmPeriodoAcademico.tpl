{cabezote}
<link href="./js/jscalendar/calendar-blue2.css" rel="stylesheet" type="text/css" ></link>
<script type="text/javascript" src="./js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="./js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="./js/jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="./js/form_validation.js"></script>
<script language="JavaScript" src="./js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="./js/jquery.format.1.05.js" type="text/javascript"></script>
<script language="JavaScript">
	function validarForma(formObject){
		if (document.getElementById("fechainicio").value == "") {
			alert("Seleccione la Fecha de Inicio");
			document.getElementById("fechainicio").focus();
			return false;
		}
		if (document.getElementById("fechafin").value == "") {
			alert("Seleccione la Fecha Fin");
			document.getElementById("fechafin").focus();
			return false;
		}
/*
		if (document.getElementById("fechainicioreceso").value == "") {
			alert("Seleccione la Fecha de Inicio de Receso");
			document.getElementById("fechainicioreceso").focus();
			return false;
		}
		if (document.getElementById("fechafinreceso").value == "") {
			alert("Seleccione la Fecha Fin de Receso");
			document.getElementById("fechafinreceso").focus();
			return false;
		}
*/
		if (document.getElementById("minhoras").value == "") {
			alert("Digite el Minimo Horas");
			document.getElementById("minhoras").focus();
			return false;
		}
		if (document.getElementById("maxhoras").value == "") {
			alert("Digite el Maximo Horas");
			document.getElementById("maxhoras").focus();
			return false;
		}
		if (document.getElementById("minvalorhora").value == "") {
			alert("Digite el Valor Minimo Hora");
			document.getElementById("minvalorhora").focus();
			return false;
		}
		if (document.getElementById("maxvalorhora").value == "") {
			alert("Digite el Valor Maximo Hora");
			document.getElementById("maxvalorhora").focus();
			return false;
		}
		if (document.getElementById("periodosemestre").value == "") {
			alert("Digite el Periodo");
			document.getElementById("periodosemestre").focus();
			return false;
		}
		if (document.getElementById("fechalimite").value == "") {
			alert("Seleccione el Fecha Limite");
			document.getElementById("fechalimite").focus();
			return false;
		}
		if (document.getElementById("fechaPrimerCorte").value == "") {
			alert("Seleccione el Fecha de Primer Corte");
			document.getElementById("fechaPrimerCorte").focus();
			return false;
		}
		if (document.getElementById("fechaSegundoCorte").value == "") {
			alert("Seleccione el Fecha de Segundo Corte");
			document.getElementById("fechaSegundoCorte").focus();
			return false;
		}
		document.getElementById("fecha1").value = document.getElementById("fechaPrimerCorte").value;
		document.getElementById("fecha0").value = document.getElementById("fechaSegundoCorte").value;
		document.getElementById("fecha2").value = document.getElementById("fechaSegundoCorte").value;
		return true;
	}
</script>

<form name="frmPeriodo" id="frmPeriodo" method="post" action="" onSubmit="return validarForma(frmPeriodo);">
{hiddenSession}
<input type="hidden" name="clase" id="clase" value="PeriodoAcademico" />
<input type="hidden" name="controlador" id="controlador" value="Item" />
<input type="hidden" name="metodo" id="metodo" value="usr{accionDB}" />
<input type="hidden" name="periodoacademico" id="periodoacademico" value="{periodoacademico}" />
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>Periodo Acad&eacute;mico</h1></td>
  </tr>
  <!-- BEGIN MENSAJE -->
  <tr>
	<td align="center" valign="middle" colspan="2"><div class="Warning">{mensaje}</div></td>
  </tr>
  <!-- END MENSAJE -->
  <tr>
    <td align="left" valign="middle" nowrap>{vfechainicio}Fecha de Inicio:&nbsp;
      <input type="text" name="fechainicio" id="fechainicio" size="12" value="{fechainicio}" maxlength= "10" readonly="readonly" />
      <img src="./img/btnCalendario.gif" NAME="btFechaInicio" ID="btFechaInicio">
	</td>
    <td align="left" valign="middle" nowrap>{vfechafin}Fecha Fin:&nbsp;
      <input type="text" name="fechafin" id="fechafin" size="12" value="{fechafin}" maxlength= "10" readonly="readonly" />
      <img src="./img/btnCalendario.gif" NAME="btFechaFin" ID="btFechaFin">
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>{vfechainicioreceso}Fecha de Inicio Receso:&nbsp;
      <input type="text" name="fechainicioreceso" id="fechainicioreceso" size="12" value="{fechainicioreceso}" maxlength= "10" />
      <img src="./img/btnCalendario.gif" NAME="btFechaInicioReceso" ID="btFechaInicioReceso">
	</td>
    <td align="left" valign="middle" nowrap>{vfechafinreceso}Fecha Fin Receso:&nbsp;
      <input type="text" name="fechafinreceso" id="fechafinreceso" size="12" value="{fechafinreceso}" maxlength= "10" />
      <img src="./img/btnCalendario.gif" NAME="btFechaFinReceso" ID="btFechaFinReceso">
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>{vminhoras}M&iacute;nimo Horas:&nbsp;
	  <input maxlength="4" type="text" size="6" name="minhoras" id="minhoras" value="{minhoras}" />
      <script type="text/javascript">
        $("#minhoras").format({precision: 0,autofix:true});
      </script>
	</td>
    <td align="left" valign="middle" nowrap>{vmaxhoras}M&aacute;ximo Horas:&nbsp;
	  <input maxlength="4" type="text" size="6" name="maxhoras" id="maxhoras" value="{maxhoras}" />
      <script type="text/javascript">
        $("#maxhoras").format({precision: 0,autofix:true});
      </script>
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>{vminvalorhora}Valor M&iacute;nimo Hora:&nbsp;
	  <input maxlength="6" type="text" size="8" name="minvalorhora" id="minvalorhora" value="{minvalorhora}" />
      <script type="text/javascript">
        $("#minvalorhora").format({precision: 0,autofix:true});
      </script>
	</td>
    <td align="left" valign="middle" nowrap>{vmaxvalorhora}Valor M&aacute;ximo Hora:&nbsp;
	  <input maxlength="6" type="text" size="8" name="maxvalorhora" id="maxvalorhora" value="{maxvalorhora}" />
      <script type="text/javascript">
        $("#maxvalorhora").format({precision: 0,autofix:true});
      </script>
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>{vperiodosemestre}Periodo:&nbsp;
	  <input maxlength="6" type="text" size="8" name="periodosemestre" id="periodosemestre" value="{periodosemestre}" />
      <script type="text/javascript">
        $("#periodosemestre").format({precision: 0,autofix:true});
      </script>
	</td>
    <td align="left" valign="middle" nowrap>{vfechalimite}Fecha l&iacute;mite de inscripci&oacute;n:&nbsp;
      <input type="text" name="fechalimite" id="fechalimite" size="12" value="{fechalimite}" maxlength= "10" readonly="readonly" />
      <img src="./img/btnCalendario.gif" NAME="btFechaLimite" ID="btFechaLimite">
	</td>
  </tr>
</table>
<script type="text/javascript">
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
  Calendar.setup({
    inputField : "fechainicioreceso",
    ifFormat : "%d/%m/%Y",
    showsTime : false,
    button : "btFechaInicioReceso",
    step : 1
  });
  Calendar.setup({
    inputField : "fechafinreceso",
    ifFormat : "%d/%m/%Y",
    showsTime : false,
    button : "btFechaFinReceso",
    step : 1
  });
  Calendar.setup({
    inputField : "fechalimite",
    ifFormat : "%d/%m/%Y",
    showsTime : false,
    button : "btFechaLimite",
    step : 1
  });
</script>
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
	<td align="center" valign="middle" colspan="2"><h1>Plan de Pagos</h1>
	  <input type="hidden" name="planpagos[0][planpagos]" id="planpagos0" value="{planpagos0}" />
	  <input type="hidden" name="planpagos[0][nombre]" id="nombre0" value="100%" />
	  <input type="hidden" name="planpagos[0][aplicafechalimite]" id="aplicafechalimite0" value="S" />
	  <input type="hidden" name="porcentajepagos[0][porcentajepagos]" id="porcentajepagos0" value="{porcentajepagos0}" />
	  <input type="hidden" name="porcentajepagos[0][porcentaje]" id="porcentaje0" value="100" />
	  <input type="hidden" name="porcentajepagos[0][fecha]" id="fecha0" value="{fecha0}" />

	  <input type="hidden" name="planpagos[1][planpagos]" id="planpagos1" value="{planpagos1}" />
	  <input type="hidden" name="planpagos[1][nombre]" id="nombre1" value="50% - 50%" />
	  <input type="hidden" name="planpagos[1][aplicafechalimite]" id="aplicafechalimite1" value="S" />
	  <input type="hidden" name="porcentajepagos[1][porcentajepagos]" id="porcentajepagos1" value="{porcentajepagos1}" />
	  <input type="hidden" name="porcentajepagos[1][porcentaje]" id="porcentaje1" value="50" />
	  <input type="hidden" name="porcentajepagos[1][fecha]" id="fecha1" value="{fecha1}" />
	  <input type="hidden" name="porcentajepagos[2][porcentajepagos]" id="porcentajepagos2" value="{porcentajepagos2}" />
	  <input type="hidden" name="porcentajepagos[2][porcentaje]" id="porcentaje2" value="50" />
	  <input type="hidden" name="porcentajepagos[2][fecha]" id="fecha2" value="{fecha2}" />
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap>{vfechaprimercorte}Fecha Primer Corte:&nbsp;
      <input type="text" name="fechaPrimerCorte" id="fechaPrimerCorte" size="12" value="{fechaPrimerCorte}" maxlength= "10" readonly="readonly" />
      <img src="./img/btnCalendario.gif" NAME="btFechaPrimerCorte" ID="btFechaPrimerCorte">
	</td>
    <td align="left" valign="middle" nowrap>{vfechasegundocorte}Fecha Segundo Corte:&nbsp;
      <input type="text" name="fechaSegundoCorte" id="fechaSegundoCorte" size="12" value="{fechaSegundoCorte}" maxlength= "10" readonly="readonly" />
      <img src="./img/btnCalendario.gif" NAME="btFechaSegundoCorte" ID="btFechaSegundoCorte">
	</td>
  </tr>
</table>
<script type="text/javascript">
  Calendar.setup({
    inputField : "fechaPrimerCorte",
    ifFormat : "%d/%m/%Y",
    showsTime : false,
    button : "btFechaPrimerCorte",
    step : 1
  });
  Calendar.setup({
    inputField : "fechaSegundoCorte",
    ifFormat : "%d/%m/%Y",
    showsTime : false,
    button : "btFechaSegundoCorte",
    step : 1
  });
</script>
<table border="0" cellspacing="0" cellpadding="4" width="100%">
  <tr>
    <td align="center" valign="middle" colspan="2">
      <input type="submit" name="accion" value="{accionDB}" class="button" />
    </td>
  </tr>
</table>
</form>
{pie}